<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debt extends Model
{
    protected $primaryKey = 'debt_id';

    protected $fillable = [
        'debt_id',
        'user_id',
        'currency_id',
        'partner_id',
        'debt_status_id',
        'debt_amount',
        'debt_date_completed',
        'debt_deadline',
        'debt_description',
    ];

    //Referenced by this
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(DebtStatus::class, 'debt_status_id');
    }
}
