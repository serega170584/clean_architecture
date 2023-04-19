<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\DI;

use Serega170584\CleanArchitecture\Contract\Factory\BalanceCalculationFactoryInterface;
use Serega170584\CleanArchitecture\Contract\UseCase\TransactionUseCaseInterface;
use Serega170584\CleanArchitecture\Contract\Validator\TransactionValidatorInterface;
use Serega170584\CleanArchitecture\Domain\Factory\BalanceCalculationFactory;
use Serega170584\CleanArchitecture\Domain\UseCase\TransactionUseCase;
use Serega170584\CleanArchitecture\Domain\Validator\TransactionValidator;
use Serega170584\CleanArchitecture\Database\Repository\AccountRepository;
use Serega170584\CleanArchitecture\Database\Repository\TransactionRepository;
use Serega170584\CleanArchitecture\Source\Source;
use Serega170584\CleanArchitecture\Source\SourceInterface;

class Container
{
    private SourceInterface $source;

    private AccountRepository $accountRepository;

    private TransactionRepository $transactionRepository;

    private BalanceCalculationFactoryInterface $balanceCalculationFactory;

    private TransactionUseCase $transactionUseCase;

    private TransactionValidator $transactionValidator;

    public function getSource(): SourceInterface
    {
        $this->source = new Source();
        return $this->source;
    }

    public function getAccountRepository(): AccountRepository
    {
        $this->accountRepository = new AccountRepository($this->source);
        return $this->accountRepository;
    }

    public function getTransactionRepository(): TransactionRepository
    {
        $this->transactionRepository = new TransactionRepository($this->source, $this->accountRepository);
        return $this->transactionRepository;
    }

    public function getBalanceCalculationFactory(): BalanceCalculationFactoryInterface
    {
        $this->balanceCalculationFactory = new BalanceCalculationFactory();
        return $this->balanceCalculationFactory;
    }

    public function getTransactionUseCase(): TransactionUseCaseInterface
    {
        $this->transactionUseCase = new TransactionUseCase($this->balanceCalculationFactory);
        return $this->transactionUseCase;
    }

    public function getTransactionValidator(): TransactionValidatorInterface
    {
        $this->transactionValidator = new TransactionValidator();
        return $this->transactionValidator;
    }
}
