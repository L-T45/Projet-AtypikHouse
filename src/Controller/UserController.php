<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController
{


    public function blockUser(Request $request, EntityManagerInterface $manager)
    {
        $user = $request->attributes->get('data');
        $user->setIsBlocked(true);
        $manager->persist($user);
        $manager->flush();

        if (!($user instanceof User)) {
            throw new \RuntimeException('User attendue');
        }

        return new JsonResponse(["status" => 200, "message" => "Salut !!"]);
    }
    public function deBlockUser(Request $request, EntityManagerInterface $manager)
    {
        $user = $request->attributes->get('data');
        $user->setIsBlocked(false);
        $manager->persist($user);
        $manager->flush();

        if (!($user instanceof User)) {
            throw new \RuntimeException('User attendue');
        }
        return new JsonResponse(["status" => 200, "message" => "Salut !!"]);
    }
}
