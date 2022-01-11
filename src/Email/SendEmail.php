<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;    
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Validator\Constraints as Assert;


class SendEmail extends AbstractController {

    // Pour le formulaire de contact
    public $forname;
    public $lastname;
    public $phone;
    public $email; 
    public $objet;
    public $message;

    public function sendEmailFormContact(MailerInterface $mailer, Request $request): Response{

        $data = json_decode( $request->getContent(), true );

        // Données du formulaire de contact
        // On vérifie si les champs sont vides
        if(!empty($data["forname"]) & !empty($data["lastname"]) & !empty($data["email"]) & !empty($data["message"])){
            // On vérifie que les champs réspectent les asserts !
            if(strlen($data["forname"])<60 & strlen($data["forname"])>2 & strlen($data["lastname"])<60 & strlen($data["lastname"])>2 & 
            strlen($data["email"])<80 & strlen($data["email"])>6 & strlen($data["message"])<800 & strlen($data["message"])>6 &
            strlen($data["phone"])<15 & strlen($data["objet"])<60){

                $forname = $data["forname"];   
                $lastname = $data["lastname"];
                $phone = $data["phone"]; 
                $email = $data["email"];
                $objet = $data["objet"];   
                $message = $data["message"]; 

                $email = (new Email())
                    ->from('atypikhouse.communication@gmail.com')
                    ->to('atypikhouse.communication@gmail.com')
                    ->subject($objet)
                    ->text($forname.' '.$lastname."\n"."\n".'Message: '.$message."\n"."\n".'Contact: '.$email.' '.$phone);

                $mailer->send($email);  
                return new JsonResponse( [ 'status' => '200', 'title' => 'Send'  ], JsonResponse::HTTP_CREATED ); 

            }else{
                return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => 'some informations to short or to long' ], JsonResponse::HTTP_CREATED ); 
            }
        }else{
            return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => 'some informations not specified' ], JsonResponse::HTTP_CREATED ); 
        }    
        
    }

}