<?php

namespace App\Services\Support;

use App\DTO\Support\SupportMessageDto;
use App\Entity\Support\SupportMessage;
use App\Events\SupportMessageCreated;

class MessageService
{

    private $dialogService;

    public function __construct(DialogService $dialogService)
    {
        $this->dialogService = $dialogService;
    }

    /**
     * @param SupportMessageDto $dto
     * @return SupportMessage
     * @throws \Throwable
     */
    public function createMessage(SupportMessageDto $dto): SupportMessage
    {
        $dialog = $this->dialogService->createDialog($dto->getUser()->id);

        $message = new SupportMessage;
        $message->content = $dto->getContent();
        $message->from_admin = $dto->isFromAdmin();
        $message->user()->associate($dto->getUser());
        $message->dialog()->associate($dialog);
        $message->saveOrFail();

        event(new SupportMessageCreated($message));

        return $message;
    }

    public function paginateMessages(int $user_id, int $count=20)
    {
        return SupportMessage::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate($count);
    }

}
