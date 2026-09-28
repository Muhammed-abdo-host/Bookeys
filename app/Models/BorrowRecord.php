<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowRecord extends Model
{
    //
    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
    ];

     protected $casts = [
        'borrowed_at' => 'date',
        'due_date'    => 'date',
        'returned_at' => 'date',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
