<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingCreateRequest;
use App\Http\Requests\SettingListRequest;
use App\Http\Resources\SettingResource;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends ApiController
{
    /**
     * @param SettingService $service
     */
    public function __construct(protected SettingService $service)
    {
    }

    /**
     * Display a listing of the setting.
     * @OA\Get(
     *     path="/api/v1/settings",
     *     operationId="SettingList",
     *     tags={"Settings"},
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
     * @param SettingListRequest $request
     * @param JsonResponse
     * @throws BindingResolutionException
     */
    public function index(SettingListRequest $request): JsonResponse
    {
        $settings = $this->service->getList(
            $request->limit,
            $request->order_by,
            $request->desc,
            $request->studio_id
        );

        return $this->successResponseWithData([
            'list' => SettingResource::collection($settings),
            'listCount' => $settings->total(),
            'lastPage' => $settings->lastPage(),
        ]);
    }

    /**
     * Store a newly created setting in storage.
     *
     * @OA\Post(
     *     path="/api/v1/settings",
     *     operationId="SettingCreate",
     *     tags={"Settings"},
     *     @OA\Parameter(
     *      name="name", in="query", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *      name="options", in="query", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Created a new setting"),
     *     @OA\Response(response="403", description="Parameters are forbidden")
     * )
     *
     * @param SettingCreateRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function store(SettingCreateRequest $request): JsonResponse
    {
        $setting = $this->service->create($request->validated());

        return $this->successResponseWithData(new SettingResource($setting));
    }
}
