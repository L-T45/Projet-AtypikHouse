<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ResetPassword extends AbstractController {

    // Pour le formulaire de delete properties

    private $idUser;
    private $UserRepository;
    private $old_pwd;
    private $new_pwd;

    public function UpdatePwd(Request $request, UserRepository $UserRepository, UserPasswordEncoderInterface $encoder): Response{

        $user = Array();
        $user = new User();

        $data = json_decode($request->getContent(), true);

        $old_pwd = $data["old_pwd"];
        $new_pwd = $data["new_pwd"];
        $idUser = $data["id"];
    
        //encodage password
        $old_pwd = $encoder->encodePassword($user, $old_pwd);
        $new_pwd = $encoder->encodePassword($user, $new_pwd);

        $this->UserRepository = $UserRepository;

        $password = $this->UserRepository->checkPassword($idUser);

        dd($password[0]["password"], $old_pwd);

        if ($password[0]["password"] == $old_pwd) {

            // execute the queries on the database
            $this->getEntityManager()->flush();

            $response = new Response('Mot de passe modifié avec succès', Response::HTTP_OK,['content-type' => 'application/json']);

            // $findUserToUpdatePwd = $this->UserRepository->resetPassword($idUser, $new_pwd);

            //     if($findUserToUpdatePwd =! 0){

            //         $response = new Response('Mot de passe modifié avec succès', Response::HTTP_OK,['content-type' => 'application/json']);

            //     }

            //     else{  

            //         $response = new Response("Une erreur est survenu lors du changement de mot de passe...", Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);    

            //     }

            //     return $response;

        }
        else{  

            $response = new Response("Une erreur est survenu lors du changement de mot de passe...", Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);    

        }
        
        return $response;

    }

}