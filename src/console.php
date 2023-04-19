<?php

declare(strict_types=1);

include 'class_loader.php';

$container = new \Serega170584\CleanArchitecture\DI\Container();

$source = $container->getSource();

$source->addFieldSerializer(\Serega170584\CleanArchitecture\Contract\Model\Transaction::class, 'dueDate', new \Serega170584\CleanArchitecture\Source\Serializer\DateSerializer());
$source->addFieldSerializer(\Serega170584\CleanArchitecture\Contract\Model\Transaction::class, 'type', new \Serega170584\CleanArchitecture\Source\Serializer\TransactionTypeSerializer());

$accountRepository = $container->getAccountRepository();
$transactionRepository = $container->getTransactionRepository();
$transaction = $container->getTransactionUseCase();
$transactionValidator = $container->getTransactionValidator();
$handler = new \Serega170584\CleanArchitecture\Handler\Handler($accountRepository, $transactionRepository, $transaction, $source, $transactionValidator);

var_dump($handler->getAllAccounts());

$account = $accountRepository->getOne(2);
var_dump($handler->getAccountBalance($account));

$transactions = $transactionRepository->getSortedByComment();
var_dump($transactions);