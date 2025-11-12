<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class AboutController
{
    public function __construct(private TemplateEngine $view) {}

    public function about(): void
    {
        // Wystarczy tylko wyrenderować plik about.php
        echo $this->view->render('about.php');
    }
}
