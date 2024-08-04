<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount', 'expires_at'];

    protected $dates = ['expires_at'];

    public function getExpiresAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class);
    }
}
