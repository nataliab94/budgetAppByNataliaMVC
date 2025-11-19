<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db) {}

    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE email = :email",
            [
                'email' => $email
            ]
        )->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => ['Email taken']]);
        }
    }

    public function create(array $formData)
    {

        $password = password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 12]);


        $this->db->query(
            "INSERT INTO users (username, email, password)
     VALUES (:username, :email, :password)",
            [
                'username' => $formData['login'], // <-- używamy username
                'email' => $formData['email'],
                'password' => $password
            ]
        );

        $userId = $this->db->id();

        $defaultCategoriesIncome = $this->db->query("SELECT name FROM incomes_category_default")->findAll();

        foreach ($defaultCategoriesIncome as $category) {
            $this->db->query(
                "INSERT INTO incomes_category_assigned_to_users (user_id, name)
             VALUES (:user_id, :name)",
                [
                    'user_id' => $userId,
                    'name' => $category['name'],
                ]
            );
        }


        $defaultCategoriesExpense = $this->db->query("SELECT name FROM expenses_category_default")->findAll();

        foreach ($defaultCategoriesExpense as $category) {
            $this->db->query(
                "INSERT INTO expenses_category_assigned_to_users (user_id, name)
             VALUES (:user_id, :name)",
                [
                    'user_id' => $userId,
                    'name' => $category['name'],
                ]
            );
        }
        $defaultPaymentMethods = $this->db->query("SELECT name FROM payment_methods_default")->findAll();

        foreach ($defaultPaymentMethods as $paymentMethod) {
            $this->db->query(
                "INSERT INTO payment_methods_assigned_to_users (user_id, name)
             VALUES (:user_id, :name)",
                [
                    'user_id' => $userId,
                    'name' => $paymentMethod['name'],
                ]
            );


            session_regenerate_id();
            $_SESSION['user'] = $userId;
        }
    }



    public function login(array $formData)
    {
        $user = $this->db->query("SELECT * FROM users WHERE email = :email", [
            'email' => $formData['email']
        ])->find();

        $passwordsMatch = password_verify(
            $formData['password'],
            $user['password'] ?? ''
        );

        if (!$user || !$passwordsMatch) {
            throw new ValidationException(['password' => ['Invalid credentials']]);
        }

        session_regenerate_id();

        $_SESSION['user'] = $user['id'];
    }

    public function logout(): void
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        $params = session_get_cookie_params();
        setcookie(
            session_name(), // 'PHPSESSID'
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );

        redirectTo('/login');
    }

    public function deleteAccount(int $userId): void
    {

        $this->db->query("DELETE FROM incomes WHERE user_id = :user_id", ['user_id' => $userId]);
        $this->db->query("DELETE FROM expenses WHERE user_id = :user_id", ['user_id' => $userId]);
        $this->db->query("DELETE FROM incomes_category_assigned_to_users WHERE user_id = :user_id", ['user_id' => $userId]);
        $this->db->query("DELETE FROM expenses_category_assigned_to_users WHERE user_id = :user_id", ['user_id' => $userId]);
        $this->db->query("DELETE FROM payment_methods_assigned_to_users WHERE user_id = :user_id", ['user_id' => $userId]);
        $this->db->query("DELETE FROM users WHERE id = :user_id", ['user_id' => $userId]);

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
    }
}
