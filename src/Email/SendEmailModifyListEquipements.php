<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;    
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PropertiesRepository;

class SendEmailModifyListEquipements extends AbstractController {

    private $email; 

    public function __construct(PropertiesRepository $PropertiesRepository)
    {
        $this->PropertiesRepository = $PropertiesRepository;
    }

    public function UpdateEquipements(MailerInterface $mailer, Request $request){
        $id = $_POST['id'];
        // Récupéré tous les OWNER  
        $findOwners = $this->PropertiesRepository->FindByPropertiesUpdateEquipements($id);
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $this->sendEmailChangeEquipementsList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function PostNewEquipements(MailerInterface $mailer, Request $request){
        // Récupéré tous les OWNER 
        $findOwners = $this->PropertiesRepository->FindByPropertiesPost();
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $this->sendEmailChangeEquipementsList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function DeleteEquipements(MailerInterface $mailer, Request $request){
        // Récupéré tous les OWNER 
        $findOwners = $this->PropertiesRepository->FindByPropertiesDeleteEquipements();
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $this->sendEmailChangeEquipementsList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function sendEmailChangeEquipementsList(MailerInterface $mailer, Request $request, $nbLines, $findOwners): Response{
        //dd($nbLines, $findOwners);
        for($i = 0; $i < $nbLines; $i++){
            $ownersEmail = $findOwners[$i]['email'];
            $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to($ownersEmail) 
            ->subject("Ça bouge du côté de la liste des Equipements !")
            ->text("Bonjour à vous propriétaire de bien !"."\n"."\n"."Nous vous informons que la liste des Equipements de bien à été mis à jour."."\n"."\n"."Venez vite découvrir notre nouvelle liste!");

            $mailer->send($email);  
        }
        return new JsonResponse( [ 'status' => '200', 'title' => 'Notifications envoyées'  ], JsonResponse::HTTP_CREATED );    
    }

}