<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    //
    protected $fillable = [
        'title',
        'total_copies',
        'avilable_copies',
        'author_id',
        'category_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    } 


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function borrowRecords(): HasMany
    {
        return $this->hasMany(BorrowRecord::class);
    }

    public function isAvilable(): bool
    {
        return $this->avilable_copies > 0;
    }
}
