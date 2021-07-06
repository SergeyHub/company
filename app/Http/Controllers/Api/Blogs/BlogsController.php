<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Entity\Blog\Blog;
use App\Http\Requests\Blogs\CreateRequest;
use App\Http\Requests\Blogs\UpdateRequest;
use App\Http\Resources\Blogs\BlogAdminResource;
use App\Http\Resources\Blogs\BlogResource;
use App\Services\Blogs\BlogsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{

    private $blogsService;

    public function __construct(BlogsService $blogsService)
    {
        $this->blogsService = $blogsService;
        $this->middleware(['auth:api', 'admin'])->except(['index', 'show']);
    }

    public function index()
    {
        $blogs = $this->blogsService->paginateActive(20);
        return BlogResource::collection($blogs);
    }

    public function indexAll()
    {
        $blogs = $this->blogsService->paginateAll(20);
        return BlogAdminResource::collection($blogs);
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
     * @param CreateRequest $request
     * @return BlogResource
     * @throws \Throwable
     */
    public function store(CreateRequest $request)
    {
        $blog = $this->blogsService->create($request->getDto());
        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = $this->blogsService->find($id);
        return new BlogResource($blog);
    }

    /**
     * @param $id
     * @return BlogAdminResource
     */
    public function edit($id)
    {
        $blog = $this->blogsService->find($id);
        return new BlogAdminResource($blog);
    }

    /**
     * @param UpdateRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateRequest $request, Blog $blog)
    {
        $result = $this->blogsService->update($blog, $request->getDto());
        return response()->json(['success' => $result]);
    }

    /**
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Blog $blog)
    {
        return response()->json([
            'success' => $this->blogsService->delete($blog)
        ]);
    }
}
