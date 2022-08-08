<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'account_number',
        'balance',
    ];

    /**
     * Get the user that owns the account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the cards for the account.
     */
    public function cards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function hasEnoughMoney(int $amount)
    {
        return $this->balance >= $amount;
    }

    public function decreaseBalance($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }

    public function increaseBalance(int $amount)
    {
        $this->balance += $amount;
        $this->save();
    }
}
