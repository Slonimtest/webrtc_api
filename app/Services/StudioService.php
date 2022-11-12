<?php

namespace App\Services;

use App\Models\Studio;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class StudioService
 * @package App\Services
 */
class StudioService extends Service
{
    /**
     * Get studio list
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
        $query = Studio::where([]);

        if ($studioId) {
            $query->where('name', $studioId);
        }

        $query->orderBy(($orderBy ?? null) ?: 'id', ($desc ?? null) ? 'DESC' : 'ASC');

        return $query->paginate(($limit ?? null) ?: 10);
    }
    /**
     * Create a new studio
     *
     * @param array $studioData
     * @return Studio
     * @throws BindingResolutionException
     */
    public function create(array $studioData): Studio
    {
        $studio = Studio::create($studioData);

        return $studio;
    }
}
