<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class BalanceService
{
    public function __construct(private Database $db) {}

    public function getUserIncomes(int $userId, string $startDate, string $endDate): array
    {
        return $this->db->query(
            "SELECT i.id, i.amount, i.date_of_income, c.name AS category, i.income_comment AS description
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
            "SELECT e.id, e.amount, e.date_of_expense AS date, 
                    c.name AS category, p.name AS payment, e.expense_comment AS description
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

    public function getIncomeById(int $id): ?array
    {
        $sql = "SELECT 
                    i.id,
                    i.amount,
                    i.date_of_income AS date,
                    i.income_category_assigned_to_user_id AS category_id,
                    i.income_comment AS description
                FROM incomes i
                WHERE i.id = :id AND i.user_id = :userId";

        return $this->db->query($sql, [
            'id' => $id,
            'userId' => $_SESSION['user']
        ])->find() ?: null;
    }

    public function getIncomeCategories(): array
    {
        return $this->db->query(
            "SELECT id, name 
             FROM incomes_category_assigned_to_users 
             WHERE user_id = :userId",
            ['userId' => $_SESSION['user']]
        )->findAll();
    }

    public function updateIncome(int $id, array $formData): void
    {
        $this->db->query(
            "UPDATE incomes SET 
                income_category_assigned_to_user_id = :category_id,
                amount = :amount,
                date_of_income = :date,
                income_comment = :comment
             WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user'],
                'category_id' => $formData['type'],
                'amount' => $formData['amount'],
                'date' => $formData['date'],
                'comment' => $formData['description'] ?? null,
            ]
        );
    }

    public function getExpenseById(int $id): ?array
    {
        $sql = "SELECT 
                    e.id,
                    e.amount,
                    e.date_of_expense AS date,
                    e.expense_category_assigned_to_user_id AS category_id,
                    e.payment_method_assigned_to_user_id AS payment_method_id,
                    e.expense_comment AS description
                FROM expenses e
                WHERE e.id = :id AND e.user_id = :userId";

        return $this->db->query($sql, [
            'id' => $id,
            'userId' => $_SESSION['user']
        ])->find() ?: null;
    }

    public function getExpenseCategories(): array
    {
        return $this->db->query(
            "SELECT id, name 
             FROM expenses_category_assigned_to_users 
             WHERE user_id = :userId",
            ['userId' => $_SESSION['user']]
        )->findAll();
    }

    public function updateExpense(int $id, array $formData): void
    {
        $this->db->query(
            "UPDATE expenses SET 
                expense_category_assigned_to_user_id = :category_id,
                payment_method_assigned_to_user_id = :payment_method_id,
                amount = :amount,
                date_of_expense = :date,
                expense_comment = :comment
             WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user'],
                'category_id' => $formData['type'],
                'payment_method_id' => $formData['paymentMethod'],
                'amount' => $formData['amount'],
                'date' => $formData['date'],
                'comment' => $formData['description'] ?? null,
            ]
        );
    }

    public function deleteIncome(int $id): void
    {
        $this->db->query(
            "DELETE FROM incomes WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $_SESSION['user']]
        );
    }

    public function deleteExpense(int $id): void
    {
        $this->db->query(
            "DELETE FROM expenses WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $_SESSION['user']]
        );
    }

    public function getTotalIncomes(int $userId): float
    {
        $result = $this->db->query(
            "SELECT SUM(amount) AS total FROM incomes WHERE user_id = :user_id",
            ['user_id' => $userId]
        )->find();

        return (float) ($result['total'] ?? 0);
    }

    public function getTotalExpenses(int $userId): float
    {
        $result = $this->db->query(
            "SELECT SUM(amount) AS total FROM expenses WHERE user_id = :user_id",
            ['user_id' => $userId]
        )->find();

        return (float) ($result['total'] ?? 0);
    }
}
