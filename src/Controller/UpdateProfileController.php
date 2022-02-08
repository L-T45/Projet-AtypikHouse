<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class UpdateUserController

{

     public function __invoke(Request $request)
     {

        $user = $request->attributes->get('data');
        
        if(!($user instanceof User)) {
            throw new \RuntimeException('User attendue');
        }   
        
        if(isset($_POST['title'])) {
            $user->setTitle($_POST['title']);
        }

        if(isset($_POST['description'])) {
            $user->setDescription($_POST['description']);
        }

        $getFile = $request->files->get('file');

        if(isset($getFile)) {
            $user->setFile($getFile);
            $user->setPicture($getFile);
        }

        $user->setUpdatedAt(new \DateTime());
        return $user;
     }

}