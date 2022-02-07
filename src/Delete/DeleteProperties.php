<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Properties;
use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Mailer\MailerInterface; 
use App\Email\SendEmailModifyProperties;

class DeleteProperties extends AbstractController {

    // Pour le formulaire de delete properties
    private $idProperties;
    private $PropertiesRepository;

    public function DeleteProperties(Request $request, PropertiesRepository $PropertiesRepository, SendEmailModifyProperties $SendEmail, MailerInterface $mailer): Response{

        $data = $request->query->get('id');
        $idProperties = $data;
 
        $this->PropertiesRepository = $PropertiesRepository;
        $findOwnerProperties = $this->PropertiesRepository->findByIdUser($idProperties);
        $findCheckOwnerProperties = $findOwnerProperties;
        
        $this->PropertiesRepository = $PropertiesRepository;
        $findPropertiesToDelete = $this->PropertiesRepository->findByIdToDelete($idProperties);

        if($findPropertiesToDelete =! []){
            $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
            $response = new Response('Propriété supprimée',Response::HTTP_OK,['content-type' => 'application/json']);
        }
        else{  
            $response = new Response("Une erreur est survenu lors de la suppression de la propriété...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
        }
        return $response;
    }
}
