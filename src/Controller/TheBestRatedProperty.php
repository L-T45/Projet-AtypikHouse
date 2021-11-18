<?php

namespace App\Controller;

use App\Entity\Properties;
use App\Repository\PropertiesRepository;


class TheBestRatedProperty
{

    private $propertiesRepository;

    public function __construct(PropertiesRepository $propertiesRepository)
    {
        $this->propertiesRepository = $propertiesRepository;
    }

    public function __invoke()
    {
        return $this->propertiesRepository->theBestRatedProperty();
    }

/*
   public function __invoke()
   {
      
      $repository = $this->getDoctrine()->getRepository(Properties::class);
      $repository = $repository->findAll();
      dump($repository);
      
   }

*/
} 