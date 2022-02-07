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

class SendEmailRegister extends AbstractController {

    private $email; 

    public function sendEmailRegister(MailerInterface $mailer, Request $request): Response{
        $ownersEmail = $_POST['email'];
        $email = (new Email())
        ->from('atypikhouse.communication@gmail.com')
        ->to($ownersEmail) 
        ->subject("Votre compte a bien été créé")
        ->text("Bonjour à vous nouvel utilisateur !"."\n"."\n"."Nous vous informons que votre compte à bien été créé.");

        $mailer->send($email);  
        return new Response("Nouveau équipement posté et notifications envoyées aux propriétaires!",Response::HTTP_OK,['content-type' => 'application/json']);
    }

}