<?php

namespace App\Http\Repository;

use App\Models\Account;

class AccountRepository extends Repository
{

    public function __construct(Account $account)
    {
        parent::__construct($account);
    }

    public function getByCurdNumber(string $cardNumber): ?Account
    {
        return $this->model
            ->whereHas('cards', function ($query) use ($cardNumber) {
                $query->where('card_number', $cardNumber);
            })
            ->lockForUpdate()
            ->first();
    }
}
