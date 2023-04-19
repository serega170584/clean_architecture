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
    private ?SourceInterface $source = null;

    private ?AccountRepository $accountRepository = null;

    private ?TransactionRepository $transactionRepository = null;

    private ?BalanceCalculationFactoryInterface $balanceCalculationFactory = null;

    private ?TransactionUseCase $transactionUseCase = null;

    private ?TransactionValidator $transactionValidator = null;

    public function getSource(): SourceInterface
    {
        if (null === $this->source) {
            $this->source = new Source();
        }
        return $this->source;
    }

    public function getAccountRepository(): AccountRepository
    {
        if (null === $this->accountRepository) {
            $this->accountRepository = new AccountRepository($this->getSource());
        }
        return $this->accountRepository;
    }

    public function getTransactionRepository(): TransactionRepository
    {
        if (null === $this->transactionRepository) {
            $this->transactionRepository = new TransactionRepository($this->getSource(), $this->getAccountRepository());
        }
        return $this->transactionRepository;
    }

    public function getBalanceCalculationFactory(): BalanceCalculationFactoryInterface
    {
        if (null === $this->balanceCalculationFactory) {
            $this->balanceCalculationFactory = new BalanceCalculationFactory();
        }
        return $this->balanceCalculationFactory;
    }

    public function getTransactionUseCase(): TransactionUseCaseInterface
    {
        if (null === $this->transactionUseCase) {
            $this->transactionUseCase = new TransactionUseCase($this->getBalanceCalculationFactory());
        }
        return $this->transactionUseCase;
    }

    public function getTransactionValidator(): TransactionValidatorInterface
    {
        if (null === $this->transactionValidator) {
            $this->transactionValidator = new TransactionValidator();
        }
        return $this->transactionValidator;
    }
}
