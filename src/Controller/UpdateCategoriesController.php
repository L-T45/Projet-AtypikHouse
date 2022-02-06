<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;


class UpdateCategoriesController

{

     public function __invoke(Request $request)
     {

        $categories = $request->attributes->get('data');
        
        if(!($categories instanceof Categories)) {
            throw new \RuntimeException('Catégorie attendue');
        }   
        
        if(isset($_POST['title'])) {
            $categories->setTitle($_POST['title']);
        }

        if(isset($_POST['description'])) {
            $categories->setDescription($_POST['description']);
        }

        $getFile = $request->files->get('file');

        if(isset($getFile)) {
            $categories->setFile($getFile);
            $categories->setPicture($getFile);
        }

        $categories->setUpdatedAt(new \DateTime());
        return $categories;
     }

}