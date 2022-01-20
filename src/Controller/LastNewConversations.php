<?php

namespace App\Controller;

use App\Entity\Conversations;
use App\Repository\ConversationsRepository;


class LastNewConversations
{

    private $conversationsRepository;

    public function __construct(ConversationsRepository $conversationsRepository)
    {
        $this->conversationsRepository = $conversationsRepository;
    }

    public function __invoke()
    {
        return $this->conversationsRepository->findLatest();
    }

}

