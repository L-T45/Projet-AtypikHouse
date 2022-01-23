<?php

namespace App\Controller;

use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Request;


class PostPictureController

{

     public function __invoke(Properties $properties, Request $request)
     {

        $file = $request->files->get('file');
        dd($file, $properties);
     }

}