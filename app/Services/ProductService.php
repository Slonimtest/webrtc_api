<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Studio;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService extends Service
{
    /**
     * Get product list
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
        $query = Product::where([]);

        $query->orderBy(($orderBy ?? null) ?: 'id', ($desc ?? null) ? 'DESC' : 'ASC');

        return $query->paginate(($limit ?? null) ?: 10);
    }

    /**
     * Create a new product
     *
     * @param array $productData
     * @return Product
     * @throws BindingResolutionException
     */
    public function create(array $productData): Product
    {
        $studio = Studio::where('name', $productData['studio_id'])->first();

        $imagePut = Storage::putFile('/products/' . $studio->id, $productData['image'], ['visibility' => 'public']);
        $imagreUrl = Storage::url($imagePut);

        $videoPut = Storage::putFile('/products/' . $studio->id, $productData['video'], ['visibility' => 'public']);
        $videoUrl = Storage::url($videoPut);

        $toDb = [
            'title' => $productData['title'],
            'studio_id' => $studio->id,
            'images' => $imagreUrl,
            'videos' => $videoUrl
        ];

        $produc = Product::create($toDb);

        return $produc;
    }
}
