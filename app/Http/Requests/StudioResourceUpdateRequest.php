<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StudioResourceUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'      => 'string',
            'file'      => 'file|mimes:jpeg,jpg,png,webp,mp4'
        ];
    }
}
