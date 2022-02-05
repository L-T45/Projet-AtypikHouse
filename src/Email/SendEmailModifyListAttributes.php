<?php

namespace App\Email;

use App\Entity\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;    
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PropertiesRepository;
use App\Repository\AttributesRepository;
use Doctrine\ORM\EntityManagerInterface;

class SendEmailModifyListAttributes extends AbstractController {

    private $email; 
    private $postNewEquipement;
    private $title;

    public function __construct(PropertiesRepository $PropertiesRepository, AttributesRepository $AttributesRepository)
    {
        $this->PropertiesRepository = $PropertiesRepository;
        $this->AttributesRepository = $AttributesRepository;
        
    }

    public function UpdateAttributes(MailerInterface $mailer, Request $request){
        $id = $_POST['id'];
        // Récupéré tous les OWNER  
        $findOwners = $this->PropertiesRepository->FindByPropertiesUpdateAttributes($id);
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck != []) {
            $this->sendEmailChangeAttributesList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function PostNewAttributes(MailerInterface $mailer, Request $request, EntityManagerInterface $manager): Response{
        // Récupéré tous les OWNER 
        $findOwners = $this->PropertiesRepository->FindByPropertiesPost();
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck = true) {
            $data = json_decode($request->getContent(), true);
            $title = $data['title'];
            $findAttributes = $this->AttributesRepository->findByAttributes($title);
            $findAttributesCheck = $findAttributes;

            // On check d'abord si un équipement avec le même titre n'est pas déjà créé avant de créer ce nouvel équipement et en avertir les OWNERS!
            if($findAttributesCheck === []) {
                $postNewEquipement = new Attributes();
                $postNewEquipement->setTitle($title);
                $manager->persist($postNewEquipement);
                $manager->flush();
                
                $this->sendEmailChangeAttributesList($mailer, $request, $nbLines, $findOwners);
                return new Response("Nouveau attribut posté et notifications envoyées aux propriétaires!",Response::HTTP_OK,['content-type' => 'application/json']);    
            }
            else{
                return new Response("Impossible de créer votre nouvel attribut car un attribut du même titre existe déjà!",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);
            }
        }
    }

    public function DeleteAttributes(MailerInterface $mailer, Request $request){
        // Récupéré tous les OWNER 
        $findOwners = $this->PropertiesRepository->FindByPropertiesDeleteAttributes();
        $findOwnersCheck = $findOwners;   
        $nbLines = count($findOwners);

        // Envoi de mail aux propriétaires !            
        if($findOwnersCheck != []) {
            $this->sendEmailChangeAttributesList($mailer, $request, $nbLines, $findOwners);
        }
    }

    public function sendEmailChangeAttributesList(MailerInterface $mailer, Request $request, $nbLines, $findOwners): Response{
        for($i = 0; $i < $nbLines; $i++){
            $ownersEmail = $findOwners[$i]['email'];
            $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to($ownersEmail) 
            ->subject("Ça bouge du côté de la liste des Attributes !")
            ->text("Bonjour à vous propriétaire de bien !"."\n"."\n"."Nous vous informons que la liste des attributes de bien à été mis à jour."."\n"."\n"."Venez vite découvrir notre nouvelle liste!");

            $mailer->send($email);  
        }
        return new Response("Nouveau équipement posté et notifications envoyées aux propriétaires!",Response::HTTP_OK,['content-type' => 'application/json']);
    }

}