<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
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
    public function modifyInformations(Request $request, EntityManagerInterface $manager)
    {
        $user = $request->attributes->get('data');
        $data = json_decode($request->getContent(), true);
        // dd($data["firstname"]);

        if (isset($data["firstname"]) && !empty($data["firstname"])) {
            $user->setFirstname($data["firstname"]);
        }
        if (isset($data["lastname"]) && !empty($data["lastname"])) {
            $user->setLastname($data["lastname"]);
        }
        if (isset($data["phone"]) && !empty($data["phone"])) {
            $user->setPhone($data["phone"]);
        }
        if (isset($data["birthdate"]) && !empty($data["birthdate"])) {
            $user->setBirthdate(new DateTime($data["birthdate"]));
        }
        if (isset($data["address"]) && !empty($data["address"])) {
            $user->setAddress($data["address"]);
        }
        if (isset($data["city"]) && !empty($data["city"])) {
            $user->setCity($data["city"]);
        }
        if (isset($data["zipCode"]) && !empty($data["zipCode"])) {
            $user->setZipCode($data["zipCode"]);
        }
        if (isset($data["country"]) && !empty($data["country"])) {
            $user->setCountry($data["country"]);
        }

        //     $user->setUpdatedAt(new DateTime());
        $manager->persist($user);
        $manager->flush();


        if (!($user instanceof User)) {
            throw new \RuntimeException('User attendue');
        }

        return new JsonResponse(["status" => 200, "message" => "Informations personnelles modifiées"]);
    }
}
