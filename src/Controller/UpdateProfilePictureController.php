<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



class UpdateProfilePictureController

{

     public function __invoke(EntityManagerInterface $manager,Request $request):Response
     {

        $user = $request->attributes->get('data');
        if(!($user instanceof user)) {
            throw new \RuntimeException('User attendu');
        }   
        
        $user->setFile($request->files->get('file'));
        $user->setUpdatedAt(new \DateTime());
        $manager->persist($user);
        $manager->flush();

        return new JsonResponse(['status' => '200', 'title' => 'Votre photo de profil a été modifiée avec succès'], JsonResponse::HTTP_CREATED);
        
     }

}