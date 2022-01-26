<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;


class PostCategoriesController

{

     public function __invoke(Request $request)
     {

        $categories = $request->attributes->get('data');
        //dd($categories);
        if(!($categories instanceof Categories)) {
            throw new \RuntimeException('Catégorie attendue');
        }   
        
        
        //dd($_FILES);
        $categories->setFile($request->files->get('file'));
        dd($request->files);
        $categories->setUpdatedAt(new \DateTime());
        return $categories;
        //dd($categories);

     }

}