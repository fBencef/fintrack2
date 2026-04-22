<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    protected $primaryKey = "partner_id";

    protected $fillable = [
        'partner_id',
        'user_id',
        'partner_name',
        'partner_description',
        'partner_is_active'
    ];

    //Referenced by this
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //This is refenreced by
    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class, 'debt_id');
    }
}
