<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;
    protected $salt;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->salt = env("SALT");
    }

    public function get(int $level)
    {
        return $this->userRepository->get($level);
    }

    public function findOneBy(array $data)
    {
        $this->passingData($data);

        return $this->userRepository->findOneBy($data);
    }

    public function create(array $data)
    {
        $this->passingData($data);

        return $this->userRepository->create($data);
    }

    public function update(array $data, string $id)
    {
        $this->passingData($data);

        return $this->userRepository->update($data, $id);
    }

    public function delete(string $id)
    {
        return $this->userRepository->delete($id);
    }

    private function passingData(array &$data)
    {
        if (array_key_exists('role', $data)) {
            $data['role_id']  = $data['role'];
            unset($data['role']);
        }

        if (array_key_exists('password', $data)) {
            $data['password']   = sha1($this->salt . $data['password']);
        }
    }
}