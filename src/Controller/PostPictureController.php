<?php

namespace App\Controller;

use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Request;


class PostPictureController

{

    public function __invoke(Request $request)
    {

        $properties = $request->attributes->get('data');
        //dd($properties);
        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }


        //dd($_FILES);
        $properties->setFile($request->files->get('file'));
        // dd($request->files);
        $properties->setUpdatedAt(new \DateTime());
        return $properties;
        //dd($properties);

    }
}
