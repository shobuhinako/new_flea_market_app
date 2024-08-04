<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidCoupon;

class ApplyCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $couponCode = $this->input('coupon_code');
        $itemId = $this->input('item_id');

        return [
            'coupon_code' => [new ValidCoupon($couponCode, $itemId)],
        ];
    }
}
