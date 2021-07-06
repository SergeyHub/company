<?php
namespace App\Services\ClientApplications;

use App\Entity\ClientApplications\ClientApplication;
use App\Dto\ClientApplications\ClientApplicationDto;
use App\Filters\ClientApplicationsFilter;
use App\Mail\ClientApplications\CreatedClientApplication;
use App\Mail\ClientApplications\ClientApplicationAdmin;
use Illuminate\Support\Facades\Mail;

class ClientApplicationService {
    public function create(ClientApplicationDto $dto) {
        $application = new ClientApplication;

        $application->client()->associate($dto->getUserFrom());
        $application->girl()->associate($dto->getGirl());
        $application->userTo()->associate($dto->getUserTo());
        $application->content = $dto->getContent();
        $application->meeting_date = $dto->getMeetingDate();
        $application->phone = $dto->getPhone();
        $application->recall = $dto->getRecall();

        $application->saveOrFail();

        $this->emailApplicationSend($application);

        return $application;
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function emailApplicationSend($application)
    {
        Mail::to($application->userTo)
            ->later(1, new CreatedClientApplication($application));

        Mail::to(config('mail.admin_email'))
            ->later(1, new ClientApplicationAdmin($application));

        return true;
    }

    public function paginateAll(array $params = []) {
        $filter = new ClientApplicationsFilter($params);

        $query = ClientApplication::with('girl')
            ->filter($filter)
            ->orderBy('id', 'desc');

        if(array_key_exists('sort', $params)) {
            $sortOrder = array_key_exists('sortOrder', $params) ? $params['sortOrder'] : 'asc';

            $query->orderBy($params['sort'], $sortOrder);
        }

        return $query->paginate();
    }


    public function delete(ClientApplication $application) {
        $result = $application->delete();
        return $result;
    }
}
