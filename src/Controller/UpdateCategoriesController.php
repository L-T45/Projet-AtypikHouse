<?php

namespace App\Controller;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UpdateCategoriesController

{

    public function __invoke(Request $request, EntityManagerInterface $manager)
    {

        $categories = $request->attributes->get('data');
        if (!($categories instanceof Categories)) {
            throw new \RuntimeException('Catégorie attendue');
        }

        if (isset($_POST['title'])) {
            $categories->setTitle($_POST['title']);
        }

        if (isset($_POST['description'])) {
            $categories->setDescription($_POST['description']);
        }


        $categories->setFile($request->files->get('file'));
        $categories->setUpdatedAt(new \DateTime());

        $manager->persist($categories);
        $manager->flush();


        return new JsonResponse(['status' => '200', 'title' => 'La catégorie a bien été modifiée !'], JsonResponse::HTTP_CREATED);
    }
}
