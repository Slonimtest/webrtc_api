<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingCreateRequest;
use App\Http\Requests\SettingListRequest;
use App\Http\Requests\SettingUpdateRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
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

    /**
     * Update the specified setting in storage.
     *
     * @OA\Put(
     *     path="/api/v1/settings/{id}",
     *     operationId="SettingUpdate",
     *     tags={"Settings"},
     *     @OA\Parameter(
     *      name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *      name="options", in="query", required=false, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Return the updated setting"),
     *     @OA\Response(response="403", description="Setting is forbidden"),
     *     @OA\Response(response="404", description="Setting not found"),
     * )
     *
     * @param SettingUpdateRequest $request
     * @param Setting $setting
     * @return JsonResponse
     */
    public function update(SettingUpdateRequest $request, Setting $setting): JsonResponse
    {
        $this->service->update($setting, $request->validated());

        return $this->successResponseWithData(new SettingResource($setting));
    }

    /**
     * Remove the specified setting from storage.
     *
     * @OA\Delete(
     *     path="/api/v1/settings/{id}",
     *     operationId="SettingDelete",
     *     tags={"Settings"},
     *     @OA\Parameter(
     *      name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="The setting has been successfuly deleted"),
     *     @OA\Response(response="403", description="The setting is forbidden"),
     *     @OA\Response(response="404", description="Setting not found"),
     * )
     *
     * @param Setting $setting
     * @return JsonResponse
     */
    public function destroy(Setting $setting): JsonResponse
    {
        $this->service->delete($setting);

        return $this->successResponse();
    }
}
