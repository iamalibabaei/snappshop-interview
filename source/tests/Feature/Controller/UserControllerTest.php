<?php

namespace Tests\Feature\Controller;

use App\Models\Account;
use App\Models\CreditCard;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    private function seed_db(): void
    {
        $this->refreshDatabase();
        $user1 = User::factory()->create([
            'name' => 'User One'
        ]);
        $account1 = Account::factory()->for($user1)->create();
        $card1 = CreditCard::factory()->for($account1)->create();
        $card2 = CreditCard::factory()->for($account1)->create();
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

        $user3 = User::factory()->create([
            'name' => 'User Three'
        ]);
        $account3 = Account::factory()->for($user3)->create();
        $card5 = CreditCard::factory()->for($account3)->create();
        $card6 = CreditCard::factory()->for($account3)->create();
        for ($i = 0; $i < 10; $i++) {
            Transaction::factory()->create([
                'source_card_id' => $card5->id,
                'destination_card_id' => $card6->id,
                'amount' => 15000,
                'created_at' => Carbon::now()->addSeconds($i)
            ]);
        }
    }

    public function tearDown(): void
    {

        $this->refreshDatabase();

        parent::tearDown();
    }

    public function test_ok()
    {
        $this->seed_db();

        $response = $this->get(
            '/api/users/most',
        );

        $response->assertOk()
            ->assertJson([
                    "data" => [
                        [
                            "id" => 1,
                            "name" => "User One",
                            "phone_number" => null,
                            "transactions" => [
                                [
                                    "id" => 10,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 9,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 8,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 7,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 6,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 5,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 4,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 3,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 2,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ],
                                [
                                    "id" => 1,
                                    "source_card_id" => 1,
                                    "destination_card_id" => 2,
                                    "amount" => 10000
                                ]],
                        ],
                        [
                            "id" => 2,
                            "name" => "User Two",
                            "phone_number" => null,
                            "transactions" => [
                                [
                                    "id" => 20,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000
                                ],
                                [
                                    "id" => 19,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                [
                                    "id" => 18,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000
                                ],
                                ["id" => 17,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                ["id" => 16,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                ["id" => 15,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                ["id" => 14,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                ["id" => 13,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                ["id" => 12,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000],
                                ["id" => 11,
                                    "source_card_id" => 3,
                                    "destination_card_id" => 4,
                                    "amount" => 20000
                                ]],
                        ],
                        [
                            "id" => 3,
                            "name" => "User Three",
                            "phone_number" => null,
                            "transactions" => [
                                ["id" => 30,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 29,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 28,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 27,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 26,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 25,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 24,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 23,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 22,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000],
                                ["id" => 21,
                                    "source_card_id" => 5,
                                    "destination_card_id" => 6,
                                    "amount" => 15000
                                ]
                            ]
                        ]
                    ]
                ]
            );
    }
}
