<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    // The PK isn't 'id' -  must tell Laravel
    protected $primaryKey = 'currency_id';

    protected $fillable = ['user_id', 'currency_name', 'currency_sign', 'currency_abbreviation', 'is_default_currency'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
