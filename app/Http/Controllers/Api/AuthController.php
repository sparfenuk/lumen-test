<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoverPasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Notification\ResetPasswordNotification;
use App\Repository\UserRepository;
use App\Scopes\Email;
use App\Scopes\EmailToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->userRepository->create($data);
            return response()->json(new UserResource($user));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }


    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->userRepository->scope(new Email($email))->first();
        if ($user && password_verify($password, $user->password)) {
            $api_token = $user->createToken('API Token');

            return response()->json([
                'access_token' => $api_token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $api_token->token->expires_at
                )->toDateTimeString()
            ]);

        } else {
            return response()->json([
                'error' => 'Invalid email or password'
            ], 401);
        }
    }

    public function recoverPassword(RecoverPasswordRequest $request)
    {
        $user = $this->userRepository->scope(new Email($request->email))->first();

        if (!$user) {
            return back()->withErrors(['email' => 'The email address was not found']);
        }

        $token = Str::random(60);

        $user->forceFill([
            'password_reset_token' => app('hash')->make($token),
            'password_reset_at' => Carbon::now(),
        ])->save();

        $user->notify(new ResetPasswordNotification($token));

        return response()->json([
            'message' => 'We have e-mailed your password reset link!',
            'success' => true,
        ]);
    }

    public function resetPassword(Request $request, $token, UserRepository $userRepository)
    {
        $user = $userRepository
            ->scope(new EmailToken($token))
            ->first();

        if ($user) {
            $user->password = app('hash')->make($request->password);
            $user->save();
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'invalid data',
            ], 422);
        }
    }

}
