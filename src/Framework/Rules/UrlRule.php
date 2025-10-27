<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class UrlRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return filter_var($data[$field], FILTER_VALIDATE_URL) !== false;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Invalid URL.";
    }
}
