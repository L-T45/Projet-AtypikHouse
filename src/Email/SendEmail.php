<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SendEmail extends AbstractController {

    public function sendEmail(MailerInterface $mailer): Response{
        $email = (new Email())
            ->from('atypikhouse.communication@gmail.com')
            ->to('atypikhouse.communication@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');
            //->->html('<p>See Twig integration for better HTML integration!</p>');

		// Ajouter le RedirectResponse pour rediriger à une page sinon message d'erreur !
		return $mailer->send($email)?: new RedirectResponse('/api');

    }
}