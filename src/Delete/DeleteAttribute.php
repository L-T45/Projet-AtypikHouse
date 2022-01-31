<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Attributes;
use App\Repository\AttributesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteAttribute extends AbstractController {

    // Pour le formulaire de delete Attributes
    private $idAttributes;
    private $AttributeRepository;

    public function DeleteAttribute(Request $request, AttributesRepository $AttributesRepository): Response{

        $data = $request->query->get('id');
        $idAttributes = $data;
 
        $this->AttributesRepository = $AttributesRepository;
        $findAttributesToDelete = $this->AttributesRepository->findByIdToDelete($idAttributes);

            if($findAttributesToDelete =! []){
                $response = new Response('Attribut supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de l'attribut...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}