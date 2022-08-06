<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionFee;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createBaseInfo(
            [
                'name' => 'User One',
                'email' => 'userone@example.com',
            ]
        );
        $this->createBaseInfo(
            [
                'name' => 'User Two',
                'email' => 'usertwo@example.com',
            ]
        );
        $this->createBaseInfo(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]
        );
        $cards = CreditCard::all();
        $this->createTransactionsForCards($cards, 50);
    }

    private function createBaseInfo(array $userData): void
    {
        $user = User::factory()->create($userData);
        $accounts = Account::factory()
            ->count(3)
            ->for($user)
            ->create();
        for ($i = 0; $i < 5; $i++) {
            CreditCard::factory()
                ->for($accounts->random())
                ->create();
        }

    }

    private function createTransactionsForCards(Collection $cards, int $count = 10): void
    {
        for ($i = 0; $i < $count; $i++) {
            list($sourceCard, $destCard) = $cards->random(2);
            $transaction = Transaction::factory()
                ->create(
                    [
                        'source_card_id' => $sourceCard->id,
                        'destination_card_id' => $destCard->id,
                    ]
                );
            TransactionFee::factory()
                ->create(
                    [
                        'transaction_id' => $transaction->id,
                    ]
                );
        }
    }

}
