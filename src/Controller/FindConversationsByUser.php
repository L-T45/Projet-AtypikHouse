<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConversationsRepository;


class FindConversationsByUser
{

    private $userRepository;


    public function __construct(ConversationsRepository $convRepo)
    {
        $this->convRepo = $convRepo;
    }

    public function __invoke(int $id)
    {
        return $this->convRepo->findConversationsByUser($id);
    }
}
