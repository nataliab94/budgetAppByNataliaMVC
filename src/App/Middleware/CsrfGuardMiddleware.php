<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class CsrfGuardMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        $validMethods = ['POST', 'PATCH', 'DELETE'];

        if (in_array($requestMethod, $validMethods)) {
            $token = $_POST['token'] ?? '';
            if (empty($_SESSION['token']) || $token !== $_SESSION['token']) {
                redirectTo('/');
            }

            unset($_SESSION['token']);
        }

        $next();
    }
}
