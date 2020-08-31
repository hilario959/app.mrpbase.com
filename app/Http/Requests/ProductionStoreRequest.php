<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionStoreRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $products = $this->request->get('products');

        if (!empty($products)) {
            $products = array_filter($products, function ($item) {
                return $item['quantity'] > 0;
            });

            $this->merge(['products' => $products]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'timezone' => 'required',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.order_id' => 'required|exists:orders,id',
            'products.*.quantity' => 'nullable|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'products.required' => __('Add at least one product for production.')
        ];
    }

    public function attributes()
    {
        return [
            'start_at' => __('Start date'),
            'end_at' => __('End date')
        ];
    }
}
