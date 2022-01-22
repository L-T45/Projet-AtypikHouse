<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;


class ResetPassword
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        return $this->userRepository->resetPassword();
    }

}

