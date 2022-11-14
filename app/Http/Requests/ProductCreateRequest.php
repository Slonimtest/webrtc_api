<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductCreateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'studio_id' => 'string|required',
            'title'     => 'string|required',
            'image'     => 'file|mimes:jpeg,jpg,png',
            'video'     => 'file'
        ];
    }
}
