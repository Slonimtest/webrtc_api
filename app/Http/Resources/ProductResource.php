<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Request;

/**
 * Class ProductResource
 * @package App\Http\Resources
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'studio_id' => $this->studio_id,
            'image'    => $this->images ? config('app.url') . $this->images : null,
            'video'    => $this->videos ? config('app.url') . $this->videos : null
        ];
    }
}
