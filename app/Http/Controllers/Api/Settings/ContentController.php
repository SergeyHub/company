<?php

namespace App\Http\Controllers\Api\Settings;

use App\Entity\Content\Content;
use App\Http\Requests\Contents\UpdateRequest;
use App\Http\Resources\Settings\ContentAdminResource;
use App\Http\Resources\Settings\ContentResource;
use App\Services\Settings\ContentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{

    private $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
        $this->middleware(['auth:api', 'admin'])->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = $this->contentService->getAll();
        return ContentResource::collection($contents);
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
     * Display the specified resource.
     *
     * @param  mixed  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = $this->contentService->find($id);
        return new ContentResource($content);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = $this->contentService->find($id);
        return new ContentAdminResource($content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Content $content)
    {
        $result = $this->contentService->update($content, $request->validated());
        return response()->json(['success' => $result]);
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
