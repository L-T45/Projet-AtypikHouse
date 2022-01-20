<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;


class FindConversationsidByUser
{

    private $userRepository;
    

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        
    }

    public function __invoke(int $id)
    {
        return $this->userRepository->findConversationsidByUser($id);
    }

}
