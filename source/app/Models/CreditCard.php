<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'card_number',
    ];

    /**
     * Get the account that owns the card.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the transactions that account made.
     */
    public function startedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'source_card_id', 'id');
    }

    /**
     * Get the transactions that transferred to the account.
     */
    public function endedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'destination_card_id', 'id');
    }
}
