<?php

namespace App\Controller;

use App\Entity\Equipements;
use App\Repository\EquipementsRepository;


class LastNewEquipements
{

    private $equipementsRepository;

    public function __construct(EquipementsRepository $equipementsRepository)
    {
        $this->equipementsRepository = $equipementsRepository;
    }

    public function __invoke()
    {
        return $this->equipementsRepository->findLatest();
    }

}

