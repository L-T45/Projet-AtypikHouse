<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteCategories extends AbstractController {

    // Pour le formulaire de delete Categories
    private $idCategories;
    private $CategoriesRepository;

    public function DeleteCategories(Request $request, CategoriesRepository $CategoriesRepository): Response{

        $data = $request->query->get('id');
        $idCategories = $data;
 
        $this->CategoriesRepository = $CategoriesRepository;
        $findCategoriesToDelete = $this->CategoriesRepository->findByIdToDelete($idCategories);

            if($findCategoriesToDelete =! []){
                $response = new Response('Catégorie supprimée',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la catégorie...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}