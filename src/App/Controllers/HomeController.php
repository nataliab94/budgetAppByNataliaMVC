<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class HomeController
{
    public function __construct(
        private TemplateEngine $view
    ) {}

    public function home()
    {
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = 3;
        $offset = ($page - 1) * $length;
        $searchTerm = $_GET['s'] ?? null;

        // Dane testowe, zamiast bazy
        $transactions = [
            ['id' => 1, 'description' => 'Salary', 'amount' => 5000, 'date' => '2025-11-01'],
            ['id' => 2, 'description' => 'Gift', 'amount' => 300, 'date' => '2025-11-02'],
            ['id' => 3, 'description' => 'Bonus', 'amount' => 1500, 'date' => '2025-11-03'],
        ];
        $count = count($transactions);

        $lastPage = ceil($count / $length);
        $pages = $lastPage ? range(1, $lastPage) : [];

        $pageLinks = array_map(
            fn($pageNum) => http_build_query([
                'p' => $pageNum,
                's' => $searchTerm
            ]),
            $pages
        );

        echo $this->view->render("index.php", [
            'transactions' => $transactions,
            'currentPage' => $page,
            'previousPageQuery' => http_build_query([
                'p' => $page - 1,
                's' => $searchTerm
            ]),
            'lastPage' => $lastPage,
            'nextPageQuery' => http_build_query([
                'p' => $page + 1,
                's' => $searchTerm
            ]),
            'pageLinks' => $pageLinks,
            'searchTerm' => $searchTerm
        ]);
    }
}
