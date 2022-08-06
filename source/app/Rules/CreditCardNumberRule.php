<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CreditCardNumberRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $card = (string)preg_replace('/\D/', '', $value);
        if (strlen($card) != 16 or (!in_array($card[0], [2, 4, 5, 6, 9]))) return false;

        $res = 0;
        for ($i = 0; $i < 16; $i++) {
            $digit = intval($card[$i]);
            if ($i % 2 == 0) {
                $digit *= 2;
                if ($digit >= 10) $digit -= 9;
            }
            $res += $digit;
        }
        return $res % 10 == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message(): array|string
    {
        return __("Invalid Card Number"); // Can add localization if needed
    }
}
