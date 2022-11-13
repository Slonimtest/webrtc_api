<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingCreateRequest;
use App\Http\Requests\SettingListRequest;
use App\Http\Requests\StudioResourceCreateRequest;
use App\Http\Requests\StudioResourceListRequest;
use App\Http\Resources\SettingResource;
use App\Http\Resources\StudioResourceResource;
use App\Services\StudioResourceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudioResourceController extends ApiController
{
    /**
     * @param StudioResourceService $service
     */
    public function __construct(protected StudioResourceService $service)
    {
    }

    /**
     * Display a listing of the studio resource.
     * @OA\Get(
     *     path="/api/v1/resources",
     *     operationId="StudioResourceList",
     *     tags={"StudioResources"},
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
     * @param StudioResourceListRequest $request
     * @param JsonResponse
     * @throws BindingResolutionException
     */
    public function index(StudioResourceListRequest $request): JsonResponse
    {
        $studioResources = $this->service->getList(
            $request->limit,
            $request->order_by,
            $request->desc,
            $request->studio_id
        );

        return $this->successResponseWithData([
            'list' => StudioResourceResource::collection($studioResources),
            'listCount' => $studioResources->total(),
            'lastPage' => $studioResources->lastPage(),
        ]);
    }

    /**
     * Upload a new image.
     *
     * @OA\Post(
     *     path="/api/v1/resources",
     *     operationId="StudioResourceCreate",
     *     tags={"Images"},
     *     @OA\Parameter(
     *      name="type", in="query", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *      name="file", in="query", required=true, @OA\Schema(type="file")
     *     ),
     *     @OA\Parameter(
     *      name="studio_id", in="query", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Created a new image"),
     *     @OA\Response(response="403", description="Parameters are forbidden"),
     * )
     *
     * @param StudioResourceCreateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(StudioResourceCreateRequest $request): JsonResponse
    {
        $studioResource = $this->service->create($request->validated());

        return $this->successResponseWithData(new StudioResourceResource($studioResource));
    }
}
