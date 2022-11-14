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

        $i = 0;
        foreach ($studio->studioResources as $resource) {
            if (strpos($resource->url, '/img/')) {
                $urlImg[$i]['id'] = $resource->id;
                $urlImg[$i]['url'] = config('app.url') . $resource->url;
            }
            if (strpos($resource->url, '/logo/')) {
                $urlLogo[$i]['id'] = $resource->id;
                $urlLogo[$i]['url'] = config('app.url') . $resource->url;
            }
            $i += 1;
        }

        $i = 0;
        foreach ($studio->products as $product) {
            $productUrlImg[$i]['id'] = $product->id;
            $productUrlImg[$i]['title'] = $product->title;
            $productUrlImg[$i]['images'] = config('app.url') . $product->images;
            $productUrlImg[$i]['videos'] = config('app.url') . $product->videos;

            $i += 1;
        }

        $settingStudio = $studio->settings->first();
        if ($settingStudio) {
            $setting['id'] = $settingStudio['id'] ?? null;
            $setting['options'] = $settingStudio['options'] ?? null;
        }

        return [
            'id'   => $this->id,
            'name' => $this->name,
            'settings' => $setting ?? null,
            'images' => $urlImg ?? null,
            'logos' => $urlLogo ?? null,
            'products' => $productUrlImg ?? null
        ];
    }
}
