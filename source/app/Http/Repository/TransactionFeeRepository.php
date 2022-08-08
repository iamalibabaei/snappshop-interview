<?php

namespace App\Http\Repository;

use App\Models\TransactionFee;

class TransactionFeeRepository extends Repository
{


    public function __construct(TransactionFee $fee)
    {
        parent::__construct($fee);
    }

    public function createFee($transactionId)
    {
        $this->model
            ->create(
                [
                    'transaction_id' => $transactionId,
                    'amount' => TransactionFee::FEE,
                ]
            )->save();
    }
}
