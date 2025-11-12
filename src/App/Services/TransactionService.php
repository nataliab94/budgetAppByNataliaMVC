<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
    public function __construct(private Database $db) {}

    public function saveIncome(array $formData)
    {
        $formattedDate = $formData['date'];

        $this->db->query(
            "INSERT INTO incomes (
            user_id,
            income_category_assigned_to_user_id,
            amount,
            date_of_income,
            income_comment
        ) VALUES (
            :user_id,
            :category_id,
            :amount,
            :date,
            :comment
        )",
            [
                'user_id'     => $_SESSION['user'],
                'category_id' => $formData['type'],
                'amount'      => $formData['amount'],
                'date'        => $formattedDate,
                'comment'     => $formData['description'] ?? null,
            ]
        );
    }

    public function saveExpense(array $formData)
    {
        $formattedDate = "{$formData['date']}";

        $this->db->query(
            "INSERT INTO expenses(
            user_id,
            expense_category_assigned_to_user_id,
            payment_method_assigned_to_user_id,
            amount,
            date_of_expense,
            expense_comment
        )
        VALUES(:user_id, :type, :paymentMethod, :amount, :date, :description)",
            [
                'user_id' => $_SESSION['user'],
                'type' => $formData['type'],
                'paymentMethod' => $formData['paymentMethod'],
                'amount' => $formData['amount'],
                'date' => $formattedDate,
                'description' => $formData['description'],
            ]
        );
    }

    public function getUserIncomeCategories(int $userId)
    {
        return $this->db->query(
            "SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id = :user_id",
            ['user_id' => $userId]
        )->findAll();
    }

    public function getUserExpenseCategories(int $userId)
    {
        return $this->db->query(
            "SELECT id, name FROM expenses_category_assigned_to_users WHERE user_id = :user_id",
            ['user_id' => $userId]
        )->findAll();
    }
    public function getUserPaymentMethods(int $userId)
    {
        return $this->db->query(
            "SELECT id, name FROM payment_methods_assigned_to_users WHERE user_id = :user_id",
            ['user_id' => $userId]
        )->findAll();
    }

    public function addIncomeCategory(int $userId, string $name)
    {
        $this->db->query(
            "INSERT INTO incomes_category_assigned_to_users (user_id, name)
         VALUES (:user_id, :name)",
            [
                'user_id' => $userId,
                'name' => $name
            ]
        );
    }


    public function addExpenseCategory(int $userId, string $name): void
    {
        $this->db->query(
            "INSERT INTO expenses_category_assigned_to_users (user_id, name)
         VALUES (:user_id, :name)",
            [
                'user_id' => $userId,
                'name' => $name
            ]
        );
    }


    public function addPaymentMethod(int $userId, string $name): void
    {
        $this->db->query(
            "INSERT INTO payment_methods_assigned_to_users (user_id, name)
         VALUES (:user_id, :name)",
            [
                'user_id' => $userId,
                'name' => $name
            ]
        );
    }
    public function getUserIncomes(int $userId, string $startDate, string $endDate): array
    {
        return $this->db->query(
            "SELECT i.amount, i.date_of_income, c.name AS category, i.income_comment AS description
         FROM incomes i
         JOIN incomes_category_assigned_to_users c
           ON i.income_category_assigned_to_user_id = c.id
         WHERE i.user_id = :user_id
           AND i.date_of_income BETWEEN :start AND :end
         ORDER BY i.date_of_income DESC",
            ['user_id' => $userId, 'start' => $startDate, 'end' => $endDate]
        )->findAll();
    }

    public function getUserExpenses(int $userId, string $startDate, string $endDate): array
    {
        return $this->db->query(
            "SELECT e.amount, e.date_of_expense AS date, c.name AS category, p.name AS payment, e.expense_comment AS description
         FROM expenses e
         JOIN expenses_category_assigned_to_users c
           ON e.expense_category_assigned_to_user_id = c.id
         JOIN payment_methods_assigned_to_users p
           ON e.payment_method_assigned_to_user_id = p.id
         WHERE e.user_id = :user_id
           AND e.date_of_expense BETWEEN :start AND :end
         ORDER BY e.date_of_expense DESC",
            ['user_id' => $userId, 'start' => $startDate, 'end' => $endDate]
        )->findAll();
    }
}
