<?php

namespace App\Controller;

use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Request;


class UpdatePropertiesController

{

     public function __invoke(Request $request)
     {

        $properties = $request->attributes->get('data');
        //dd($categories);
        if(!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
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