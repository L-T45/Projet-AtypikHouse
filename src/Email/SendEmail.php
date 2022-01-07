<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Doctrine\Common\Collections\ArrayCollection;

class SendEmail extends AbstractController {

    // Pour le formulaire de contact
    public $forname;
    public $lastname;
    public $phone;
    public $email;
    public $objet;
    public $message;

    // pour ne concerver que ce que l'on souhaite après avoir serialize une variable de type array 
    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);   
    }

    public function sendEmailFormContact(MailerInterface $mailer): Response{

        // Données du formulaire de contact
        $forname = $_POST["forname"];   
        $forname = serialize($forname); 
        $forname = $this->cutChaine($forname, ':"', '";'); 

        $lastname = $_POST["lastname"];
        $lastname = serialize($lastname);
        $lastname = $this->cutChaine($lastname, ':"', '";'); 

        $phone = $_POST["phone"];
        $phone = serialize($phone);
        $phone = $this->cutChaine($phone, ':"', '";'); 

        $email = $_POST["email"];
        $email = serialize($email);
        $email = $this->cutChaine($email, ':"', '";'); 

        $objet = $_POST["objet"];
        $objet = serialize($objet);
        $objet = $this->cutChaine($objet, ':"', '";'); 

        $message = $_POST["message"]; 
        $message = serialize($message);
        $message = $this->cutChaine($message, ':"', '";'); 

        $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to('atypikhouse.communication@gmail.com')
            ->subject($objet)
            ->text($forname.' '.$lastname."\n"."\n".'Message: '.$message."\n"."\n".'Contact: '.$phone.' '.$email);

		// Ajouter le RedirectResponse pour rediriger à une page sinon message d'erreur !
		return $mailer->send($email)?: new RedirectResponse('/api'); 

    }

}