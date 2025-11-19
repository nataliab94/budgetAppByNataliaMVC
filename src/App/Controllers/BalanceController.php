<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService, UserService, ValidatorService};
use App\Services\BalanceService;

class BalanceController
{

    public function __construct(
        private TemplateEngine $view,
        private UserService $userService,
        private TransactionService $transactionService,
        private BalanceService $balanceService,
        private ValidatorService $validatorService
    ) {}



    public function balanceView()
    {
        $userId = (int) $_SESSION['user'];

        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate   = $_GET['end_date'] ?? date('Y-m-d');

        $incomes = $this->balanceService->getUserIncomes($userId, $startDate, $endDate);
        $expenses = $this->balanceService->getUserExpenses($userId, $startDate, $endDate);

        $totalIncomes = array_sum(array_column($incomes, 'amount'));
        $totalExpenses = array_sum(array_column($expenses, 'amount'));


        $balance = $totalIncomes - $totalExpenses;

        echo $this->view->render('/balance.php', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'totalIncomes' => $totalIncomes,
            'totalExpenses' => $totalExpenses,
            'balance' => $balance,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function editIncomeView()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) redirectTo('/balance');

        $income = $this->balanceService->getIncomeById((int)$id);
        if (!$income) {
            $_SESSION['error'] = "Income not found!";
            redirectTo('/balance');
        }

        $categories = $this->balanceService->getIncomeCategories();

        echo $this->view->render("transactions/editIncome.php", [
            'income' => $income,
            'categories' => $categories,
            'errors' => $_SESSION['errors'] ?? [],
            'oldFormData' => $_SESSION['oldFormData'] ?? [],
        ]);
    }


    public function editIncome()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) redirectTo('/balance');

        $userId = (int) $_SESSION['user'];

        if (!empty($_POST['new_income_type'])) {
            $newTypeName = trim($_POST['new_income_type']);
            $this->transactionService->addIncomeCategory($userId, $newTypeName);

            $categories = $this->transactionService->getUserIncomeCategories($userId);
            $lastAdded = end($categories);


            $_POST['type'] = $lastAdded['id'];
        }

        $this->validatorService->validateTransaction($_POST);
        $this->balanceService->updateIncome((int)$id, $_POST);

        redirectTo('/balance');
    }

    public function editExpenseView()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) redirectTo('/balance');
        $expense = $this->balanceService->getExpenseById((int)$id);
        if (!$expense) {
            $_SESSION['error'] = "Expense not found!";
            redirectTo('/balance');
        }


        $categories = $this->balanceService->getExpenseCategories();
        $paymentMethods = $this->transactionService->getUserPaymentMethods((int)$_SESSION['user']);

        echo $this->view->render("transactions/editExpense.php", [
            'expense' => $expense,
            'categories' => $categories,
            'paymentMethods' => $paymentMethods,
            'errors' => $_SESSION['errors'] ?? [],
            'oldFormData' => $_SESSION['oldFormData'] ?? [],
        ]);
    }

    public function editExpense()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) redirectTo('/balance');

        $userId = (int) $_SESSION['user'];


        if (!empty($_POST['new_payment_method'])) {
            $newMethodName = trim($_POST['new_payment_method']);
            $this->transactionService->addPaymentMethod($userId, $newMethodName);

            $methods = $this->transactionService->getUserPaymentMethods($userId);
            $lastAddedMethod = end($methods);

            $_POST['paymentMethod'] = $lastAddedMethod['id'];
        }

        if (!empty($_POST['new_expense_type'])) {
            $newCategoryName = trim($_POST['new_expense_type']);
            $this->transactionService->addExpenseCategory($userId, $newCategoryName);

            $categories = $this->transactionService->getUserExpenseCategories($userId);
            $lastAddedCategory = end($categories);

            $_POST['type'] = $lastAddedCategory['id'];
        }
        $this->validatorService->validateTransaction($_POST);
        $this->balanceService->updateExpense((int)$id, $_POST);

        redirectTo('/balance');
    }
    public function deleteIncome()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) redirectTo('/balance');

        $this->balanceService->deleteIncome((int)$id);
        redirectTo('/balance');
    }

    public function deleteExpense()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) redirectTo('/balance');

        $this->balanceService->deleteExpense((int)$id);
        redirectTo('/balance');
    }
}
