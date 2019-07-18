<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;
use App\Libraries\Response;
use App\Libraries\Token;
use App\Services\CompanyService;

class AuthToken
{
    private $userService;
    private $companyService;

    public function __construct(UserService $userService, CompanyService $companyService)
    {
        $this->userService      = $userService;
        $this->companyService   = $companyService;
    }

    public function handle($request, Closure $next)
    {
        try {
            $token  = Token::decode($request->token);
            $user   = $this->userService->findOneBy(["id" => $token->id]);

            if ($user) {
                $user->conm = $this->companyService->get()->companyname;

                $request->merge(["token" => $user]);
                return $next($request);
            }

            return Response::error("token is not valid");
        } catch (\Throwable $e) {
            return Response::error("token is required");
        }
    }
}