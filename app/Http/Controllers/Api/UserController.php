<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEditUserRequest;
use App\Services\User\UserServiceInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiResponses;

    public function __construct(public UserServiceInterface $userService){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->userService->listUsers();
    }

    /**
     * /**
     * Store a newly created resource in storage.
     *
     * @param AddEditUserRequest $request
     * @return JsonResponse
     */
    public function store(AddEditUserRequest $request): JsonResponse
    {
        if (!is_null($this->userService->createUser($request))) {
            return $this->generalOkMessage('The user was successfully created.');
        }
        return $this->serverErrorMessage(['message' => 'User registration error.']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function show(int $userId)
    {
        return $this->userService->showUser($userId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddEditUserRequest $request
     * @return JsonResponse
     */
    public function update(AddEditUserRequest $request): JsonResponse
    {
        if ($this->userService->updateUser($request) === true) {
            return $this->generalOkMessage('The user was successfully updated.');
        }
        return $this->serverErrorMessage(['message' => 'User registration error.']);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param AddEditUserRequest $request
     * @return JsonResponse
     */
    public function destroy(AddEditUserRequest $request): JsonResponse
    {
        if ($this->userService->deleteUser($request)) {
            return $this->generalOkMessage('The user was successfully deleted.');
        }
        return $this->serverErrorMessage(['message' => 'User registration error.']);
    }
}
