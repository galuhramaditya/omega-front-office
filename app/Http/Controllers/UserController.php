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
        $this->validation = Validation::rules([
            "login" => [
                "username" => "required",
                "password" => "required",
            ],
            "selfEdit" => [
                'token'        => 'required',
            ],
            "changeSelfPassword" => [
                'new_password'    => 'required',
                'new_password_confirmation'    => 'required|same:new_password',
            ],
            "create" => [
                'username'      => 'required|unique:users',
                'password'      => 'required',
                'password_confirmation' => 'required|same:password',
                'permission'    => 'required|in:admin,user'
            ],
            "edit" => [
                'id'  => 'required',
                'permission' => "required"
            ],
            "delete" => [
                'id'  => 'required'
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validate = $this->validation->validate($request);
        if ($validate->fails()) {
            return $validate->errors();
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
        return Response::success("succesfully get current user data", $request->token);
    }

    public function get()
    {
        $get = $this->userService->get();
        return Response::success("successfully get users data", $get);
    }

    public function selfEdit(Request $request)
    {
        $validate = $this->validation->validate($request, ['username'  => 'required|unique:users,username,' . $request->token->id,]);
        if ($validate->fails()) {
            return $validate->errors();
        }

        $editSelf = $this->userService->update($request->except("token"), $request->token->id);
        if ($editSelf) {
            return Response::success('successfully editing self data', $editSelf);
        }
    }

    public function changeSelfPassword(Request $request)
    {
        $validate = $this->validation->validate($request);
        if ($validate->fails()) {
            return $validate->errors();
        }

        $changeSelfPassword = $this->userService->update(["password" => $request->new_password], $request->token->id);

        if ($changeSelfPassword) {
            return Response::success('successfully changing self password', $changeSelfPassword);
        }
    }

    public function create(Request $request)
    {
        $validate = $this->validation->validate($request);
        if ($validate->fails()) {
            return $validate->errors();
        }

        $create = $this->userService->create($request->all());

        if ($create) {
            return Response::success('successfully creating new user', $create);
        }
    }

    public function edit(Request $request)
    {
        $validate = $this->validation->validate($request);
        if ($validate->fails()) {
            return $validate->errors();
        }

        $edit = $this->userService->update($request->except("token"), $request->id);

        if ($edit) {
            return Response::success('successfully editing user data', $edit);
        }
    }

    public function delete(Request $request)
    {
        $validate = $this->validation->validate($request);
        if ($validate->fails()) {
            return $validate->errors();
        }

        $delete = $this->userService->delete($request->id);

        if ($delete) {
            return Response::success('successfully deleting user', $delete);
        }
    }
}