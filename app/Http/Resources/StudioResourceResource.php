<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Request;

/**
 * Class StudioResourceResource
 * @package App\Http\Resources
 */
class StudioResourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => config('app.url') . $this->url,
        ];
    }
}
