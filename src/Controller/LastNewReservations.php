<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Repository\ReservationsRepository;


class LastNewReservations
{

    private $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }

    public function __invoke()
    {
        return $this->reservationsRepository->findLatest();
    }

}

