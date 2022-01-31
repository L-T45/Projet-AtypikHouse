<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteComments extends AbstractController {

    // Pour le formulaire de delete Comments
    private $idComments;
    private $CommentsRepository;

    public function DeleteComments(Request $request, CommentsRepository $CommentsRepository): Response{

        $data = $request->query->get('id');
        $idComments = $data;
 
        $this->CommentsRepository = $CommentsRepository;
        $findCommentsToDelete = $this->CommentsRepository->findByIdToDelete($idComments);

            if($findCommentsToDelete =! []){
                $response = new Response('Commentaire supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression du commentaire...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}