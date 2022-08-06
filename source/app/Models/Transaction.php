<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source_card_id',
        'destination_card_id',
        'amount',
    ];

    /**
     * Get the source credit card of the transaction.
     */
    public function sourceCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class, 'source_card_id', 'id');
    }

    /**
     * Get the destination credit card of the transaction.
     */
    public function destinationCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class, 'destination_card_id', 'id');
    }

    /**
     * Get the fee associated with the transaction.
     */
    public function fee(): HasOne
    {
        return $this->hasOne(TransactionFee::class);
    }
}
