<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Attributes;
use App\Repository\AttributesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Mailer\MailerInterface; 
use App\Email\SendEmailModifyListAttributes;

class DeleteAttribute extends AbstractController {

    // Pour le formulaire de delete Attributes
    private $idAttributes;
    private $AttributeRepository;

    public function DeleteAttribute(Request $request, AttributesRepository $AttributesRepository, SendEmailModifyListAttributes $SendEmail, MailerInterface $mailer): Response{

        $data = $request->query->get('id');
        $idAttributes = $data;
 
        $this->AttributesRepository = $AttributesRepository;
        $findAttributesToDelete = $this->AttributesRepository->findByIdToDelete($idAttributes);

            if($findAttributesToDelete =! []){
                $SendEmail->DeleteAttributes($mailer, $request);
                $response = new Response('Attribut supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de l'attribut...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}