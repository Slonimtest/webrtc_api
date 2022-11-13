<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudioCreateRequest;
use App\Http\Requests\StudioListRequest;
use App\Http\Resources\StudioResource;
use Illuminate\Http\JsonResponse;
use App\Services\StudioService;

class StudioController extends ApiController
{
    /**
     * @param StudioService $service
     */
    public function __construct(protected StudioService $service)
    {
    }

    /**
     * Display a listing of the studios.
     *
     * @OA\Get(
     *     path="/api/studios",
     *     operationId="StudioList",
     *     tags={"Studios"},
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
     *
     * @param StudioListRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(StudioListRequest $request): JsonResponse
    {
        $studios = $this->service->getList(
            $request->limit,
            $request->order_by,
            $request->desc,
            $request->studio_id
        );

        return $this->successResponseWithData([
            'list' => StudioResource::collection($studios),
            'listCount' => $studios->total(),
            'lastPage'  => $studios->lastPage(),
        ]);
    }

    /**
     * Store a newly created studio in storage.
     *
     * @OA\Post(
     *     path="/api/v1/studios",
     *     operationId="StudioCreate",
     *     tags={"Stidios"},
     *     @OA\Parameter(
     *      name="name", in="query", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Created a new studio"),
     *     @OA\Response(response="403", description="Parameters are forbidden")
     * )
     *
     * @param StudioCreateRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function store(StudioCreateRequest $request): JsonResponse
    {
        $studio = $this->service->create($request->validated());

        return $this->successResponseWithData(new StudioResource($studio));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
