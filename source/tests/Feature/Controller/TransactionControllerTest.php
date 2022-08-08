<?php

namespace Tests\Feature\Controller;

use App\Models\CreditCard;
use App\Models\Transaction;
use App\Models\TransactionFee;
use App\Models\User;
use App\Notifications\TransactionReceived;
use App\Notifications\TransactionSent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function tearDown(): void
    {

        $this->refreshDatabase();

        parent::tearDown();
    }

    public function test_ok_transaction()
    {
        // it seems db seeder takes some time to perform but this code runs before it. IT IS SO WEIRD!
        sleep(5);
        Notification::fake();
        $amount = 500000;
        $user = User::where('email', 'iamalibabaei@gmail.com')->first();
        $sourceCard = CreditCard::where('card_number', '6037997551458913')->first();
        $sourceAccount = $sourceCard->account;
        $sourceAccount->balance = 1000000;
        $sourceAccount->save();
        $destCard = CreditCard::where('card_number', '6037997508603397')->first();
        $destAccount = $destCard->account;
        $response = $this->actingAs($user)
            ->postJson(
                '/api/transfer',
                [
                    'source_card_number' => '6037997551458913',
                    'destination_card_number' => '6037997508603397',
                    'amount' => $amount
                ],
            );
        $lastTransaction = Transaction::latest()->first();
        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'id' => $lastTransaction->id,
                    'source_card_id' => $lastTransaction->source_card_id,
                    'destination_card_id' => $lastTransaction->destination_card_id,
                    'amount' => $amount
                ]
            ]);
        self::assertEquals($sourceCard->id, $lastTransaction->source_card_id);
        self::assertEquals($destCard->id, $lastTransaction->destination_card_id);
        self::assertEquals($amount, $lastTransaction->amount);

        $gotSourceCard = CreditCard::where('card_number', '6037997551458913')->first();
        $gotSourceAccount = $gotSourceCard->account;
        self::assertEquals($sourceAccount->balance - $amount - TransactionFee::FEE, $gotSourceAccount->balance);
        $gotDestCard = CreditCard::where('card_number', '6037997508603397')->first();
        $gotDestAccount = $gotDestCard->account;
        self::assertEquals($destAccount->balance + $amount, $gotDestAccount->balance);

        $lastFee = TransactionFee::latest()->first();
        self::assertEquals($lastTransaction->id, $lastFee->transaction_id);
        self::assertEquals(TransactionFee::FEE, $lastFee->amount);

        Notification::assertSentTo(
            [$sourceAccount->user], TransactionSent::class
        );
        Notification::assertSentTo(
            [$destAccount->user], TransactionReceived::class
        );
    }

    public function test_use_another_person_card_number()
    {
        $user = User::where('email', 'iamalibabaei@gmail.com')->first();
        $response = $this->actingAs($user)
            ->postJson(
                '/api/transfer',
                [
                    'source_card_number' => '6037997508603397',
                    'destination_card_number' => '6037998199813964',
                    'amount' => 10000
                ],
            );
        $response->assertStatus(403);
    }

    public function test_less_than_minimum_amount()
    {
        $user = User::where('email', 'iamalibabaei@gmail.com')->first();
        $response = $this->actingAs($user)
            ->postJson(
                '/api/transfer',
                [
                    'source_card_number' => '6037997551458913',
                    'destination_card_number' => '6037998199813964',
                    'amount' => 1000
                ],
            );
        $response->assertStatus(422);
    }

    public function test_more_than_maximum_amount()
    {
        $user = User::where('email', 'iamalibabaei@gmail.com')->first();
        $response = $this->actingAs($user)
            ->postJson(
                '/api/transfer',
                [
                    'source_card_number' => '6037997551458913',
                    'destination_card_number' => '6037998199813964',
                    'amount' => 500000001
                ],
            );
        $response->assertStatus(422);
    }

    public function test_not_enough_money()
    {
        $user = User::where('email', 'iamalibabaei@gmail.com')->first();
        $card = CreditCard::where('card_number', '6037997551458913')->first();
        $account = $card->account;
        $account->balance = 100000;
        $account->save();
        $response = $this->actingAs($user)
            ->postJson(
                '/api/transfer',
                [
                    'source_card_number' => '6037997551458913',
                    'destination_card_number' => '6037998199813964',
                    'amount' => 100000
                ],
            );
        $response->assertStatus(422)
            ->assertJson(['message' => 'Not Enough Money']);
    }
}
