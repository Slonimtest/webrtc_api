<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SettingResource
 * @package App\Http\Resources
 *
 * @mixin Setting
 *
 * @OA\Schema(title="SettingResource", description="Setting Resource")
 *
 * @OA\Property(property="id", type="integer")
 * @AO\Property(property="studio_id", type="integer")
 * @AO\Property(property="options", type="string")
 */
class SettingResource extends JsonResource
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
        return [
            'id'        => $this->id,
            'studio_id' => $this->studio_id,
            'options'   => $this->options
        ];
    }
}
