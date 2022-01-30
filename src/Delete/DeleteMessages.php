<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Messages;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteMessages extends AbstractController {

    // Pour le formulaire de delete Messages
    private $idMessages;
    private $AttributeRepository;

    public function DeleteMessages(Request $request, MessagesRepository $MessagesRepository): Response{

        $data = $request->query->get('id');
        $idMessages = $data;
 
        $this->MessagesRepository = $MessagesRepository;
        $findMessagesToDelete = $this->MessagesRepository->findByIdToDelete($idMessages);

            if($findMessagesToDelete =! []){
                $response = new Response('Message supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression du message...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}