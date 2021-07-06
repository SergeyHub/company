<?php

namespace App\Services\FakeReports;

use App\DTO\FakeReports\FakeReportsCreateDto;
use App\Entity\FakeReport\FakeReport;

class FakeReportsService
{
    /**
     * @param array $data
     * @param FakeReportsCreateDto $dto
     * @return FakeReport
     * @throws \Throwable
     */
    public function storeFakeReport(FakeReportsCreateDto $dto): FakeReport
    {

        $girl = $dto->getGirl();
        $fakeReport = new FakeReport();
        $fakeReport->report = $dto->getReport();
        $fakeReport->name = $dto->getName();
        $fakeReport->email = $dto->getEmail();

        $girl->fakeReports()->save($fakeReport);

        return $fakeReport;
    }
}
