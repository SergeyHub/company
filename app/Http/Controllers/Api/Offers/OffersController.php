<?php

namespace App\Http\Controllers\Api\Offers;

use App\Entity\Offer\Offer;
use App\Http\Requests\Offers\CreateRequest;
use App\Http\Requests\Offers\IndexRequest;
use App\Http\Requests\Offers\UpdateRequest;
use App\Http\Resources\Bills\BillResource;
use App\Http\Resources\Offers\OfferPublicInnerResource;
use App\Http\Resources\Offers\OfferPublicResource;
use App\Http\Resources\Offers\OfferResource;
use App\Services\Bills\BillService;
use App\Services\Offers\OfferService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OffersController extends Controller
{

    protected $offerService;
    protected $billService;

    public function __construct(OfferService $offerService, BillService $billService)
    {
        $this->offerService = $offerService;
        $this->billService = $billService;
        $this->middleware('auth:api')->except(['index', 'show', 'buy']);
        $this->middleware('client')->except(['index', 'show', 'buy', 'indexAll', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $params = $request->validated();
        $offers = $this->offerService->paginatePublishedOffers($params);
        return OfferPublicResource::collection($offers);
    }

    public function indexAll(Request $request)
    {
        $bills = $this->offerService->paginate(20, $request->all());
        return OfferResource::collection($bills);
    }

    /**
     * Get user offers
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function ownOffers(Request $request)
    {
        $offers = $this->offerService->paginateUserOffers($request->user());
        return OfferResource::collection($offers);
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
    public function store(CreateRequest $request)
    {
        $offer = $this->offerService->create($request->getDto());
        return new OfferResource($offer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = $this->offerService->findPublishedOffer($id);
        return new OfferPublicInnerResource($offer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->middleware('admin');
        $offer = $this->offerService->find($id);
        return new OfferResource($offer);
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
        $offer = $this->offerService->find($id);
        $this->authorize('edit-offer', $offer);
        $result = $this->offerService->update($offer, $request->getDto());
        return response()->json(['success' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $this->authorize('edit-offer', $offer);
        return response()->json(['success' => $this->offerService->deleteOffer($offer)]);
    }

    /**
     * Создание счета на публикацию предложения
     */
    public function publish(Request $request, $id)
    {
        $offer = $this->offerService->find($id);
        $this->authorize('edit-offer', $offer);
        $bill = $this->billService->createOfferPublicationBill($request->user(), $offer);
        return new BillResource($bill);
    }

    /**
     * Создание счета на покупку доступа к предложению
     */
    public function buy(Request $request, $id)
    {
        $this->middleware('girl');
        $offer = $this->offerService->find($id);
        $bill = $this->billService->createBuyOfferPhoneBill($request->user(), $offer);
        return new BillResource($bill);
    }

}
