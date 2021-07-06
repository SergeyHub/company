<?php

namespace App\Http\Controllers\Api\Geo;

use App\Http\Requests\Cities\CreateRequest;
use App\Http\Requests\Cities\IndexRequest;
use App\Http\Requests\Cities\UpdateRequest;
use App\Http\Resources\Geo\CityResource;
use App\Services\Geo\CityService;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{

    protected $service;

    public function __construct(CityService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        return CityResource::collection($this->service->getCitiesForCountry($request->country_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        return new CityResource($this->service->createFromRequest($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CityResource($this->service->find($id));
    }

    public function getBySlug($slug)
    {
        return new CityResource($this->service->findBySlug($slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        return response()->json([
            'status' => $this->service->updateFromRequest($request, $id)
        ]);
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
