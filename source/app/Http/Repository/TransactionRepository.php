<?php

namespace App\Http\Repository;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class TransactionRepository extends Repository
{

    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    public function createTransaction(int $sourceCardId, int $destCardId, int $amount): Transaction
    {
        $transaction = $this->model
            ->create(
                [
                    'source_card_id' => $sourceCardId,
                    'destination_card_id' => $destCardId,
                    'amount' => $amount
                ]
            );
        $transaction->save();
        return $transaction;
    }
}
