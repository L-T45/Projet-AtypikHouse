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
use App\Repository\PropertiesRepository;
use App\Entity\Properties;
use Symfony\Component\Mailer\MailerInterface; 
use App\Email\SendEmailModifyProperties;

class CreatePropertiesGallery extends AbstractController
{

    // Pour le formulaire de création de Gallerie photo
    private $properties;
    private $picture;


    public function cutChaine($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function newPropertiesGallery(EntityManagerInterface $manager, Request $request, PropertiesRepository $PropertiesRepository, PropertiesGalleryRepository $PropertiesGalleryRepository, SendEmailModifyProperties $SendEmail, MailerInterface $mailer): Response
    {
        $propertiesGallery = array();

        // Données du formulaire de Gallerie photo  

        $postProperties = $_POST["properties"];
        $postProperties = serialize($postProperties);
        $postProperties = $this->cutChaine($postProperties, ':"', '";');
        $properties = new Properties();
        $properties = $manager->getReference("App\Entity\Properties", $postProperties);

        $file = $request->files->get('file');

        foreach ($file as $single) {

            $propertiesGallery = new PropertiesGallery();

            $propertiesGallery->setProperties($properties);
            $propertiesGallery->setPicture($single);
            $propertiesGallery->setFile($single);
            $manager->persist($propertiesGallery);
            $manager->flush();

            $this->PropertiesRepository = $PropertiesRepository;
            $findOwnerProperties = $this->PropertiesRepository->findByIdUser($properties);
            $findCheckOwnerProperties = $findOwnerProperties;

            if($findCheckOwnerProperties =! []){
                $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
                $response = new Response('Photo(s) ajoutée(s)',Response::HTTP_OK,['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de l'ajout de la/les photo(s)...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        }
        return $response;
    }
}
