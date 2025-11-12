<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService, UserService};

class BalanceController
{

    public function __construct(
        private TemplateEngine $view,
        private UserService $userService,
        private TransactionService $transactionService
    ) {}



    public function balanceView()
    {
        $userId = (int) $_SESSION['user'];

        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate   = $_GET['end_date'] ?? date('Y-m-d');

        $incomes = $this->transactionService->getUserIncomes($userId, $startDate, $endDate);
        $expenses = $this->transactionService->getUserExpenses($userId, $startDate, $endDate);

        $totalIncomes = array_sum(array_column($incomes, 'amount'));
        $totalExpenses = array_sum(array_column($expenses, 'amount'));

        echo $this->view->render('/balance.php', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'totalIncomes' => $totalIncomes,
            'totalExpenses' => $totalExpenses,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
