<?php

namespace App\Token;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class DecodeJWTAuth extends AbstractController
{
    private $token;
    private $username;

    // pour ne concerver que ce que l'on souhaite après avoir serialize une variable de type array 
    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);   
    }

    public function decodeJwtToken(JWTEncoderInterface $jwtManager, Request $request)
    {   
        //récupère le token envoyé au front 
        $data = json_decode( $request->getContent(), true );
        $token = $data['token'];
        $decodedJwtToken = $jwtManager->decode($token);
        //dd($decodedJwtToken);

        if($decodedJwtToken =! ''){
            $username = serialize($jwtManager->decode($token));
            //dd($username);
            $username = $this->cutChaine($username, '"username";s:', ';'); 
            $username = $this->cutChaine($username, ':"', '"'); 
            //dd($username);
            if($username =! ''){
                
            }
        }

    }
}