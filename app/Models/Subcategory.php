<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $primaryKey = 'subcategory_id';

    protected $fillable = [
        'subcategory_id',
        'user_id',
        'category_id',
        'subcategory_name',
        'subcategory_description',
        'subcategory_is_active'
    ]

    // Table referenced by this one
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function category(): BelongsTo
    {
        // Allows calling $subcategory->category->category_name
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Tables this is referenced by

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'category_id');
    }

    public function recurringTransactions(): HasMany
    {
        return $this->hasMany(RecurringTransaction::class, 'category_id');
    }

}
