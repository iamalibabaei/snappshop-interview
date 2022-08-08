<?php

namespace Tests\Unit\Rule;

use App\Rules\CreditCardNumberRule;
use Tests\TestCase;

class CreditCardNumberRuleTest extends TestCase
{
    /**
     * @var CreditCardNumberRule $rule
     */
    protected CreditCardNumberRule $rule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new CreditCardNumberRule();
    }

    /**
     * Check that the even number passes
     *
     * @dataProvider validNumbers
     * @param string $cardNumber
     * @return void
     */
    public function test_valid_card_numbers(string $cardNumber)
    {
        $this->assertTrue($this->rule->passes('attr', $cardNumber));
    }

    /**
     * Check that the even number passes
     *
     * @dataProvider invalidNumbers
     * @param string $cardNumber
     * @return void
     */
    public function test_invalid_card_numbers(string $cardNumber)
    {
        $this->assertFalse($this->rule->passes('attr', $cardNumber));
    }

    public function validNumbers(): array
    {
        return [
            ["6037997551458913"],
            ["6037998199813964"],
            ["6274129005473742"],
            // some other inputs
        ];
    }

    public function invalidNumbers(): array
    {
        return [
            ["6037997551458914"],
            ["6037998199813965"],
            ["1234123412341234"],
            // some other inputs
        ];
    }
}
