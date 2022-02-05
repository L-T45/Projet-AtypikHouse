<?php

namespace App\Controller;

use App\Entity\Conversations;
use App\Repository\MessagesRepository;



class FindConversationsByid
{

    private $messagesRepository;


    public function __construct(MessagesRepository $messagesRepository)
    {
        $this->messagesRepository = $messagesRepository;
    }

    public function __invoke(int $id)
    {
        return $this->messagesRepository->findConversationsByid($id);
    }
}
