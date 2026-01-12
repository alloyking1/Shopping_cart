<?php

namespace App\Http\Requests;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $cartItem = CartItem::find($this->route('cartItem'));

            if ($cartItem) {
                $product = $cartItem->product;

                if ($this->quantity > $product->stock_quantity) {
                    $validator->errors()->add(
                        'quantity',
                        "Only {$product->stock_quantity} items available in stock."
                    );
                }
            }
        });
    }
}
