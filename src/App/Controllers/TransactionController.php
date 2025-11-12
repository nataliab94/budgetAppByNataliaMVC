<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, TransactionService};

class TransactionController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private TransactionService $transactionService
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
}
