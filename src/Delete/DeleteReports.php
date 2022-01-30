<?php

namespace App\Delete;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reports;
use App\Repository\ReportsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  

class DeleteReports extends AbstractController {

    // Pour le formulaire de delete Reports
    private $idReports;
    private $ReportsRepository;

    public function DeleteReports(Request $request, ReportsRepository $ReportsRepository): Response{

        $data = $request->query->get('id');
        $idReports = $data;
 
        $this->ReportsRepository = $ReportsRepository;
        $findReportsToDelete = $this->ReportsRepository->findByIdToDelete($idReports);

            if($findReportsToDelete =! []){
                $response = new Response('Report supprimé',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la suppression du report...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }
}