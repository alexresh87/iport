<?php

namespace App\Http\Requests\offer;

use Illuminate\Foundation\Http\FormRequest;

class OfferStoreRequest extends FormRequest
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
        return [
            'price' =>  'numeric',
            'model' => 'required|max:255',
            'vendor' => 'max:255',
            'url' => 'url',
            'categoryId' => 'required|integer|exists:App\Models\Category,id'
        ];
    }
}
