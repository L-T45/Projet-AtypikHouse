<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Repository\ReservationsRepository;


class TheBestRatedProperty
{

    private $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }

    public function __invoke()
    {
        return $this->reservationsRepository->theBestRatedProperty();
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