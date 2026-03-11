<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DebtStatus extends Model
{
    protected $primaryKey = 'debt_status_id';

    protected $fillable = [
        'debt_status_id',
        'user_id',
        'debt_status_name',
        'debt_status_color',
        'is_delay'
    ]

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
