<?php

declare(strict_types=1);

include 'class_loader.php';

$container = new \Serega170584\CleanArchitecture\DI\Container();

$source = $container->getSource();

$source->addFieldSerializer(\Serega170584\CleanArchitecture\Contract\Model\Transaction::class, 'dueDate', $container->getDateSerializer());
$source->addFieldSerializer(\Serega170584\CleanArchitecture\Contract\Model\Transaction::class, 'type', $container->getTransactionTypeSerializer());
$unitOfWork = $container->getUnitOfWork();

$accountRepository = $container->getAccountRepository();
$transactionRepository = $container->getTransactionRepository();
$transaction = $container->getTransactionUseCase();
$transactionValidator = $container->getTransactionValidator();
$handler = new \Serega170584\CleanArchitecture\Handler\Handler($accountRepository, $transactionRepository, $transaction, $transactionValidator, $unitOfWork);

var_dump($handler->getAllAccounts());

$account = $accountRepository->getOne(2);
var_dump($handler->getAccountBalance($account));

$handler->operateTransaction(1, 100, 'D', 'W');

$transactions = $transactionRepository->getSortedByDueDate();
var_dump($transactions);

$transactions = $transactionRepository->getSortedByComment();
var_dump($transactions);
