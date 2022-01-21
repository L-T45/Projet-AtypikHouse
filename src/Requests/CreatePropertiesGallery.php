<?php

namespace App\Requests;

use Doctrine\Persistence\ObjectManager;
use App\Entity\PropertiesGallery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse; 
use App\Repository\PropertiesGalleryRepository; 

class CreatePropertiesGallery extends AbstractController{
    
    // Pour le formulaire de création de Gallerie photo
    private $properties;
    private $picture;
    private $alt;

    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function newPropertiesGallery(EntityManagerInterface $manager, Request $request, PropertiesGalleryRepository $PropertiesGalleryRepository): Response
    {
        $propertiesGallery = Array();
        $propertiesGallery = new PropertiesGallery();

        // Données du formulaire de Gallerie photo  
        $properties = $_POST["properties"];
        $properties = serialize($properties); 
        $properties = $this->cutChaine($properties, ':"', '";');

        $picture = $_POST["picture"]; 
        $picture = serialize($picture);
        $picture = $this->cutChaine($picture, ':"', '";');

        $alt = $_POST["alt"]; 
        $alt = serialize($alt);
        $alt = $this->cutChaine($alt, ':"', '";');

        $this->PropertiesGalleryRepository = $PropertiesGalleryRepository;
        $findPropertiesGallery = $this->PropertiesGalleryRepository->findByPropertiesGallery($alt);
        $findPropertiesGalleryCheck = $findPropertiesGallery;
        
        if($findPropertiesGalleryCheck === [])
        { 
            dd($propertiesGallery->setProperties($properties));
            $propertiesGallery->setPicture($picture);
            $propertiesGallery->setAlt($alt);
            $manager->persist($propertiesGallery);
            $manager->flush();
            return new JsonResponse( ['status' => '200', 'title' => 'Votre gallery photo a bien été créé'], JsonResponse::HTTP_CREATED ); 
        }
        else{
            return new JsonResponse( ['status' => '400', 'title' => 'Bad Request', 'message' => 'Création de votre gallery photo impossible car une gallery photo est déjà créé !'], JsonResponse::HTTP_CREATED );
        }
    }
}
