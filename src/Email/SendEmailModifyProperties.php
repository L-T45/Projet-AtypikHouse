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

class SendEmailModifyProperties extends AbstractController {

    private $email; 

    public function sendEmailModifyProperties(MailerInterface $mailer, Request $request, $findOwnerProperties): Response{
        if($findCheckOwnerProperties =! []){
            
            $ownersEmail = $findOwnerProperties[0]['email'];
            $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to($ownersEmail) 
            ->subject("Modification de l'un de vos biens")
            ->text("Bonjour à vous propriétaire !"."\n"."\n"."Nous vous informons que l'un de vos bien a été modifié ou supprimé.");

            $mailer->send($email);  
            return new Response("Nouveau équipement posté et notifications envoyées aux propriétaires!",Response::HTTP_OK,['content-type' => 'application/json']);
        }
    }
}