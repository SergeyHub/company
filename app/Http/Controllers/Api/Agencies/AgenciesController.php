<?php

namespace App\Http\Controllers\Api\Agencies;

use App\Entity\Agency\Agency;
use App\Http\Requests\Agencies\UpdateRequest;
use App\Http\Requests\Agencies\UploadAvatarRequest;
use App\Http\Resources\Agencies\AgencyPublicResource;
use App\Services\Agencies\AgencyService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgenciesController extends Controller
{

    /** @var AgencyService */
    private $agencyService;

    public function __construct(AgencyService $agencyService)
    {
        $this->agencyService = $agencyService;
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $agencies = $this->agencyService->paginatePublishedAgencies($request->all());
        return AgencyPublicResource::collection($agencies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param $id
     * @return AgencyPublicResource
     */
    public function show($id)
    {
        $agency = $this->agencyService->findPublishedAgency($id);
        return new AgencyPublicResource($agency);
    }

    /**
     * @param UpdateRequest $request
     * @param Agency $agency
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function update(UpdateRequest $request, Agency $agency)
    {
        $this->authorize('update-agency', $agency);
        $status = $this->agencyService->update(
            $agency,
            $request->getDto()
        );
        return response()->json(['success' => $status]);
    }

    /**
     * @param $id
     * @param UploadAvatarRequest $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadAvatar($id, UploadAvatarRequest $request)
    {
        $agency = $this->agencyService->find($id);
        $this->authorize('update-agency', $agency);

        $media = $this->agencyService->uploadAvatar(
            $agency,
            $request->file('file')
        );

        return [
            'success' => true,
            'url' => $media->getUrl(),
            'media_id' => $media->id
        ];
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
