<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\PropertiesGallery;
use App\Repository\PropertiesGalleryRepository;
use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Mailer\MailerInterface; 
use App\Email\SendEmailModifyProperties;

class DeletePropertiesGallery extends AbstractController {

    // Pour le formulaire de delete PropertiesGallery
    private $idPropertiesGallery;
    private $AttributeRepository;

    public function DeletePropertiesGallery(Request $request, PropertiesRepository $PropertiesRepository, PropertiesGalleryRepository $PropertiesGalleryRepository, SendEmailModifyProperties $SendEmail, MailerInterface $mailer): Response{

        $data = $request->query->get('id');
        $idPropertiesGallery = $data;

        $this->PropertiesGalleryRepository = $PropertiesGalleryRepository;
        $findIdProperties = $this->PropertiesGalleryRepository->findByProperties($idPropertiesGallery);
        $findCheckProperties = $findIdProperties;

        if($findCheckProperties =! []){
            $this->PropertiesRepository = $PropertiesRepository;
            $findOwnerProperties = $this->PropertiesRepository->findByIdUser($findIdProperties);
            $findCheckOwnerProperties = $findOwnerProperties;

            if($findCheckOwnerProperties =! []){
                $this->PropertiesGalleryRepository = $PropertiesGalleryRepository;
                $findPropertiesGalleryToDelete = $this->PropertiesGalleryRepository->findByIdToDelete($idPropertiesGallery);

                if($findPropertiesGalleryToDelete =! []){
                    $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
                    $response = new Response('Photo(s) supprimée(s)',Response::HTTP_OK,['content-type' => 'application/json']);
                }
                else{  
                    $response = new Response("Une erreur est survenu lors de la suppression de la/les photo(s)...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
                }
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la propriété...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        }
        else{  
            $response = new Response("Une erreur est survenu lors de la suppression de la propriété...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
        }
        return $response;
    }
}