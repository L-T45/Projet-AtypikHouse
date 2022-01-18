<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Repository\CommentsRepository;


class CommentsById
{

    private $commentsRepository;
    

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
        
    }

    public function __invoke(int $id)
    {
        return $this->commentsRepository->find($id);
    }

}

