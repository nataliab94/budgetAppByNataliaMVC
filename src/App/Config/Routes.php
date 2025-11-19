<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuthController, BalanceController, TransactionController, ErrorController, SettingsController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

function registerRoutes(App $app)
{
    $app->get('/', [HomeController::class, 'home'])->add(AuthRequiredMiddleware::class);
    $app->get('/about', [AboutController::class, 'about']);
    $app->get('/register', [AuthController::class, 'registerView'])->add(GuestOnlyMiddleware::class);
    $app->post('/register', [AuthController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [AuthController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [AuthController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/logout', [AuthController::class, 'logout'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/income', [TransactionController::class, 'createViewAddIncome'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction/income', [TransactionController::class, 'createIncome'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/expense', [TransactionController::class, 'createViewAddExpense'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction/expense', [TransactionController::class, 'createExpense'])->add(AuthRequiredMiddleware::class);
    $app->get('/balance', [BalanceController::class, 'balanceView'])->add(AuthRequiredMiddleware::class);
    $app->get('/settings', [SettingsController::class, 'settingsView'])->add(AuthRequiredMiddleware::class);
    $app->post('/settings', [SettingsController::class, 'changeData'])->add(AuthRequiredMiddleware::class);
    $app->get('/editIncome', [BalanceController::class, 'editIncomeView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editIncome', [BalanceController::class, 'editIncome'])->add(AuthRequiredMiddleware::class);
    $app->get('/editExpense', [BalanceController::class, 'editExpenseView'])->add(AuthRequiredMiddleware::class);
    $app->post('/editExpense', [BalanceController::class, 'editExpense'])->add(AuthRequiredMiddleware::class);
    $app->get('/deleteIncome', [BalanceController::class, 'deleteIncome'])->add(AuthRequiredMiddleware::class);
    $app->get('/deleteExpense', [BalanceController::class, 'deleteExpense'])->add(AuthRequiredMiddleware::class);
    $app->get('/deleteAccount', [SettingsController::class, 'deleteAccount'])->add(AuthRequiredMiddleware::class);






    $app->setErrorHandler([ErrorController::class, 'notFound']);
}
