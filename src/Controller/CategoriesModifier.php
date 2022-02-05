<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class CategoriesModifier extends AbstractController {

    // private $idCategory;
    // private $CategoriesRepository;
    // private $title;
    // private $slug;

    // public function UpdateCategories(Request $request, CategoriesRepository $CategoriesRepository): Response{

    //     $category = Array();
    //     $category = new Categories();

    //     $data = json_decode($request->getContent(), true);

    //     $title = $data["title"];
    //     $slug = $data["slug"];
    //     $idCategory = $data["id"];

    //     $this->CategoriesRepository = $CategoriesRepository;
    //     $CategoriesTitle = $this->CategoriesRepository->modifier($idCategory, $title, $slug);

    //     return $response = new Response('Catégorie modifié avec succès', Response::HTTP_OK,['content-type' => 'application/json']);

    // }

    public function UpdateCategories(Request $request) {

        $data = $request->getContent();
        $categories = new Categories();

        dd($data['title']);
        
        $categories->setTitle($_POST['title']);

        $categories->setUpdatedAt(new \DateTime());
        return $categories;

    }

}