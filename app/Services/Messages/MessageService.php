<?php

namespace App\Services\Messages;

use App\DTO\Messages\MessageDto;
use App\Entity\Messages\Dialog;
use App\Entity\Messages\Message;
use App\Entity\User\User;
use App\Events\PrivateMessage;

class MessageService
{

    private $dialogService;

    public function __construct(DialogService $dialogService)
    {
        $this->dialogService = $dialogService;
    }

    /**
     * @param MessageDto $dto
     * @return Message
     * @throws \Throwable
     */
    public function createMessage(MessageDto $dto): Message
    {
        $dialog = $this->dialogService->createDialog(
            $dto->getUserFrom()->id,
            $dto->getUserTo()->id
        );

        $message = new Message;
        $message->content = $dto->getContent();
        $message->read = false;
        $message->userFrom()->associate($dto->getUserFrom());
        $message->userTo()->associate($dto->getUserTo());
        $message->dialog()->associate($dialog);
        $message->saveOrFail();

        event(new PrivateMessage($message, $dialog->wasRecentlyCreated));

        // обновляем дату последнего сообщения в диалоге
        $dialog->last_message_time = $message->created_at;
        $dialog->lastMessage()->associate($message);
        $dialog->saveOrFail();

        return $message;
    }

    public function markMessageAsRead(Message $message, User $user): bool
    {
        // проставляем статус прочитано у всех сообщений, которые получил этот пользователь в рамках диалога
        $status = Message::where('id', '<=', $message->id)
            ->where('dialog_id', $message->dialog_id)
            ->where('user_to_id', $user->id)
            ->update(['read' => 1]);
        return $status;
    }

    public function listDialogMessages($dialog_id)
    {
        return Message::where('dialog_id', $dialog_id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
    }

    /**
     * Get user's unread messages count
     * @param User $user
     * @return int
     */
    public function getUnreadCount(User $user): int
    {
        return Message::where('user_to_id', $user->id)
            ->where('read', 0)
            ->count();
    }

}
