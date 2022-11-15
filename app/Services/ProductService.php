<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Studio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        $imagePut = null;
        $videoPut = null;

        if (isset($productData['image'])) {
            $imagePut = Storage::putFile('products/' . $studio->id, $productData['image']);
            $imagreUrl = config('app.asset_url') . $imagePut;
        }

        if (isset($productData['video'])) {
            $videoPut = Storage::putFile('products/' . $studio->id, $productData['video']);
            $videoUrl = config('app.asset_url') . $videoPut;
        }

        $toDb = [
            'title' => $productData['title'],
            'studio_id' => $studio->id,
            'images' => $imagreUrl ?? null,
            'videos' => $videoUrl ?? null
        ];

        $produc = Product::create($toDb);

        return $produc;
    }

    /**
     * Update an existing product
     *
     * @param Product $product
     * @param array $productData
     */
    public function update(Product $product, $productData)
    {

        if (isset($productData['image'])) {
            // !$product->images ?? Storage::disk('local')->delete($product->images);
            !$product->images ?? File::delete(public_path() . '/' . $product->images);
            $imagePut = Storage::putFile('products/' . $product->studio_id, $productData['image']);
            $imagreUrl = config('app.asset_url') . $imagePut;
            $productData['images'] = $imagreUrl;
        } else {
            // !$product->images ?? Storage::disk('local')->delete($product->images);
            !$product->images ?? File::delete(public_path() . '/' . $product->images);
            $productData['images'] = null;
        }

        if (isset($productData['video'])) {
            // !$product->videos ?? Storage::disk('local')->delete($product->videos);
            !$product->images ?? File::delete(public_path() . '/' . $product->videos);
            $videoPut = Storage::putFile('products/' . $product->studio_id, $productData['video']);
            $videoUrl = config('app.asset_url') . $videoPut;
            $productData['videos'] = $videoUrl;
        } else {
            // !$product->videos ?? Storage::disk('local')->delete($product->videos);
            !$product->images ?? File::delete(public_path() . '/' . $product->videos);
            $productData['videos'] = null;
        }

        $product->update($productData);
    }

    /**
     * Delete an existing product
     *
     * @param Product $product
     */
    public function delete(Product $product)
    {
        $product->delete();
    }
}
