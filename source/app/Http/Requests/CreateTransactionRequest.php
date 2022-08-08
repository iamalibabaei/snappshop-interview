<?php

namespace App\Http\Requests;

use App\Models\CreditCard;
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
        return CreditCard::where('card_number', $this->source_card_number)->whereHas('account', function ($query) {
            $query->where('user_id', $this->user()->id);
        })->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'source_card_number' => ['required', 'string', 'exists:credit_cards,card_number', new CreditCardNumberRule()],
            'destination_card_number' => ['required', 'string', 'different:source_card_number', 'exists:credit_cards,card_number', new CreditCardNumberRule()],
            'amount' => ['required', 'int', 'min:10000', 'max:500000000'],
        ];
    }
}
