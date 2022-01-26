<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Conversations;
use App\Repository\ConversationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteConversations extends AbstractController {

    // Pour le formulaire de delete Conversations
    private $idConversations;
    private $AttributeRepository;

    public function DeleteConversations(Request $request, ConversationsRepository $ConversationsRepository): Response{

        $data = $request->query->get('id');
        $idConversations = $data;
 
        $this->ConversationsRepository = $ConversationsRepository;
        $findConversationsToDelete = $this->ConversationsRepository->findByIdToDelete($idConversations);

            if($findConversationsToDelete =! []){
                $response = new Response('Conversation supprimée',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la conversation...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}