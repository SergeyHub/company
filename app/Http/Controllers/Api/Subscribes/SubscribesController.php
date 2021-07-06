<?php

namespace App\Http\Controllers\Api\Subscribes;

use App\Entity\Subscribes\Subscribe;
use App\Http\Requests\Subscribes\CreateRequest;
use App\Http\Controllers\Controller;

class SubscribesController extends Controller
{

    public function check(CreateRequest $request)
    {
        $subscribe = Subscribe::where([
            'user_id' => $request->user()->id,
            'type' => $request->get('type')
        ])->first();

        return response()->json(['exists' => !is_null($subscribe)]);
    }

    public function subscribe(CreateRequest $request)
    {
        Subscribe::firstOrCreate([
            'user_id' => $request->user()->id,
            'type' => $request->get('type')
        ]);
        return response()->json(['success' => true]);
    }

}
