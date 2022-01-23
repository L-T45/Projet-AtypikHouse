<?php

namespace App\Controller;

use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Request;


class PostPictureController

{

     public function __invoke(Request $request)
     {

        $properties = $request->attributes->get('data');
        if(!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }   
        
        
        $properties->setFile($request->files->get('file'));
        $properties->setUpdatedAt(new \DateTime());
       //dd($file, $properties);
        return $properties;

     }

}