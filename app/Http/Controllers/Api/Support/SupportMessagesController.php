<?php

namespace App\Http\Controllers\Api\Support;

use App\Http\Requests\Support\CreateRequest;
use App\Http\Resources\Support\DialogResource;
use App\Http\Resources\Support\MessageResource;
use App\Services\Support\DialogService;
use App\Services\Support\MessageService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportMessagesController extends Controller
{

    protected $messageService, $dialogService;

    public function __construct(MessageService $messageService, DialogService $dialogService)
    {
        $this->messageService = $messageService;
        $this->dialogService = $dialogService;
    }

    /**
     * Выдает историю текущего пользователя
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $messages = $this->messageService->paginateMessages($request->user()->id);
        return MessageResource::collection($messages);
    }

    /**
     * Список последних диалогов (для админов)
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getDialogs()
    {
        $this->middleware('admin');
        $dialogs = $this->dialogService->paginateDialogs();
        return DialogResource::collection($dialogs);
    }

    public function store(CreateRequest $request)
    {
        $message = $this->messageService->createMessage($request->getDto());
        return new MessageResource($message);
    }

    /**
     * Выдача сообщений с пользователем
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getMessages($id)
    {
        $this->middleware('admin');
        $messages = $this->messageService->paginateMessages($id);
        return MessageResource::collection($messages);
    }

}
