<?php

namespace App\Controller;

use App\Entity\Conversations;
use App\Repository\ConversationsRepository;


class FindConversationsByid
{

    private $conversationsRepository;
    

    public function __construct(ConversationsRepository $conversationsRepository)
    {
        $this->conversationsRepository = $conversationsRepository;
        
    }

    public function __invoke(int $id)
    {
        return $this->conversationsRepository->findConversationsByid($id);
    }

}

