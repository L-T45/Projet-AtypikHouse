<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Equipements;
use App\Repository\EquipementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteEquipements extends AbstractController {

    // Pour le formulaire de delete Equipements
    private $idEquipements;
    private $AttributeRepository;

    public function DeleteEquipements(Request $request, EquipementsRepository $EquipementsRepository): Response{

        $data = $request->query->get('id');
        $idEquipements = $data;
 
        $this->EquipementsRepository = $EquipementsRepository;
        $findEquipementsToDelete = $this->EquipementsRepository->findByIdToDelete($idEquipements);

            if($findEquipementsToDelete =! []){
                $response = new Response('Equipement supprimée',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de l'équipement'...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}