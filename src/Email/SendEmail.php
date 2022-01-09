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
            ->text($forname.' '.$lastname."\n"."\n".'Message: '.$message."\n"."\n".'Contact: '.$phone.' '.$email);

		// Ajouter le RedirectResponse pour rediriger à une page sinon message d'erreur !
	    $mailer->send($email);
        return new JsonResponse( [ 'status' => '200', ], JsonResponse::HTTP_CREATED );
    }

}