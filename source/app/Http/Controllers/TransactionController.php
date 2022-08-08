<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Service\TransactionService;

class TransactionController extends Controller
{

    private TransactionService $service;

    public function __construct(TransactionService $transactionService)
    {
        $this->service = $transactionService;
    }

    /**
     * transfer requested amount if the user has needed money
     *
     * @param CreateTransactionRequest $request
     * @return TransactionResource
     */
    public function transfer(CreateTransactionRequest $request): TransactionResource
    {
        return new TransactionResource(
            $this->service->transfer($request->source_card_number, $request->destination_card_number, $request->amount)
        );
    }
}
