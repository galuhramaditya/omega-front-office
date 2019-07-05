<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use App\Services\RoleService;
use App\Libraries\Validation;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $roleService;
    private $validation;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->validation = Validation::rulesOfFunction([
            "create" => [
                "name" => "required|unique:roles",
                "level" => "required|numeric"
            ]
        ]);
    }

    public function get(Request $request)
    {
        $get = $this->roleService->get($request->token->role->level);
        return Response::success("successfully get role datas", $get);
    }

    public function create(Request $request)
    {
        $this->validation->validate($request);

        $create = $this->roleService->create($request->except(["token", "pages"]));
        $id = $this->roleService->findOneBy($request->except(["token", "pages"]))->id;

        if ($request->pages) {
            $this->roleService->pageSync($request->pages, $id);
        }

        return Response::success("successfully creating new role", $create);
    }

    public function edit(Request $request)
    {
        Validation::rules([
            "name" => "required|unique:roles,name,$request->id",
            "level" => "required|numeric",
        ])->validate($request);

        $update = $this->roleService->update($request->except("token"), $request->id);

        if ($request->pages) {
            $this->roleService->pageSync($request->pages, $request->id);
        } else {
            $this->roleService->pageDetach($request->id);
        }

        return Response::success("successfully editing role", $update);
    }

    public function delete(Request $request)
    {
        $delete = $this->roleService->delete($request->id);
        return Response::success("successfully deleting role", $delete);
    }
}