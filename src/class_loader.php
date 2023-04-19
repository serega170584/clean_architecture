<?php

declare(strict_types=1);

$currentDir = __DIR__ . '/..';

$currentLevelDirs = [$currentDir];
$nextLevelDirs = [];

function class_autoloader(string $class): void
{
    $currentDir = __DIR__;
    $class = str_replace('Serega170584\\CleanArchitecture\\', '', $class);
    $class = str_replace('\\', '/', $class);
    require_once $currentDir . '/' . $class . '.php';
}

spl_autoload_register('class_autoloader');
