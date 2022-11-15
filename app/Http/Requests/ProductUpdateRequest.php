<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
// use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'string|required',
            'image'     => 'file|mimes:jpeg,jpg,png',
            'video'     => 'file'
        ];
    }
}
