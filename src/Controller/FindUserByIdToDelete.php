<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

class FindUserByIdToDelete
{
    
    private $userRepository;
    

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        
    }


    public function __invoke(int $id)
    {
        return $this->userRepository->findByIdToDelete($id);
    }
}