<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'options'   => 'nullable',
        ];
    }
}
