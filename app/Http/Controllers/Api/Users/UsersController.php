<?php

namespace App\Http\Controllers\Api\Users;

use App\Entity\User\User;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('admin')->except(['update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            $this->userService->paginate(20, $request->all())
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexVip(Request $request)
    {
        return UserResource::collection(
            $this->userService->paginateVip(20, $request->all())
        );
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
    public function show($userId)
    {
        $user = $this->userService->find($userId, true);
        return new UserResource($user);
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmEmail($userId) {
        $this->middleware('admin');
        $user = $this->userService->find($userId, 1);
        $result = $this->userService->confirmEmail($user);

        return response()->json(['success' => $result]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('edit-user', $user);
        $update_result = $this->userService->update($user, $request->getDto());
        return response()->json(['success' => $update_result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete-user', $user);
        return response()->json(['success' => $this->userService->delete($user)]);
    }


    public function banUser($userId) {
        $user = $this->userService->find($userId, 1);
        $this->authorize('delete-user', $user);
        return response()->json([
            'success' => $this->userService->ban($user),
            'deleted_at' => $user->deleted_at
        ]);
    }

    public function unbanUser($userId) {
        $user = $this->userService->find($userId, 1);
        $this->authorize('delete-user', $user);
        return response()->json([
            'success' => $this->userService->unban($user),
            'deleted_at' => $user->deleted_at
        ]);
    }
}
