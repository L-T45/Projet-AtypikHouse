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

use ReCaptcha\ReCaptcha; 

class SendEmail extends AbstractController {

    // Pour le formulaire de contact
    private $forname;
    private $lastname;
    private $phone;
    private $email; 
    private $objet;
    private $message;
    private $token;
    private $client;

    public function sendEmailFormContact(MailerInterface $mailer, Request $request): Response{

        $data = json_decode( $request->getContent(), true );

        // Données du formulaire de contact
        // On vérifie si les champs sont vides
        if(!empty($data["forname"]) & !empty($data["lastname"]) & !empty($data["email"]) & !empty($data["message"])){
            // On vérifie que les champs réspectent les asserts !
            if(strlen($data["forname"])<60 & strlen($data["forname"])>2 & strlen($data["lastname"])<60 & strlen($data["lastname"])>2 & 
            strlen($data["email"])<80 & strlen($data["email"])>6 & strlen($data["message"])<800 & strlen($data["message"])>6 &
            strlen($data["phone"])<15 & strlen($data["objet"])<60){

                $forname = htmlentities($data["forname"]);   
                $lastname = htmlentities($data["lastname"]);
                $phone = htmlentities($data["phone"]); 
                $email = htmlentities($data["email"]);
                $objet = htmlentities($data["objet"]);   
                $message = htmlentities($data["message"]); 
                $token = $data['token'];
                
                // recaptcha
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LdVoQwdAAAAAOJbRrSpEmpgF08KWwfa_i72cpgF&response=$token";
                $result_json = file_get_contents($url);
                $resulting = json_decode($result_json, true);
                    
                if($resulting["success"] = true ) {
                    $email = (new Email())
                    ->from('atypikhouse.communication@gmail.com')
                    ->to('atypikhouse.communication@gmail.com')
                    ->subject($objet)
                    ->text($forname.' '.$lastname."\n"."\n".'Message: '.$message."\n"."\n".'Contact: '.$email.' '.$phone);

                $mailer->send($email);  
                return new JsonResponse( [ 'status' => '200', 'title' => 'Email envoyé'  ], JsonResponse::HTTP_CREATED ); 

                }else{
                    return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => "Erreur d'envoi" ], JsonResponse::HTTP_CREATED ); 
                }

            }else{
                return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => 'les informations renseignées sont trop long ou trop court' ], JsonResponse::HTTP_CREATED ); 
            }
        }else{
            return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => 'Certaines informations ne sont pas renseignées' ], JsonResponse::HTTP_CREATED ); 
        }    
        
    }

}