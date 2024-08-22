<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'condition_id',
        'name',
        'brand',
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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isSoldOut()
    {
        return $this->soldItems()->exists();
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
