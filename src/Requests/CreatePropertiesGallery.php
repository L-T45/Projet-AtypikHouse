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
use App\Entity\Properties;

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
        $em = $this->getDoctrine()->getManager();

        // Données du formulaire de Gallerie photo  
        
        $postProperties = $_POST["properties"];
        $postProperties = serialize($postProperties); 
        $postProperties = $this->cutChaine($postProperties, ':"', '";'); 
        $properties = new Properties();
        $properties = $em->getReference("App\Entity\Properties", $postProperties);

        // $picture = $_POST["picture"]; 
        // $picture = serialize($picture);
        // $picture = $this->cutChaine($picture, ':"', '";');

        $file = $request->files->get('file');
        //dd($file);

        $alt = $_POST["alt"]; 
        $alt = serialize($alt);
        $alt = $this->cutChaine($alt, ':"', '";');

        $this->PropertiesGalleryRepository = $PropertiesGalleryRepository;
        $findPropertiesGallery = $this->PropertiesGalleryRepository->findByPropertiesGallery($alt);
        $findPropertiesGalleryCheck = $findPropertiesGallery;
        
        if($findPropertiesGalleryCheck === [])
        { 
            $propertiesGallery->setProperties($properties);
            $propertiesGallery->setPicture($file);
            $propertiesGallery->setFile($file);
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
