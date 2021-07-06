<?php

namespace App\Http\Controllers\Api\Messages;

use App\Entity\Messages\Message;
use App\Http\Requests\Messages\CreateRequest;
use App\Http\Requests\Messages\ListDialogRequest;
use App\Http\Requests\Messages\MarkAsReadRequest;
use App\Http\Resources\Messages\DialogResource;
use App\Http\Resources\Messages\MessageResource;
use App\Services\Messages\DialogService;
use App\Services\Messages\MessageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{

    private $dialogService, $messageService;

    public function __construct(DialogService $dialogService, MessageService $messageService)
    {
        $this->dialogService = $dialogService;
        $this->messageService = $messageService;
    }

    public function index(Request $request)
    {
        $dialogs = $this->dialogService->getUserDialogs($request->user());
        return DialogResource::collection($dialogs);
    }

    public function create(CreateRequest $request)
    {
        $message = $this->messageService->createMessage($request->getDto());
        return new MessageResource($message);
    }

    public function listDialog(ListDialogRequest $request)
    {
        $messages = $this->messageService->listDialogMessages($request->get('dialog_id'));
        return MessageResource::collection($messages);
    }

    public function markAsRead(MarkAsReadRequest $request)
    {
        $status = $this->messageService->markMessageAsRead(
            Message::find($request->get('id')),
            $request->user()
        );
        return response()->json(compact('status'));
    }

    public function unreadCount(Request $request)
    {
        $unread_count = $this->messageService->getUnreadCount($request->user());
        return response()->json(compact('unread_count'));
    }

}
