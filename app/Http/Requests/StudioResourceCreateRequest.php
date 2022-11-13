<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\File;

/**
 * Class StudioResourceCreateRequest
 * @package App\Http\Requests
 *
 * @property string $studioId
 * @property string $type
 * @property File $file
 */
class StudioResourceCreateRequest extends Request
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
            'type'      => 'string|required',
            'file'      => 'file|required|mimes:jpeg,jpg,png,webp,mp4'
        ];
    }
}
