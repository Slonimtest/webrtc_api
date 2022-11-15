<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductListRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * @param ProductService $service
     */
    public function __construct(protected ProductService $service)
    {
    }

    /**
     * Display a listing of the product.
     * @OA\Get(
     *     path="/api/v1/products",
     *     operationId="ProdutcList",
     *     tags={"Products"},
     *     @OA\Parameter(
     *      name="limit", in="query", required=false, @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *      name="order_by", in="query", required=false, @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *      name="desc", in="query", required=false, @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *      name="studio_id", in="query", required=false, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Return available companies list"),
     *     @OA\Response(response="403", description="Company is forbidden"),
     *)
     * @param ProductListRequest $request
     * @param JsonResponse
     * @throws BindingResolutionException
     */
    public function index(ProductListRequest $request): JsonResponse
    {
        $products = $this->service->getList();

        return $this->successResponseWithData([
            'list' => ProductResource::collection($products),
            'listCount' => $products->total(),
            'lastPage' => $products->lastPage(),
        ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @OA\Post(
     *     path="/api/v1/products",
     *     operationId="ProductCreate",
     *     tags={"Products"},
     *     @OA\Parameter(
     *      name="title", in="query", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *      name="image", in="query", required=false, @OA\Schema(type="file")
     *     ),
     *     @OA\Parameter(
     *      name="video", in="query", required=false, @OA\Schema(type="file")
     *     ),
     *     @OA\Parameter(
     *      name="studio_id", in="query", required=false, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Created a new setting"),
     *     @OA\Response(response="403", description="Parameters are forbidden")
     * )
     *
     * @param ProductCreateRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function store(ProductCreateRequest $request): JsonResponse
    {
        $product = $this->service->create($request->validated());

        return $this->successResponseWithData(new ProductResource($product));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified product in storage.
     *
     * @OA\Put(
     *     path="/api/v1/products/{id}",
     *     operationId="ProductUpdate",
     *     tags={"Products"},
     *     @OA\Parameter(
     *      name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *      name="title", in="query", required=false, @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *      name="image", in="query", required=false, @OA\Schema(type="file")
     *     ),
     *     @OA\Parameter(
     *      name="video", in="query", required=false, @OA\Schema(type="file")
     *     ),
     *     @OA\Response(response="200", description="Return the updated product"),
     *     @OA\Response(response="403", description="Product is forbidden"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     *
     * @param  ProductUpdateRequest  $request
     * @param  Product  $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $this->service->update($product, $request->validated());

        return $this->successResponseWithData(new ProductResource($product));
    }

    /**
     * Remove the specified product from storage.
     *
     * @OA\Delete(
     *     path="/api/v1/products/{id}",
     *     operationId="ProductDelete",
     *     tags={"Products"},
     *     @OA\Parameter(
     *      name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="The product has been successfuly deleted"),
     *     @OA\Response(response="403", description="The product is forbidden"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->service->delete($product);

        return $this->successResponse();
    }
}
