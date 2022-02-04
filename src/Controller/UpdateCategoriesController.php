<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateCategoriesController

{

     public function __invoke(Request $request)
     {

        $categories = $request->attributes->get('data');
        //dd($categories);
        if(!($categories instanceof Categories)) {
            throw new \RuntimeException('Catégorie attendue');
        }   
        
        
        //dd($_FILES);
        $categories->setTitle($_POST['title']);
        //dd($_POST['title']);
        $categories->setFile($request->files->get('file'));
        //dd($categories);
        $categories->setUpdatedAt(new \DateTime());
        return $categories;
        //dd($properties);
     }

}