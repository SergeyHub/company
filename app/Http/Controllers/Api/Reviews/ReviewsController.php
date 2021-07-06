<?php

namespace App\Http\Controllers\Api\Reviews;

use App\Entity\Review\Review;
use App\Http\Requests\Reviews\StoreRequest;
use App\Http\Requests\Reviews\UpdateRequest;
use App\Http\Resources\Reviews\AdminReviewsResource;
use App\Services\Reviews\ReviewsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewsController extends Controller
{

    private $reviewsService;

    public function __construct(ReviewsService $reviewsService)
    {
        $this->reviewsService = $reviewsService;
        $this->middleware('auth:api')->except(['store', 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return AdminReviewsResource::collection(
            $this->reviewsService->paginate(20, $request->all())
        );
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
        $status = $this->reviewsService->store($request->getDto());
        return response()->json(['success' => $status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return new AdminReviewsResource($review);
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
     * @param  UpdateRequest  $request
     * @param  Review  $review
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Review $review)
    {
        $this->authorize('edit-review', $review);
        $update_result = $this->reviewsService->update($review, $request->getDto());
        return response()->json(['success' => $update_result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $this->authorize('remove-review', $review);
        $result = $review->delete();
        return response()->json(['success' => $result]);
    }
}
