<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;
use App\Libraries\Response;

class AuthPassword
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle($request, Closure $next)
    {
        try {
            if (!empty($request->password)) {
                $data = [
                    "id" => $request->token->id,
                    "password" => $request->password,
                ];

                $user = $this->userService->findOneBy($data);

                if ($user) {
                    return $next($request);
                }

                return Response::error("password is wrong", ["password" => "Password is wrong"]);
            }
        } catch (\Throwable $e) { }
        return Response::error("password is required", ["password" => "The password field is required"]);
    }
}