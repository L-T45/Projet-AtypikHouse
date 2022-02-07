<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface; 
use App\Email\SendEmailModifyListEquipements;


class EquipementController
{



    public function updateEquipement(Request $request, EntityManagerInterface $manager, SendEmailModifyListEquipements $SendEmail, MailerInterface $mailer)
    {

        $equipement = $request->attributes->get('data');
        $post = json_decode($request->getContent());
        $idEquipement = $equipement->getId();

        $equipement->setTitle($post->title);
        $manager->persist($equipement);
        $manager->flush();

        $SendEmail->UpdateEquipements($mailer, $request, $idEquipement);
        return new Response("Equipement modifié avec succès !!", Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}
