<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService};

class SettingsController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService

    ) {}

    public function settingsView()
    {
        echo $this->view->render("settings.php");
    }


    public function changeData()
    {
        $this->validatorService->validateDataToChange($_POST);

        redirectTo("/");
    }
}
