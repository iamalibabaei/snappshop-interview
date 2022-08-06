<?php

namespace App\Http\Requests;

use App\Rules\CreditCardNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'source_card_number' => ['required', new CreditCardNumberRule()],
            'destination_card_number' => ['required', new CreditCardNumberRule()],
            'amount' => ['required', 'min:10000', 'max:500000000'],
        ];
    }
}
