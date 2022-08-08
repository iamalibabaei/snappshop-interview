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
        $this->populate(
            [
                'name' => 'User One',
                'email' => 'userone@example.com',
                'phone_number' => '09126522137',
            ]
        );
        $this->populate(
            [
                'name' => 'User Two',
                'email' => 'usertwo@example.com',
                'phone_number' => '09126522137',
            ]
        );
        $this->populate(
            [
                'name' => 'User Three',
                'email' => 'userthree@example.com',
                'phone_number' => '09126522137',
            ]
        );
        $this->populate(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone_number' => '09126522137',
            ]
        );
        $this->createRealData();
        $this->createRealDataTwo();
        $cards = CreditCard::all();
        $this->createTransactionsForCards($cards);
    }

    private function populate(array $userData): void
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

    private function createRealData(): void
    {
        $user = User::factory()->create([
            'name' => 'Ali Babaei',
            'email' => 'iamalibabaei@gmail.com',
            'phone_number' => '09126522137',
        ]);
        $accounts = Account::factory()
            ->count(3)
            ->for($user)
            ->create();
        CreditCard::factory()
            ->for($accounts->random())
            ->create(['card_number' => '6037997551458913']);
        CreditCard::factory()
            ->for($accounts->random())
            ->create(['card_number' => '6037998199813964']);

    }

    private function createRealDataTwo(): void
    {
        $user = User::factory()->create([
            'name' => 'Alo Babaei',
            'email' => 'iamalobabaei@gmail.com',
            'phone_number' => '09126522137',
        ]);
        $accounts = Account::factory()
            ->count(3)
            ->for($user)
            ->create();
        CreditCard::factory()
            ->for($accounts->random())
            ->create(['card_number' => '6037997508603397']);
        CreditCard::factory()
            ->for($accounts->random())
            ->create(['card_number' => '6219861901811441']);
    }

    private function createTransactionsForCards(Collection $cards, int $count = 100): void
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
