<?php

namespace App\Http\Controllers\Api\FakeReports;

use App\Http\Requests\FakeReports\StoreRequest;
use App\Services\FakeReports\FakeReportsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FakeReportsController extends Controller
{

    private $fakeReportsService;

    public function __construct(FakeReportsService $fakeReportsService)
    {
        $this->fakeReportsService = $fakeReportsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Создание пустой модели
     * @param StoreRequest $request
     * @throws \App\Exceptions\ValidationException
     * @throws \Throwable
     */
    public function store(StoreRequest $request)
    {
        $status = $this->fakeReportsService->storeFakeReport($request->getDto());
        return response()->json(['success' => $status]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
