<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Coupon;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;

class ValidCoupon implements Rule
{
    protected $couponCode;
    protected $itemId;
    protected $errors = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($couponCode, $itemId)
    {
        $this->couponCode = $couponCode;
        $this->itemId = $itemId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();
        $user = Auth::user();

        // クーポンの存在確認
        if (!$coupon) {
            $this->errors[] = '無効なクーポンコードです。';
            return false;
        }

        // クーポンの有効期限確認
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            $this->errors[] = 'このクーポンは期限切れです。';
            return false;
        }

        // クーポンの重複使用確認
        $user = Auth::user();
        $alreadyUsed = SoldItem::where('user_id', $user->id)
            ->where('coupon_id', $coupon->id)
            ->exists();

        if ($alreadyUsed) {
            $this->errors[] = 'このクーポンは既に使用済みです。';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errors;
    }
}
