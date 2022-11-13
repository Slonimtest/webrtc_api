<?php

namespace App\Http\Resources;

use App\Models\Studio;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StudioResource
 * @package App\Http\Resources
 *
 * @mixin Studio
 *
 * @OA\Schema(title="StudioResource", description="Studio Resource")
 *
 * @OA\Property(property="id", type="integer")
 * @AO\Property(property="name", type="string")
 */
class StudioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws BindingResolutionException
     */
    public function toArray($request)
    {
        $studio = Studio::find($this->id);

        foreach ($studio->studioResources as $resource) {
            $url[] = $resource->url;
        }

        return [
            'id'   => $this->id,
            'name' => $this->name,
            'options' => $studio->settings->first(),
            'url' => $url ?? ''
        ];
    }
}
