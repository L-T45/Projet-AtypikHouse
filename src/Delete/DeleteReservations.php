<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reservations;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteReservations extends AbstractController {

    // Pour le formulaire de delete Reservations
    private $idReservations;
    private $ReservationsRepository;

    public function DeleteReservations(Request $request, ReservationsRepository $ReservationsRepository): Response{

        $data = $request->query->get('id');
        $idReservations = $data;
 
        $this->ReservationsRepository = $ReservationsRepository;
        $findReservationsToDelete = $this->ReservationsRepository->findByIdToDelete($idReservations);

            if($findReservationsToDelete =! []){
                $response = new Response('Réservation supprimée',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression de la réservation...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}