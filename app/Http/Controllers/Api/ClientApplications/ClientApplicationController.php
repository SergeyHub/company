<?php

namespace App\Http\Controllers\Api\ClientApplications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientApplications\ClientApplicationService;
use App\Http\Requests\ClientApplications\CreateRequest as ClientApplicationCreate;
use App\Http\Resources\Clients\ClientApplicationResource;

class ClientApplicationController extends Controller
{
    protected $clientApplicationService = null;

    public function __construct(ClientApplicationService $clientApplicationService) {
        $this->clientApplicationService = $clientApplicationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $applications = $this->clientApplicationService->paginateAll($request->all());
        return ClientApplicationResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientApplicationCreate $request)
    {
        $application = $this->clientApplicationService->create($request->getDto());
        return new ClientApplicationResource($application);
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
