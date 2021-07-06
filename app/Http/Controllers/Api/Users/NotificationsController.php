<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use App\Http\Resources\Users\NotificationResource;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id)
    {
        $user = $this->userService->find($id);
        $notifications = $this->userService->getNotifications($user);

        return NotificationResource::collection($notifications);
    }

    public function indexUnread($id)
    {
        $user = $this->userService->find($id);
        $notifications = $this->userService->getUnreadNotifications($user);

        return NotificationResource::collection($notifications);
    }

    public function markAsRead($id) {
        $user = $this->userService->find($id);

        $result = $this->userService->markNotificationsRead($user, \Request::input('id') ?? []);

        return response()->json(['result' => $result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
