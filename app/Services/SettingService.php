<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Studio;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class SettingService
 * @package App\Services
 */
class SettingService extends Service
{
    /**
     * Get setting list
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
        $query = Setting::where([]);

        if ($studioId) {
            $studio = Studio::where('name', $studioId)->first();
            $query->where('studio_id', $studio->id);
        }

        $query->orderBy(($orderBy ?? null) ?: 'id', ($desc ?? null) ? 'DESC' : 'ASC');

        return $query->paginate(($limit ?? null) ?: 10);
    }

    /**
     * Create a new setting
     *
     * @param array $settingData
     * @return Setting
     * @throws BindingResolutionException
     */
    public function create(array $settingData): Setting
    {
        $studio = Studio::where('name', $settingData['studio_id'])->first();

        if ($studio) {
            $settingData['studio_id'] = $studio->id;
        } else {
            /** @var StudioService $studioService */
            $studioService = app()->make(StudioService::class);
            $studio = $studioService->create(['name' => $settingData['studio_id']]);
            $settingData['studio_id'] = $studio->id;
        }

        $setting = Setting::create($settingData);

        return $setting;
    }
}
