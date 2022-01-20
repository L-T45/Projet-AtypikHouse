<?php

namespace App\Token;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DecodeJWTAuth extends AbstractController
{
    private $token;
    private $username;
    private $UserRepository;

    // pour ne concerver que ce que l'on souhaite après avoir serialize une variable de type array 
    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);   
    }

    public function decodeJwtToken(JWTEncoderInterface $jwtManager, Request $request, UserRepository $UserRepository): Response
    {   
        //récupère le token envoyé au front 
        $data = json_decode( $request->getContent(), true );
        $token = $data['token'];
        $decodedJwtToken = $jwtManager->decode($token);
        $decodedJwtTokenCheck = $decodedJwtToken;

        if($decodedJwtTokenCheck =! ''){
            $username = serialize($decodedJwtToken);
            $username = $this->cutChaine($username, '"username";s:', ';'); 
            $username = $this->cutChaine($username, ':"', '"'); 
            $usernameCheck = $username;

            if($usernameCheck =! ''){
                $this->UserRepository = $UserRepository;
                $findUser = $this->UserRepository->findByEmail($username);
                $findUserCheck = $findUser;

                if($findUserCheck =! ''){
                    return new JsonResponse( [ 'status' => '200', 'User' => $findUser ], JsonResponse::HTTP_CREATED ); 
                }else{
                    return new JsonResponse( [ 'status' => '500', 'title' => 'Server Error', 'message' => "Erreur de récupération des données de l'utilisateur" ], JsonResponse::HTTP_CREATED ); 
                }
                
            }else{
                return new JsonResponse( [ 'status' => '500', 'title' => 'Server Error', 'message' => "Erreur de récupération des données de l'utilisateur" ], JsonResponse::HTTP_CREATED ); 
            }

        }else{
            return new JsonResponse( [ 'status' => '500', 'title' => 'Server Error', 'message' => "Erreur de récupération des données de l'utilisateur" ], JsonResponse::HTTP_CREATED ); 
        }

    }
}