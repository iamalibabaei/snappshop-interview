<?php

namespace App\Http\Repository;

use App\Models\CreditCard;
use App\Models\Transaction;

class CreditCardRepository extends Repository
{

    public function __construct(CreditCard $card)
    {
        parent::__construct($card);
    }

    public function getByCardNumber(string $cardNumber): CreditCard
    {
        return $this->model
            ->where('card_number', $cardNumber)
            ->first();
    }
}
