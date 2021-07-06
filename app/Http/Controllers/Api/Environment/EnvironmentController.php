<?php

namespace App\Http\Controllers\Api\Environment;

use App\Http\Resources\Geo\CountryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnvironmentController extends Controller
{

    /** Информация текущего города */
    public function getConfig(Request $request)
    {
        return response()->json([
            'country' => config('domain.country') ? new CountryResource(config('domain.country')) : null,
        ]);
    }

}
