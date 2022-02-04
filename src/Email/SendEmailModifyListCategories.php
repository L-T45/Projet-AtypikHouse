<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;    
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PropertiesRepository;

class SendEmailModifyListCategories extends AbstractController {

    private $email; 

    public function __construct(PropertiesRepository $PropertiesRepository)
    {
        $this->PropertiesRepository = $PropertiesRepository;
    }

    public function UpdateCategorie(MailerInterface $mailer, Request $request){
        $id = $_POST['id'];
        // Récupéré tous les OWNER  
        $findOwners = $this->PropertiesRepository->FindByPropertiesUpdate($id);
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $this->sendEmailChangeCategorieList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function PostNewCategories(MailerInterface $mailer, Request $request){
        // Récupéré tous les OWNER 
        $findOwners = $this->PropertiesRepository->FindByPropertiesPost();
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $this->sendEmailChangeCategorieList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function DeleteCategories(MailerInterface $mailer, Request $request){
        // Récupéré tous les OWNER 
        $findOwners = $this->PropertiesRepository->FindByPropertiesDelete();
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $this->sendEmailChangeCategorieList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function sendEmailChangeCategorieList(MailerInterface $mailer, Request $request, $nbLines, $findOwners): Response{
        //dd($nbLines, $findOwners);
        for($i = 0; $i < $nbLines; $i++){
            $ownersEmail = $findOwners[$i]['email'];
            $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to($ownersEmail) 
            ->subject("Ça bouge du côté de la liste des Catégories !")
            ->text("Bonjour à vous propriétaire de bien !"."\n"."\n"."Nous vous informons que la liste des Catégories de bien à été mis à jour."."\n"."\n"."Venez vite découvrir notre nouvelle liste!");

            $mailer->send($email);  
        }
        return new JsonResponse( [ 'status' => '200', 'title' => 'Notifications envoyées'  ], JsonResponse::HTTP_CREATED );    
    }

}