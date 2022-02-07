<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class EquipementController
{



    public function updateEquipement(Request $request, EntityManagerInterface $manager)
    {


        $equipement = $request->attributes->get('data');
        $post = json_decode($request->getContent());

        $equipement->setTitle($post->title);
        $manager->persist($equipement);
        $manager->flush();
        return new Response("Equipement modifié avec succès !!", Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}
