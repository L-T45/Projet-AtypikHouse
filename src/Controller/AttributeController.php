<?php

namespace App\Controller;

use App\Entity\Attributes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Email\SendEmailModifyListAttributes;
use Symfony\Component\Mailer\MailerInterface;

class AttributeController
{


    /**
     * @Route("/api/dashboard/admin/attributes/create", methods={"POST"})
     */
    public function createAttribute(Request $request, EntityManagerInterface $manager, SendEmailModifyListAttributes $SendEmail, MailerInterface $mailer)
    {

        $post = json_decode($request->getContent(), true);
        $categoryRef = $manager->getReference("App\Entity\Categories", $post["categories"]);
        $newAtttibute = new Attributes();
        $newAtttibute->setTitle($post["title"]);
        $newAtttibute->setCategories($categoryRef);
        $newAtttibute->setResponseType($post['response_type']);
        $newAtttibute->setRequired($post["required"]);

        $manager->persist($newAtttibute);
        $manager->flush();

        $SendEmail->PostNewAttributes($mailer, $request);

        return new JsonResponse(["status" => 201, "message" => "Attribut créé avec succès !"]);
    }

    public function updateAttribute(Request $request, EntityManagerInterface $manager, SendEmailModifyListAttributes $SendEmail, MailerInterface $mailer)
    {

        $attribute = $request->attributes->get('data');
        $post = json_decode($request->getContent(), true);

        $attribute->setTitle($post["title"]);
        $attribute->setResponseType($post['response_type']);
        $attribute->setRequired($post["required"]);

        $manager->persist($attribute);
        $manager->flush();

        $SendEmail->UpdateAttributes($mailer, $request);

        return new JsonResponse(["status" => 201, "message" => "Attribut modifié avec succès !"]);
    }
}
