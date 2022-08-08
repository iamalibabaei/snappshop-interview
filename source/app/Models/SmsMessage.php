<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'receiver_phone',
        'body',
    ];

}
