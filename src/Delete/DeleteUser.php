<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteUser extends AbstractController {

    // Pour le formulaire de delete account
    private $idUser;
    private $userRepository;

    public function DeleteAccount(Request $request, UserRepository $userRepository): Response{

        $data = $request->query->get('id');
        $idUser = $data;
 
        $this->userRepository = $userRepository;
        $findUserToDelete = $this->userRepository->findByIdToDelete($idUser);

            if($findUserToDelete =! []){
                $response = new Response('Compte supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression du compte...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}