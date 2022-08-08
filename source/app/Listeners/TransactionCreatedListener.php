<?php

namespace App\Listeners;


use App\Events\TransactionCreated;
use App\Http\Repository\TransactionFeeRepository;
use App\Models\CreditCard;
use App\Notifications\TransactionReceived;
use App\Notifications\TransactionSent;

class TransactionCreatedListener
{
    private TransactionFeeRepository $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionFeeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param TransactionCreated $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        $transaction = $event->transaction;
        $sourceUser = $transaction->sourceCard->account->user;
        $sourceUser->notify(new TransactionSent($transaction->amount));
        $destUser = $transaction->destinationCard->account->user;
        $destUser->notify(new TransactionReceived($transaction->amount));
        $this->repository->createFee($transaction->id);

    }
}
