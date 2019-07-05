<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use App\Services\PageService;
use App\Libraries\Validation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private $pageService;
    private $validation;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->validation = Validation::rulesOfFunction([
            "create" => [
                "name" => "required",
                "url" => "required"
            ],
            "edit" => [
                "name" => "required",
                "url" => "required"
            ],
        ]);
    }

    public function get()
    {
        $get = $this->pageService->get();
        return Response::success("successfully get page datas", $get);
    }

    public function create(Request $request)
    {
        $this->validation->validate($request);

        $create = $this->pageService->create($request->except("token"));
        return Response::success("successfully creating new page", $create);
    }

    public function edit(Request $request)
    {
        $this->validation->validate($request);

        $update = $this->pageService->update($request->except("token"), $request->id);
        return Response::success("successfully editing page", $update);
    }

    public function delete(Request $request)
    {
        $delete = $this->pageService->delete($request->id);
        return Response::success("successfully deleting page", $delete);
    }
}