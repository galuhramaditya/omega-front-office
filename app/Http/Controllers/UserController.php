<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Libraries\Token;
use App\Libraries\Response;
use App\Libraries\Validation;

class UserController extends Controller
{
    protected $userService;
    protected $validation;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->validation = new Validation([
            "login" => [
                "username" => "required",
                "password" => "required",
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validate = $this->validation->validate($request);
        if ($validate->fails()) {
            return $validate->errors("input is not complete");
        }

        $user = $this->userService->findOneBy($request->all());

        if ($user) {
            $token = Token::encode($user);
            return Response::success("login succesfully", ["token" => $token]);
        } else {
            return Response::error('user does not exist');
        }
    }

    public function current(Request $request)
    {
        $current = $this->userService->findOneBy($request->except("token"));
        return Response::success("succesfully get current user data", $current);
    }

    // public function data()
    // {
    //     return $this->userService->get();
    // }

    // public function register(Request $request)
    // {
    //     $this->validate($request, [
    //         'username'      => 'required|unique:users',
    //         'password'      => 'required',
    //         'password_confirmation' => 'required|same:password',
    //         'permission'    => 'required|in:admin,user'
    //     ]);
    //     $user = $this->userService->create($request->all());

    //     if ($user) {
    //         return $this->sendSuccessResponse($user, 'User has been created successfully');
    //     }

    //     return $this->sendErrorResponse("error");
    // }

    // public function update(Request $request)
    // {
    //     $this->validate($request, [
    //         'id'        => 'required',
    //         'username'  => 'required|unique:users,username,' . $request->id,
    //         'permission' => 'required'
    //     ]);

    //     $data   = $request->all();
    //     $self   = $this->userService->findOneBy(["id" => $request->id])->api_token == $request->api_token;
    //     $data['api_token'] = null;

    //     if ($self) {
    //         unset($data['permission']);
    //     }

    //     $user = $this->userService->update($data, $request->id);

    //     if ($user) {
    //         return $this->sendSuccessResponse(["self" => $self], 'User has been updated successfully');
    //     }

    //     return $this->sendErrorResponse("error");
    // }

    // public function changePassword(Request $request)
    // {
    //     $this->validate($request, [
    //         'new_password'    => 'required',
    //         'new_password_confirmation'    => 'required|same:new_password',
    //     ]);

    //     $user = $this->userService->findOneBy(["id" => $request->id, "password" => $request->old_password]);
    //     if ($user == null) {
    //         return $this->sendErrorResponse("something error", ["old_password" => "old password is wrong"]);
    //     }

    //     $self               = $user->api_token == $request->api_token;
    //     $data               = $request->all();
    //     $data["password"]   = $data["new_password"];
    //     unset($data['new_password'], $data['new_password_confirmation'], $data['old_password']);
    //     $data['api_token']  = null;

    //     $user = $this->userService->update($data, $request->id);

    //     if ($user) {
    //         return $this->sendSuccessResponse(['self' => $self], 'User has been updated successfully');
    //     }

    //     return $this->sendErrorResponse("error");
    // }

    // public function delete(Request $request)
    // {
    //     $this->validate($request, [
    //         'id'  => 'required',
    //     ]);
    //     $user = $this->userService->delete($request->id);

    //     if ($user) {
    //         return $this->sendSuccessResponse($user, 'User has been deleted successfully');
    //     }

    //     return $this->sendErrorResponse("error");
    // }

    // public function logout(Request $request)
    // {
    //     if ($request->has('api_token')) {

    //         $user = $this->userService->findOneBy(['api_token' => $request->api_token]);

    //         if ($user) {
    //             $update = $this->userService->update(['api_token' => null], $user->id);

    //             return $this->sendSuccessResponse([], 'User has been updated');
    //         } else {
    //             return $this->sendErrorResponse('User could not be found');
    //         }
    //     } else {
    //         return $this->sendErrorResponse('Api token is required');
    //     }
    // }
}