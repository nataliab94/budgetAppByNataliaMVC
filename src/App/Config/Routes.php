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
    $app->post('/transactions/expense', [TransactionController::class, 'createExpense']);
    $app->get('/balance', [BalanceController::class, 'balanceView'])->add(AuthRequiredMiddleware::class);
    $app->get('/settings', [SettingsController::class, 'settingsView'])->add(AuthRequiredMiddleware::class);
    $app->post('/settings', [SettingsController::class, 'changeData'])->add(AuthRequiredMiddleware::class);

    $app->setErrorHandler([ErrorController::class, 'notFound']);
}
