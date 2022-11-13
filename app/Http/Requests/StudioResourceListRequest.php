<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StudioResourceListRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit'    => 'integer',
            'order_by' => 'string',
            'desc'     => 'boolean'
        ];
    }
}
