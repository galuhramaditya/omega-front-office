<?php

namespace App\Services;

use App\Contracts\RoleRepositoryInterface;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function get(int $level)
    {
        return $this->roleRepository->get($level);
    }

    public function create(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function update(array $data, string $id)
    {
        return $this->roleRepository->update($data, $id);
    }

    public function delete(string $id)
    {
        return $this->roleRepository->delete($id);
    }

    public function findOneBy(array $data)
    {
        return $this->roleRepository->findOneBy($data);
    }

    public function pageSync(array $pages, string $id)
    {
        return $this->roleRepository->pageSync($pages, $id);
    }

    public function pageDetach(string $id)
    {
        return $this->roleRepository->pageDetach($id);
    }
}