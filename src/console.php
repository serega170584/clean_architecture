<?php

declare(strict_types=1);

include 'class_loader.php';

$container = new \Serega170584\CleanArchitecture\DI\Container();
$accountRepository = $container->getAccountRepository();
$transactionRepository = $container->getTransactionRepository();
$transaction = $container->getTransactionUseCase();
$source = $container->getSource();
$transactionValidator = $container->getTransactionValidator();
$handler = new \Serega170584\CleanArchitecture\Handler\Handler($accountRepository, $transactionRepository, $transaction, $source, $transactionValidator);