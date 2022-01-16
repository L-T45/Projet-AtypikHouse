<?php

namespace App\Token;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class DecodeJWTAuth extends AbstractController
{
    private $token;

    public function decodeJwtToken(JWTEncoderInterface $jwtManager, Request $request)
    {   
        //récupère le token envoyé au front 
        $data = json_decode( $request->getContent(), true );
        $token = $data['token'];
        $decodedJwtToken = $jwtManager->decode($token);

        
    }
}