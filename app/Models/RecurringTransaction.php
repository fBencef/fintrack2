<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecurringTransaction extends Model
{
    protected $primaryKey = 'recurring_id';

    protected $fillable = [
        'user_id',
        'currency_id',
        'category_id',
        'subcategory_id',
        'account_id',
        'recurring_name',
        'recurring_description',
        'recurring_amount',
        'recurring_start_date',
        'recurring_end_date',
        'frequency_type',
        'frequency_intervall',
        'day_of_recurrence',
        'next_execution_date',
        'recurring_is_active',
        'recurring_is_prediction'
    ];

    //This is for Carbon object to work
    protected $casts = [
    'next_execution_date' => 'date',
    'recurring_start_date' => 'date',
    'recurring_end_date' => 'date',
    'recurring_is_active' => 'boolean',
    'recurring_is_prediction' => 'boolean',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    // This is referenced by
}
