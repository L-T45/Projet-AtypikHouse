<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\PropertiesGallery;
use App\Repository\PropertiesGalleryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeletePropertiesGallery extends AbstractController {

    // Pour le formulaire de delete PropertiesGallery
    private $idPropertiesGallery;
    private $AttributeRepository;

    public function DeletePropertiesGallery(Request $request, PropertiesGalleryRepository $PropertiesGalleryRepository): Response{

        $data = $request->query->get('id');
        $idPropertiesGallery = $data;
 
        $this->PropertiesGalleryRepository = $PropertiesGalleryRepository;
        $findPropertiesGalleryToDelete = $this->PropertiesGalleryRepository->findByIdToDelete($idPropertiesGallery);

            if($findPropertiesGalleryToDelete =! []){
                $response = new Response('Photo(s) supprimée(s)',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la/les photo(s)...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}