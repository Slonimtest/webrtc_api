<?php

namespace App\Services;

use App\Models\StudioResource;
use App\Models\Studio;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

/**
 * Class StudioResourceService
 * @package App\Services
 */
class StudioResourceService extends Service
{
    /**
     * Get studioResource list
     *
     * @param int|null $limit
     * @param string|null $orderBy
     * @param bool|null $desc
     * @param string|null $studioId
     *
     * @return LengthAwarePaginator
     */
    public function getList(int $limit = null, string $orderBy = null, bool $desc = null, ?string $studioId = null): LengthAwarePaginator
    {
        $query = StudioResource::where([]);

        if ($studioId) {
            $studio = Studio::where('name', $studioId)->first();
            $query->where('studio_id', $studio->id);
        }

        $query->orderBy(($orderBy ?? null) ?: 'id', ($desc ?? null) ? 'DESC' : 'ASC');

        return $query->paginate(($limit ?? null) ?: 10);
    }

    /**
     * Create a new image
     *
     * @param array $imageData
     * @return StudioResource
     */
    public function create(array $imageData): StudioResource
    {
        $studio = Studio::where('name', $imageData['studio_id'])->first();

        $fileNames = [];
        foreach ($studio->studioResources as $resource) {
            if (strpos($resource->url, '/' . $imageData['type'] . '/')) {
                $fileNames[] = basename($resource->url);
            }
        }

        $newFileName = '';
        if (in_array($imageData['file']->getClientOriginalName(), $fileNames)) {
            $pathinfo = pathinfo($imageData['file']->getClientOriginalName());
            $newFileName = $pathinfo['filename'] . '_1.' . $pathinfo['extension'];
        }

        $file_put = Storage::putFileAs('studios_resources/' . $studio->id . '/' . $imageData['type'], $imageData['file'], empty($newFileName) ? $imageData['file']->getClientOriginalName() : $newFileName);

        $toDb = [
            'studio_id' => $studio->id,
            'url' => config('app.asset_url') . $file_put
        ];

        return StudioResource::create($toDb);
    }

    /**
     * Update existing studio resource
     *
     * @param StudioResource $studioResource
     * @param array $studioResourceData
     */
    public function update(StudioResource $studioResource, array $studioResourceData)
    {
        if (isset($studioResourceData['file'])) {
            !$studioResource->url ?? File::delete(public_path() . '/' . $studioResource->url);
            $file_put = Storage::putFile('studios_resources/' . $studioResource->studio_id . '/' . $studioResourceData['type'], $studioResourceData['file']);
            $studioResourceData['url'] = config('app.asset_url') . $file_put;
        } else {
            !$studioResource->url ?? File::delete(public_path() . '/' . $studioResource->url);
            $studioResourceData['url'] = null;
        }
        $studioResource->update($studioResourceData);
    }

    /**
     * Delete an existing setting
     *
     * @param StudioResource $studioResource
     */
    public function delete(StudioResource $studioResource)
    {
        $studioResource->delete();
    }
}
