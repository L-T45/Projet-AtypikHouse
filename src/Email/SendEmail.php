<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Doctrine\Common\Collections\ArrayCollection;

class SendEmail extends AbstractController {

    // Pour le formulaire
    public $forname;
    public $forname1;
    public $lastname;
    public $phone;
    public $email;
    public $objet;
    public $message;

    public function sendEmailFormContact(MailerInterface $mailer/*, string $forname*/): Response{

        // Données du formulaire   
        $forname = $_POST["forname"];
        $forname = serialize($forname); 

        $lastname = $_POST["lastname"];
        $lastname = serialize($lastname);

        $phone = $_POST["phone"];
        $phone = serialize($phone);

        $email = $_POST["email"];
        $email = serialize($email);

        $objet = $_POST["objet"];
        $objet = serialize($objet);

        $message = $_POST["message"]; 
        $message = serialize($message);

        $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to('atypikhouse.communication@gmail.com')
            ->subject($objet)
            ->text($forname.' '.$lastname."\n"."\n".'Message: '.$message."\n"."\n".'Contact: '.$phone.' '.$email);

		// Ajouter le RedirectResponse pour rediriger à une page sinon message d'erreur !
		return $mailer->send($email)?: new RedirectResponse('/api');

    }
    /*
    // Validation Location bien 
    public function sendEmailValidationLocation(MailerInterface $mailer): Response{

        $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to('atypikhouse.communication@gmail.com')
            ->subject($objet)
            ->text($forname+' '+$lastname+' '+$message+' Contact :'+$phone+' '+$email);


		// Ajouter le RedirectResponse pour rediriger à une page sinon message d'erreur !
		return $mailer->send($email)?: new RedirectResponse('/api');

    }

    // Refus Location Bien 
    public function sendEmailRefusLocation(MailerInterface $mailer): Response{

        $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to('atypikhouse.communication@gmail.com')
            ->subject($objet)
            ->text($forname+' '+$lastname+' '+$message+' Contact :'+$phone+' '+$email);

		// Ajouter le RedirectResponse pour rediriger à une page sinon message d'erreur !
		return $mailer->send($email)?: new RedirectResponse('/api');

    }*/
}