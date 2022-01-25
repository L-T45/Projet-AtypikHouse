<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\FindUserByIdToDelete;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteProperties extends AbstractController {

    // Pour le formulaire de delete properties
    private $idProperties;
    private $PropertiesRepository;

    public function DeleteProperties(Request $request, PropertiesRepository $PropertiesRepository): Response{

        $data = json_decode($request->getContent(), true);
        $idProperties = $data["id"];

        $this->PropertiesRepository = $PropertiesRepository;
        $findPropertiesToDelete = $this->PropertiesRepository->findByIdToDelete($idProperties);
        $findPropertiesToDeleteCheck = $findPropertiesToDelete;

            if($findUserToDeleteCheck =! []){
                $response = new Response('Propriété supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la propriété...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}