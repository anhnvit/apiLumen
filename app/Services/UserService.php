<?php

namespace App\Services;

use App\Repositories\User\UserInterface;

class UserService
{
    private $userRepository;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createAccount($input){
        return $this->userRepository->create($input);
    }

    public function updatePassword($msisdn, $password){
        return $this->userRepository->updateOneBy('msisdn', $msisdn, ['password'=> $password]);
    }

    public function getUserById($id) {
        return $this->userRepository->findOneById($id);
    }
    public function getListUser(){
        return $this->userRepository->getAll();
    }
}