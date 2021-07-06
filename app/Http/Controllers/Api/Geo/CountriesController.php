<?php

namespace App\Http\Controllers\Api\Geo;

use App\Entity\Girl\Girl;
use App\Http\Requests\Countries\CreateRequest;
use App\Http\Requests\Countries\UpdateRequest;
use App\Http\Resources\Geo\CountryResource;
use App\Services\Geo\CountryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountriesController extends Controller
{

    protected $service;

    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return CountryResource::collection($this->service->getAllCountriesWithCities(self::getSection($request)));
    }

    /**
     * Display top of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function top(Request $request)
    {
        return CountryResource::collection($this->service->topCountries(self::getSection($request)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        return new CountryResource($this->service->createFromRequest($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CountryResource($this->service->find($id));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param $slug
     * @return CountryResource
     */
    public function showSlug(Request $request, $slug)
    {
        return new CountryResource($this->service->findBySlug($slug, self::getSection($request)));
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

    /**
     * Get section from Request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function getSection(Request $request)
    {
        $section = $request->section ?? Girl::TYPE_GIRLS;
        return in_array($section, Girl::GIRL_TYPES) || in_array($section, Girl::FILTER_SECTIONS) ? $section : Girl::TYPE_GIRLS;
    }
}
