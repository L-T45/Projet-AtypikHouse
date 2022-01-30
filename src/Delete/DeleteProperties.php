<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Properties;
use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteProperties extends AbstractController {

    // Pour le formulaire de delete properties
    private $idProperties;
    private $PropertiesRepository;

    public function DeleteProperties(Request $request, PropertiesRepository $PropertiesRepository): Response{

        $data = $request->query->get('id');
        $idProperties = $data;
 
        $this->PropertiesRepository = $PropertiesRepository;
        $findPropertiesToDelete = $this->PropertiesRepository->findByIdToDelete($idProperties);

            if($findPropertiesToDelete =! []){
                $response = new Response('Propriété supprimée',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la propriété...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}