<?php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

Class DecodeJWTAuth extends AbstractController
{
    private $token;

    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
        {
            $this->jwtManager = $jwtManager;
            $this->tokenStorageInterface = $tokenStorageInterface;
        }

    public function decodeJwtToken(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
    }
}