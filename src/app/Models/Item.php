<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'condition',
        'name',
        'description',
        'price',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id')->withTimestamps();;
    }

    // ユーザーがお気に入りにしているかどうかを確認するメソッド
    public function isFavoritedBy($user)
    {
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }
}
