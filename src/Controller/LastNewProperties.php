<?php

namespace App\Controller;
use App\Entity\Properties;
use App\Repository\PropertiesRepository;

class LastNewProperties
{

   private $propertiesRepository;
   
   public function __construct(PropertiesRepository $propertiesRepository)
   {
       $this->propertiesRepository = $propertiesRepository; 
   }

   public function __invoke()
   {
      
      return $this->propertiesRepository->findLatest();
   }


}