<?php

namespace Tests\Unit\Model;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_has_enough_money()
    {
        $user = User::factory()->create();
        $account = Account::factory()->for($user)->create([
            'balance' => 10000
        ]);
        self::assertFalse($account->hasEnoughMoney(10001));
        self::assertTrue($account->hasEnoughMoney(9999));
    }

    public function test_decrease_balance()
    {
        $user = User::factory()->create();
        $account = Account::factory()->for($user)->create([
            'balance' => 10000
        ]);
        $account->decreaseBalance(10000);
        self::assertEquals(0, $account->balance);
    }

    public function test_increase_balance()
    {
        $user = User::factory()->create();
        $account = Account::factory()->for($user)->create([
            'balance' => 10000
        ]);
        $account->increaseBalance(10000);
        self::assertEquals(20000, $account->balance);
    }
}
