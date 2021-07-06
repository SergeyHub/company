<?php

namespace App\Entity\FakeReport;

use App\Entity\Girl\Girl;
use Illuminate\Database\Eloquent\Model;

class FakeReport extends Model
{

    public function girl()
    {
        return $this->belongsTo(Girl::class);
    }
}
