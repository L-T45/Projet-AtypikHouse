<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;

class LastNewProperties
{

   protected $em;
   
   public function __construct(EntityManagerInterface $em)
   {
       $this->em = $em;
   }

   public function __invoke(Properties $data)
   {
      
      dd($data);
   }


}