<?php

namespace App\Controller;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;

class ListPropertiesByCategory
{

   private $categoriesRepository;
   
   
   public function __construct(CategoriesRepository $categoriesRepository)
   {
       $this->categoriesRepository = $categoriesRepository; 
      

   }

   public function __invoke()
   {
      
      return $this->categoriesRepository->findPropertiesByCategory(2);
   }


}