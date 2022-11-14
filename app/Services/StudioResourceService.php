<?php

namespace App\Services;

use App\Models\StudioResource;
use App\Models\Studio;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

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

        $file_put = Storage::putFile('public/studios_resources/' . $studio->id . '/' . $imageData['type'], $imageData['file']);

        $url = Storage::url($file_put);

        $toDb = [
            'studio_id' => $studio->id,
            'url' => $url
        ];

        return StudioResource::create($toDb);
    }
}
