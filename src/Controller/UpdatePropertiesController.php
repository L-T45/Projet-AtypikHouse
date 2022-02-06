<?php

namespace App\Controller;

use App\Entity\Properties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Equipements;
use App\Entity\AttributesAnswers;


class UpdatePropertiesController

{

     public function __invoke(EntityManagerInterface $manager, Request $request):Response
     {

        $properties = $request->attributes->get('data');

        if(!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }
        
        if(isset($_POST['title'])) {
            
            $properties->setTitle($_POST['title']);
            //dd($_POST['title']);

        }
       
         if(isset($_POST['price'])) {
            
            $properties->setPrice($_POST['price']);
            //dd($_POST['price']);

        }
        
       
       // $properties->setPrice($_POST['price']);
        //dd($_POST['price']);
        $equipements = [];
        if(isset($_POST['equipements'])) {

        $equipements = [];

        if(isset($_POST['equipements'])) {
            $equipements = $_POST['equipements'];
        }

        if ($equipements && count($equipements) > 0) {
            foreach ($equipements as $equipement) {
                $equipement = $manager->getReference("App\Entity\Equipements", $equipement);
                $properties->addEquipement($equipement);
            }
        }

       
        $attributesanswers = [];

        if(isset($_POST["attributesanswers"])) {
            $attributesanswers = $_POST["attributesanswers"];
        }


        if($attributesanswers && count($attributesanswers) > 0) {
            foreach ($attributesanswers as $attributesanswer) {  
                $attributesanswer = $manager->getReference("App\Entity\AttributesAnswers", $attributesanswer);
                $properties->addAttributesAnswer($attributesanswer);
            }
        }

        $properties->setFile($request->files->get('file'));
        
        $properties->setUpdatedAt(new \DateTime());
        $manager->persist($properties);
        $manager->flush();

        return new JsonResponse(['status' => '200', 'title' => 'Votre bien a été modifié avec succès'], JsonResponse::HTTP_CREATED);
       
        }
    }
}