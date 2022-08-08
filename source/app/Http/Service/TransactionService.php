<?php

namespace App\Http\Service;

use App\Events\TransactionCreated;
use App\Http\Exception\NoAccountWithThisCardException;
use App\Http\Exception\NotEnoughMoneyException;
use App\Http\Repository\AccountRepository;
use App\Http\Repository\CreditCardRepository;
use App\Http\Repository\TransactionRepository;
use App\Models\Transaction;
use App\Models\TransactionFee;

use Illuminate\Support\Facades\DB;

class TransactionService
{
    private TransactionRepository $transactionRepository;
    private AccountRepository $accountRepository;
    protected CreditCardRepository $cardRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        CreditCardRepository $cardRepository,
        AccountRepository     $accountRepository,
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * transfer requested amount
     * @param string $sourceCardNumber
     * @param string $destCardNumber
     * @param int $amount
     * @return Transaction created transaction
     */
    public function transfer(string $sourceCardNumber, string $destCardNumber, int $amount): Transaction
    {
        $transaction = DB::transaction(function () use ($amount, $destCardNumber, $sourceCardNumber) {
            $totalAmount = $amount + TransactionFee::FEE;

            $sourceAccount = $this->accountRepository->getByCurdNumber($sourceCardNumber);
            if (!$sourceAccount) {
                throw new NoAccountWithThisCardException();
            }
            if (!$sourceAccount->hasEnoughMoney($totalAmount)) {
                throw new NotEnoughMoneyException();
            }
            $destAccount = $this->accountRepository->getByCurdNumber($destCardNumber);
            if (!$destAccount) {
                throw new NoAccountWithThisCardException();
            }
            $sourceAccount->decreaseBalance($totalAmount);
            $destAccount->increaseBalance($amount);
            $sourceCard = $this->cardRepository->getByCardNumber($sourceCardNumber);
            $destCard = $this->cardRepository->getByCardNumber($destCardNumber);
            return $this->transactionRepository->createTransaction($sourceCard->id, $destCard->id, $amount);
        });
        event(new TransactionCreated($transaction));
        return $transaction;
    }
}
