<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'transaction_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function transaction()
    {
        return $this->belongsTo(SoldItem::class, 'transaction_id');
    }
}
