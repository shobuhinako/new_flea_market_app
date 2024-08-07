<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'post',
        'address',
        'building',
        'image_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id')->withTimestamps();;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class);
    }

    public function isPowerSeller()
    {
        // `sold_items` テーブルからアイテムを検索し、`items` テーブルで該当のユーザーを取得
        $userId = $this->id;

        $averageRating = SoldItem::join('items', 'sold_items.item_id', '=', 'items.id')
            ->where('items.user_id', $userId)
            ->whereNotNull('sold_items.rating_by_buyer')
            ->average('sold_items.rating_by_buyer');

        // 平均評価が3.5以上であればパワーセラー
        return $averageRating >= 3.5;
    }

    public function updatePowerSellerStatus()
    {
        $this->is_power_seller = $this->isPowerSeller();
        $this->save();
    }
}
