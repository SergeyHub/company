<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Resources\Agencies\AgencyResource;
use App\Http\Resources\Clients\ClientResource;
use App\Http\Resources\Girls\GirlPublicResource;
use App\Http\Resources\Girls\GirlResource;
use App\Services\Girl\GirlService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    protected $girlService;
    protected $userService;

    public function __construct(GirlService $girlService, UserService $userService)
    {
        $this->girlService = $girlService;
        $this->userService = $userService;
    }

    /**
     * Get associated girl with user
     * @param Request $request
     * @return GirlResource
     */
    public function ownGirlProfile(Request $request)
    {
        $this->middleware('girl');
        $girl = $this->girlService->getIndependentForUser($request->user()->id);
        return new GirlResource($girl);
    }

    /**
     * Get associated client with user
     * @param Request $request
     * @return ClientResource
     */
    public function ownClientProfile(Request $request)
    {
        $this->middleware('client');
        return new ClientResource($request->user()->client);
    }

    /**
     * Get associated agency with user
     * @param Request $request
     * @return AgencyResource
     */
    public function ownAgencyProfile(Request $request)
    {
        $this->middleware('agency');
        return new AgencyResource($request->user()->agency);
    }

    /**
     * Get the girls, which user created
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function ownedGirls(Request $request)
    {
        $this->middleware('agency');
        $girls = $this->userService->getUserGirls($request->user());
        return GirlPublicResource::collection($girls);
    }

    /**
     * Get the girls, which girl created
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function ownGirlsProfile(Request $request)
    {
        $this->middleware('girl');
        $girls = $this->userService->getGirlsByGirl($request->user());
        return GirlPublicResource::collection($girls);
    }

}
