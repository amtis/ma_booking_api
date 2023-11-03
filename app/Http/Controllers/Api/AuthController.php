<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEditUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponses;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct(public UserServiceInterface $userService){}

    /**
     * Register a new user
     *
     * @param AddEditUserRequest $request
     * @return JsonResponse
     */
    public function register(AddEditUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request);
        if (is_null($user)) {
            return $this->serverErrorMessage(['message' => 'User registration error.']);
        }

        return $this->sendAccessToken($this->userService->createAccessToken($user));
    }

    /**
     * Login user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->unauthenticatedErrorMessage(['message' => 'Invalid login details']);
        }

        return $this->sendAccessToken(
            $this->userService->createAccessToken(null, $request->input('email'))
        );
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->generalOkMessage('Logged out!');
    }

    /**
     * Show logged user
     *
     * @param Request $request
     * @return User|mixed
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
