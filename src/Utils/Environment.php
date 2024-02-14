<?php

namespace App\Utils;

use Exception;
use Throwable;

$envFilePath = __DIR__.'/../../.env';

try {
    if (!file_exists($envFilePath)) {
        throw new Exception(".env file not found, please, create one");
    }

    $envContent = file_get_contents($envFilePath);

    $envLine = explode(PHP_EOL, $envContent);

    foreach ($envLine as $line) {
        if (empty($line) || strpos($line, "#") === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line);

        $key = trim($key);
        $value = trim($value);

        putenv("$key=$value");
    }
} catch (Throwable $th) {
    include "Views/Errors/{$th->getCode()}.php";
}
