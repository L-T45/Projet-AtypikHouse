<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\FindUserByIdToDelete;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteUser extends AbstractController {

    // Pour le formulaire de delete account
    private $idUser;
    private $UserRepository;

    public function DeleteAccount(Request $request, UserRepository $UserRepository): Response{

        $data = json_decode($request->getContent(), true);
        $idUser = $data["id"];

        $this->UserRepository = $UserRepository;
        $findUserToDelete = $this->UserRepository->findByIdToDelete($idUser);
        $findUserToDeleteCheck = $findUserToDelete;

            if($findUserToDeleteCheck =! []){
                $response = new Response('Compte supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression du compte...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}