<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Repository\CommentsRepository;


class LastNewComments
{

    private $commentsRepository;

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function __invoke()
    {
        return $this->commentsRepository->findLatest();
    }

}
