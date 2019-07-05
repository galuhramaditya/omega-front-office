<?php

namespace App\Repositories;

use App\Contracts\PageRepositoryInterface;
use App\Models\Page;

class PageRepository implements PageRepositoryInterface
{
    public function get()
    {
        return Page::all();
    }

    public function create(array $data)
    {
        return Page::create($data);
    }

    public function update(array $data, string $id)
    {
        return Page::find($id)->update($data);
    }

    public function delete(string $id)
    {
        return Page::find($id)->delete();
    }
}