<?php
/**
 * Created by PhpStorm.
 * User: daniil
 * Date: 2019-05-10
 * Time: 12:11
 */

namespace App\Services\Users;

use App\DTO\Users\UserUpdateDto;
use App\Entity\Girl\Girl;
use App\Entity\User\User;
use App\Filters\UsersFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function find($userId, $deleted = false) {
        if($deleted) {
            return User::withTrashed()->findOrFail($userId);
        } else {
            return User::findOrFail($userId);
        }
    }

    public function confirmEmail(User $user) {
        return $user->markEmailAsVerified();
    }

    /**
     * @param User $user
     * @param UserUpdateDto $dto
     * @return bool
     * @throws \Throwable
     */
    public function update(User $user, UserUpdateDto $dto)
    {
        if($dto->getPassword())
            $user->password = Hash::make($dto->getPassword());

        if($dto->getRole())
            $user->role = $dto->getRole();

        if($dto->getEmail())
            $user->email = $dto->getEmail();

        if($dto->isReceiveNotifications() !== null)
            $user->receive_notifications = $dto->isReceiveNotifications();

        // если меняется тип аккаунта
        if($dto->getType() && $dto->getType() !== $user->type) {

            if($dto->getType() == User::TYPE_CLIENT) {
                // восстанавливаем или создаем анкету клиента
                $client = $user->client()->withTrashed()->first();
                if(!$client) {
                    $user->client()->create();
                } else {
                    $client->restore();
                }

                // анкету модели удаляем, если она была
                if($user->girl)
                    $user->girl->delete();
            }

            if($dto->getType() == User::TYPE_GIRL) {
                // восстанавливаем или создаем анкету девушки
                $girl = $user->girl()->withTrashed()->first();
                if(!$girl) {
                    $user->girl()->create();
                } else {
                    $girl->restore();
                }

                // анкету клиента удаляем, если она была
                if($user->client)
                    $user->client->delete();
            }

            $user->type = $dto->getType();
        }

        return $user->saveOrFail();
    }

    public function getUserGirls(User $user)
    {
        return Girl::where('status', '!=',Girl::STATUS_WAIT)
            ->where('user_id', $user->id)
            ->get();
    }

    public function getGirlsByGirl(User $user)
    {
        return Girl::where('user_id', $user->id)
            ->get();
    }

    public function paginate(int $count, array $params = [])
    {
        $filter = new UsersFilter($params);

        $query = User::filter($filter)
            ->withTrashed();

        if(array_key_exists('sort', $params)) {
            $sortOrder = array_key_exists('sortOrder', $params) ? $params['sortOrder'] : 'asc';

            $query->orderBy(DB::raw($params['sort']. ' IS NULL'));
            $query->orderBy($params['sort'], $sortOrder);
        }

        return $query->paginate($count);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }


    public function findByQuery($query) {
        return User::where($query)->firstOrFail();
    }


    public function ban(User $user): bool {
        $user->status = User::STATUS_BLOCKED;
        $user->save();
        return (boolean) $user->delete();
    }

    public function unban(User $user): bool {
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        return (boolean) $user->restore();
    }

    public function getNotifications(User $user) {
        return $user->notifications;
    }

    public function getUnreadNotifications(User $user) {
        return $user->unreadNotifications;
    }

    public function markNotificationsRead(User $user, $ids = []) {
        if(gettype($ids) == 'string') $ids = [$ids];

        foreach ($user->notifications as $notification) {
            if(count($ids) == 0 || in_array($notification->id, $ids)) {
                $notification->markAsRead();
            }
        }

        return true;
    }
}
