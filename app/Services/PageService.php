<?php

namespace App\Services;

use App\Contracts\PageRepositoryInterface;

class PageService
{
    protected $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function get()
    {
        return $this->pageRepository->get();
    }

    public function create(array $data)
    {
        return $this->pageRepository->create($data);
    }

    public function update(array $data, string $id)
    {
        return $this->pageRepository->update($data, $id);
    }

    public function delete(string $id)
    {
        return $this->pageRepository->delete($id);
    }
}