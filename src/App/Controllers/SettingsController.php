<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, SettingsService, UserService};

class SettingsController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private SettingsService $settingsService,
        private UserService $userService

    ) {}

    public function settingsView()
    {
        echo $this->view->render("settings.php");
    }


    public function changeData()
    {
        $data = $_POST;

        $this->validatorService->validateDataToChange($data);
        $userId = (int) $_SESSION['user'];
        $this->settingsService->updateUserData($userId, $data);
        $_SESSION['success'] = "Dane zostały pomyślnie zmienione!";
        redirectTo("/settings");
    }

    public function deleteAccount()
    {
        $userId = (int) $_SESSION['user'];
        $this->userService->deleteAccount($userId);

        redirectTo('/register');
    }
}
