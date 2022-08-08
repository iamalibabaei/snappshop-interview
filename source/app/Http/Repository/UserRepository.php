<?php

namespace App\Http\Repository;


use App\Models\Account;
use App\Models\CreditCard;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }


    public function getWithMostTransactions(int $limit): Collection
    {
        $userTable = $this->model->getTable();
        $accountTable = (new Account())->getTable();
        $creditCardTable = (new CreditCard())->getTable();
        $transactionTable = (new Transaction())->getTable();

        $users = DB::table($userTable)
            ->join($accountTable, $accountTable . '.user_id', '=', $userTable . '.id')
            ->join($creditCardTable, $creditCardTable . '.account_id', '=', $accountTable . '.id')
            ->join($transactionTable, $transactionTable . '.source_card_id', '=', $creditCardTable . '.id')
            ->groupBy('users.id')
            ->orderByRaw('SUM(' . $transactionTable . '.amount) DESC')
            ->limit($limit)
            ->pluck($userTable . '.id');

        return $this->model
            ->whereIn('id', $users)
            ->get();
    }
}
