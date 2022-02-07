<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reports;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ReportsController
{



    public function approveReport(Request $request, EntityManagerInterface $manager)
    {
        $report = $request->attributes->get('data');

        $report->setReportState("Accepté");


        $manager->persist($report);
        $manager->flush();

        if (!($report instanceof Reports)) {
            throw new \RuntimeException('User attendue');
        }

        return new Response('Signalement approuvé avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }


    public function disapproveReport(Request $request, EntityManagerInterface $manager)
    {

        $report = $request->attributes->get('data');

        $report->setReportState("Rejeté");
        $manager->persist($report);
        $manager->flush();

        if (!($report instanceof Reports)) {
            throw new \RuntimeException('User attendue');
        }

        return new Response('Signalement désapprouvé avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}
