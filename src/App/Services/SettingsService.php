<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class SettingsService
{
    public function __construct(private Database $db) {}

    public function updateUserData(int $userId, array $data): void
    {
        $updateData = [];
        $params = ['id' => $userId];

        if (!empty($data['username'])) {
            $updateData['username'] = $data['username'];
        }

        if (!empty($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (!empty($updateData)) {
            $setParts = [];
            foreach ($updateData as $column => $value) {
                $setParts[] = "$column = :$column";
                $params[$column] = $value;
            }

            $sql = "UPDATE users SET " . implode(', ', $setParts) . " WHERE id = :id";
            $this->db->query($sql, $params);
        }
    }
}
