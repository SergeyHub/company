<?php

namespace App\Http\Controllers\Api\Girls;

use App\Entity\Girl\Girl;
use App\Http\Requests\Girls\IndexRequest;
use App\Http\Requests\Girls\PublicationRequest;
use App\Http\Requests\Girls\VipPaymentLinkRequest;
use App\Http\Requests\Girls\RemovePhotoRequest;
use App\Http\Requests\Girls\RemoveVideoRequest;
use App\Http\Requests\Girls\SetAvatarRequest;
use App\Http\Requests\Girls\StoreByGirlRequest;
use App\Http\Requests\Girls\StoreRequest;
use App\Http\Requests\Girls\UnverifyRequest;
use App\Http\Requests\Girls\UpdateRequest;
use App\Http\Requests\Girls\UploadCoverRequest;
use App\Http\Requests\Girls\UploadDocumentRequest;
use App\Http\Requests\Girls\UploadHiddenPhotoRequest;
use App\Http\Requests\Girls\UploadPhotoRequest;
use App\Http\Requests\Girls\UploadVideoRequest;
use App\Http\Resources\Bills\BillResource;
use App\Http\Resources\Documents\DocumentResource;
use App\Http\Resources\Girls\GirlAdminResource;
use App\Http\Resources\Girls\GirlPublicProfileResource;
use App\Http\Resources\Girls\GirlPublicResource;
use App\Http\Resources\Girls\GirlResource;
use App\Http\Resources\Girls\GirlVideoResource;
use App\Http\Resources\Reviews\PublicReviewsResource;
use App\Services\Bills\BillService;
use App\Services\Geo\CountryService;
use App\Services\Girl\GirlService;
use App\Services\PaymentGateways\BtcService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GirlsController extends Controller
{

    protected $girlService;
    protected $billService;
    protected $countryService;
    protected $paymentService;

    public function __construct(
        GirlService $girlService,
        BillService $billService,
        CountryService $countryService,
        BtcService $btcService
    )
    {
        $this->middleware('auth:api')->except(['index', 'show', 'randomGirls', 'similarGirls', 'pornstarGirls', 'top50Girls', 'videoGirls', 'keptWomans', 'dating', 'vipGirls', 'shemales', 'travelGirls', 'reviewGirls']);
        $this->girlService = $girlService;
        $this->billService = $billService;
        $this->countryService = $countryService;
        $this->paymentService = $btcService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $girls = $this->girlService->paginatePublishedGirls($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexAll(Request $request)
    {
        $girls = $this->girlService->paginate(20, $request->all());
        return GirlAdminResource::collection($girls);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexAllVip(Request $request)
    {
        $girls = $this->girlService->paginateVip(20, $request->all());
        return GirlVipResource::collection($girls);
    }

    public function randomGirls(IndexRequest $request)
    {
        $girls = $this->girlService->getRandomGirls(
            $request->validated(),
            $request->get('count', 12)
        );
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача порнозвезд
     */
    public function pornstarGirls(IndexRequest $request)
    {
        $girls = $this->girlService->paginatePornstarGirls($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача содержанок
     */
    public function keptWomans(IndexRequest $request)
    {
        $girls = $this->girlService->paginateKeptWomans($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача Vip анкет
     */
    public function vipGirls(IndexRequest $request)
    {
        $girls = $this->girlService->paginateVipGirls($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача девушек из раздела путешествия
     */
    public function travelGirls(IndexRequest $request)
    {
        $girls = $this->girlService->paginateTravelGirls($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача анкет из знакомств
     */
    public function dating(IndexRequest $request)
    {
        $girls = $this->girlService->paginateDating($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача трансов
     */
    public function shemales(IndexRequest $request)
    {
        $girls = $this->girlService->paginateShemales($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача топ 50 моделей
     */
    public function top50Girls(IndexRequest $request)
    {
        $girls = $this->girlService->paginateTop50Girls($request->validated());
        return GirlPublicResource::collection($girls);
    }

    /*
     * Выдача видео девушек
     */
    public function videoGirls(IndexRequest $request)
    {
        $girls = $this->girlService->paginateVideoGirls($request->validated());
        return GirlVideoResource::collection($girls);
    }

    /*
     * Выдача отзывов
     */
    public function reviewGirls(IndexRequest $request)
    {
        $reviews = $this->girlService->paginateReviewGirls($request->validated());
        return PublicReviewsResource::collection($reviews);
    }

    /*
     * Лист желаний
     */
    public function favouriteGirls()
    {
        $favourites = $this->girlService->favourites();
        return GirlPublicResource::collection($favourites);
    }

    /*
     * Выдача похожих моделей для конкретной модели
     */
    public function similarGirls($id)
    {
        $girl = $this->girlService->findPublishedGirl($id);
        $girls = $this->girlService->getRandomGirlsForCountry($girl->country, $id);
        return GirlPublicResource::collection($girls);
    }

    /**
     * Создание пустой модели
     * @param Request $request
     * @return GirlPublicProfileResource
     * @throws \App\Exceptions\ValidationException
     * @throws \Throwable
     */
    public function store(StoreRequest $request)
    {
        $this->middleware('agency');
        $girl = $this->girlService->createAgencyModel($request->user(), $request->type);
        return new GirlPublicProfileResource($girl);
    }

    /**
     * Создание пустой модели
     * @param Request $request
     * @return GirlPublicProfileResource
     * @throws \App\Exceptions\ValidationException
     * @throws \Throwable
     */
    public function storeByGirl(StoreByGirlRequest $request)
    {
        $this->middleware('girl');
        $girl = $this->girlService->createGirlModel($request->user(), $request->type);
        return new GirlPublicProfileResource($girl);
    }

    /**
     * @param $id
     * @return GirlPublicProfileResource
     */
    public function show($id)
    {
        $girl = $this->girlService->findPublishedGirl($id);
        return new GirlPublicProfileResource($girl);
    }

    public function edit($id)
    {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);
        return new GirlResource($girl, true);
    }

    public function issueVip(Request $request, $id) {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);

        $girl = $this->girlService->makeVip($girl, $request->input('days') ?? 30);

        return new GirlResource($girl);
    }

    public function removeVip($id) {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);

        $girl = $this->girlService->removeVip($girl);

        return new GirlResource($girl);
    }

    /**
     * @param UpdateRequest $request
     * @param Girl $girl
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function update(UpdateRequest $request, Girl $girl)
    {
        $this->authorize('update-girl', $girl);
        $result = $this->girlService->update($girl, $request->getDto());
        return response()->json(['success' => $result]);
    }

    public function destroy($id)
    {
        $girl = Girl::find($id);
        $this->authorize('remove-girl', $girl);
        $result = $girl->delete();
        return response()->json(['success' => $result]);
    }

    /**
     * @param UploadCoverRequest $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadAvatar(UploadCoverRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $media = $this->girlService->uploadCover($request->file('file'), $girl);
        return [
            'success' => true,
            'url' => $media->getUrl(),
            'media_id' => $media->id
        ];
    }

    /**
     * @param $id
     * @return array|GirlPublicResource
     */
    public function addToFavourites($id)
    {
        $girl = $this->girlService->find($id);
        $result = $this->girlService->addToFavourite($girl);
        if ($result) {
            return new GirlPublicResource($girl);
        }
        return ['success' => false];
    }

    /**
     * @param $id
     * @return array
     */
    public function removeFromFavourites($id)
    {
        $girl = $this->girlService->find($id);
        $result = $this->girlService->removeFromFavourites($girl);
        return ['success' => $result];
    }

    /**
     * @param UploadDocumentRequest $request
     * @param $id
     * @return DocumentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function uploadDocument(UploadDocumentRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $media = $this->girlService->uploadDocument($request->file('file'), $girl);
        return new DocumentResource($media);
    }

    /**
     * @param UploadPhotoRequest $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadPhoto(UploadPhotoRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $media = $this->girlService->uploadPhoto($request->file('file'), $girl);
        return [
            'success' => true,
            'avatar' => isset($media->custom_properties['avatar'])
                ? $media->custom_properties['avatar']
                : false,
            'url' => $media->getUrl(),
            'id' => $media->id
        ];
    }

    /**
     * @param UploadVideoRequest $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uploadVideo(UploadVideoRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $media = $this->girlService->uploadVideo($request->file('file'), $girl);
        return [
            'success' => true,
            'url' => $media->getUrl(),
            'id' => $media->id
        ];
    }

    /*
     * Лист ненавистных
     */
    public function hiddenGirls(Request $request)
    {
        $user = $request->user();
        $hidden = $this->girlService->hidden($user);
        return GirlPublicResource::collection($hidden);
    }

    public function uploadHiddenPhoto(UploadHiddenPhotoRequest $request, $id)
    {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);
        $media = $this->girlService->uploadHiddenPhoto($request->get('image'), $girl);
        return [
            'success' => true,
            'url' => $media->getUrl(),
            'id' => $media->id
        ];
    }

    /**
     * @param RemovePhotoRequest $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function removePhoto(RemovePhotoRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $result = $this->girlService->removePhoto($girl, $request->get('id'));
        return ['success' => $result];
    }

    /**
     * @param RemoveVideoRequest $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function removeVideo(RemoveVideoRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $result = $this->girlService->removeVideo($girl, $request->get('id'));
        return ['success' => $result];
    }

    /**
     * @param SetAvatarRequest $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function setAvatar(SetAvatarRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $result = $this->girlService->setAvatar($girl, $request->get('id'));
        return ['success' => $result];
    }

    /**
     * Создание счета на публикацию анкеты
     */
    public function publish(PublicationRequest $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('view-girl', $girl);
        $bill = $this->billService->createGirlPublicationBill(
            $request->user(),
            $girl,
            $request->get('tariff')
        );
        return new BillResource($bill);
    }

    /**
     * Создание счета на покупку доступа к модели
     */
    public function buy(Request $request, $id)
    {
        $this->middleware('client');
        $girl = $this->girlService->find($id);
        $bill = $this->billService->createGirlPhoneBill($request->user(), $girl);
        return new BillResource($bill);
    }

    /**
     * Опубликовать девушку
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishProfile(Request $request, $id)
    {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);
        $result = $this->girlService->publish($girl);
        return response()->json(['success' => $result]);
    }

    /**
     * Снять девушку с публикации
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unpublishProfile(Request $request, $id)
    {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);
        $result = $this->girlService->unpublish($girl, $request->get('reason'));
        return response()->json(['success' => $result]);
    }

    public function activate(Request $request, $id)
    {
        $girl = $this->girlService->find($id);
        $this->authorize('update-girl', $girl);
        $girl->activate();
        return response()->json(['success' => true]);
    }

    /**
     * Подтверждение верификации документов/фотографий
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function verify(Request $request, $id)
    {
        $this->middleware('admin');
        $girl = $this->girlService->find($id);
        $result = $this->girlService->verify($girl);
        return response()->json(['success' => $result]);
    }

    /**
     * Отказ в верификации
     * @param UnverifyRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function unverify(UnverifyRequest $request, $id)
    {
        $this->middleware('admin');

        $girl = $this->girlService->find($id);
        $result = $this->girlService->unverify($girl, $request->getDto());

        return response()->json(['success' => $result]);
    }


    /**
     * @param $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToHidden($id) {
        $this->middleware('auth');
        $girl = $this->girlService->find($id);
        $result = $this->girlService->addToHidden($girl, \Request::user());
        return response()->json(['success' => $result]);
    }

    public function setBookmark(\Request $request, $girlId) {
        $this->middleware('auth');
        $girl = $this->girlService->find($girlId);
        $result = $this->girlService->setBookmark($girl, \Request::user(), \Request::input('content'));
        return response()->json(['success' => $result]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromHidden($id) {
        $this->middleware('auth');
        $girl = $this->girlService->find($id);
        $result = $this->girlService->removeFromHidden($girl, \Request::user());
        return response()->json(['success' => $result]);
    }


    public function verification(Request $request) {
        $girls = $this->girlService->byVerification($request->all());

        return GirlAdminResource::collection($girls);
    }

    public function getVipPaymentLink(VipPaymentLinkRequest $request, $id) {
        $girl = $this->girlService->find($id);

        $this->authorize('view-girl', $girl);
        $bill = $this->billService->createGirlVipBill(
            $request->user(),
            $girl,
            $request->get('tariff'),
            $request->cost_type
        );

        $link = $this->paymentService->getPaymentLink($bill);
        return [ 'link' => $link ];
    }
}
