<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class CategoriesModifier extends AbstractController {

    // Pour le formulaire de delete properties

    private $idUser;
    private $CategoriesRepository;
    private $title;

    public function UpdateCategories(Request $request, UserRepository $UserRepository, UserPasswordEncoderInterface $encoder): Response{

        $category = Array();
        $category = new Category();
        $category = $this->getCategory();

        $data = json_decode($request->getContent(), true);

        $title = $data["title"];
        $idUser = $data["id"];

        $this->categoryRepository = $categoryRepository;
        $categoryTitle = $this->categoryRepository->modifier($idUser, $title);

    }

}