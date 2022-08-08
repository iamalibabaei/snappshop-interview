<?php

namespace Tests\Unit\Model;


use App\Models\Account;
use App\Models\CreditCard;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_user_get_last_transactions()
    {
        $this->refreshDatabase();
        $user = User::factory()->create([
            'name' => 'User One'
        ]);
        $account = Account::factory()->for($user)->create();
        $card1 = CreditCard::factory()->for($account)->create();
        $card2 = CreditCard::factory()->for($account)->create();
        for ($i = 0; $i < 10; $i++) {
            Transaction::factory()->create([
                'source_card_id' => $card1->id,
                'destination_card_id' => $card2->id,
                'amount' => 10000,
                'created_at' => Carbon::now()->addSeconds($i)
            ]);
        }
        $user2 = User::factory()->create([
            'name' => 'User Two'
        ]);
        $account2 = Account::factory()->for($user2)->create();
        $card3 = CreditCard::factory()->for($account2)->create();
        $card4 = CreditCard::factory()->for($account2)->create();
        for ($i = 0; $i < 10; $i++) {
            Transaction::factory()->create([
                'source_card_id' => $card3->id,
                'destination_card_id' => $card4->id,
                'amount' => 20000,
                'created_at' => Carbon::now()->addSeconds($i)
            ]);
        }

        $transactions = $user->getLastTransactions();
        $id = 10;
        foreach ($transactions as $transaction) {
            self::assertEquals($transaction->id, $id);
            $id--;
        }
    }
}
