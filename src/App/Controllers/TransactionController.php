<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, TransactionService};
use App\Services\BalanceService;

class TransactionController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private TransactionService $transactionService,
        private BalanceService $balanceService
    ) {}

    public function createViewAddIncome()
    {
        $userId = (int) $_SESSION['user'];
        $categories = $this->transactionService->getUserIncomeCategories($userId);


        echo $this->view->render("transactions/income.php", [
            'categories'   => $categories,
        ]);
    }

    public function createViewAddExpense()
    {
        $userId = (int) $_SESSION['user'];
        $categories = $this->transactionService->getUserExpenseCategories($userId);
        $paymentMethods = $this->transactionService->getUserPaymentMethods($userId);

        echo $this->view->render("transactions/expense.php", [
            'categories'      => $categories,
            'paymentMethods'  => $paymentMethods,
        ]);
    }

    public function createIncome()
    {

        $userId = (int) $_SESSION['user'];

        if (!empty($_POST['new_income_type'])) {
            $newTypeName = trim($_POST['new_income_type']);
            $this->transactionService->addIncomeCategory($userId, $newTypeName);

            $categories = $this->transactionService->getUserIncomeCategories($userId);
            $lastAdded = end($categories);
            $_POST['type'] = $lastAdded['id'];
        }

        $this->validatorService->validateTransaction($_POST);

        $this->transactionService->saveIncome($_POST);

        redirectTo('/');
    }

    public function createExpense()
    {
        $userId = (int) $_SESSION['user'];

        if (!empty($_POST['new_payment_method'])) {
            $newMethodName = trim($_POST['new_payment_method']);
            $this->transactionService->addPaymentMethod($userId, $newMethodName);

            $methods = $this->transactionService->getUserPaymentMethods($userId);
            $lastAdded = end($methods);
            $_POST['paymentMethod'] = $lastAdded['id'];
        }

        if (!empty($_POST['new_expense_type'])) {
            $newTypeName = trim($_POST['new_expense_type']);
            $this->transactionService->addExpenseCategory($userId, $newTypeName);

            $categories = $this->transactionService->getUserExpenseCategories($userId);
            $lastAdded = end($categories);
            $_POST['type'] = $lastAdded['id'];
        }


        $this->validatorService->validateTransaction($_POST);
        $this->transactionService->saveExpense($_POST);

        redirectTo('/');
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
}
