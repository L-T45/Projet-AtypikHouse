<?php

namespace App\Controller;

use App\Entity\Properties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface; 
use App\Email\SendEmailModifyProperties;
use App\Entity\Equipements;
use App\Entity\AttributesAnswers;
use App\Entity\PropertiesGallery;
use App\Repository\AttributesAnswersRepository;
use App\Repository\PropertiesRepository;
use App\Repository\EquipementsRepository;

class UpdatePropertiesController

{

    public function __construct(EntityManagerInterface $manager, AttributesAnswersRepository $attributesanswersrepo, PropertiesRepository $propertiesrepo, EquipementsRepository $equipementsrepo)
    {
        $this->manager = $manager;
        $this->attributesanswersrepo = $attributesanswersrepo;
        $this->propertiesrepo = $propertiesrepo;
        $this->equipementrepo = $equipementsrepo;
    }


    public function updateInfos(Request $request, SendEmailModifyProperties $SendEmail, MailerInterface $mailer)
    {
        $properties = $request->attributes->get('data');
        $idProperties = $properties->getId();

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        if (isset($_POST['title'])) {
            $properties->setTitle($_POST['title']);
        }
        if (isset($_POST['category'])) {

<<<<<<< HEAD
                $categoryRef = $this->manager->getReference("App\Entity\Categories", $_POST['category']);
                $properties->setCategories($categoryRef);

            }
            $this->manager->persist($properties);
            $this->manager->flush();

            $findOwnerProperties = $this->propertiesrepo->findByIdUser($idProperties);
            $findCheckOwnerProperties = $findOwnerProperties;

            if($findCheckOwnerProperties =! []){
                $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
                $response =  new Response('Les informations de la propriété ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la modification des informations de la propriété...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
       
    }
=======
            $categoryRef = $this->manager->getReference("App\Entity\Categories", $_POST['category']);
            $properties->setCategories($categoryRef);
        }
        $this->manager->persist($properties);
        $this->manager->flush();
        return new Response('Les informations de la propriété ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }
    // if(isset($_POST['slug'])) {
    //     $properties->setSlug($_POST['slug']);
    // }
    // if(isset($_POST['price'])) {
    //     $properties->setPrice($_POST['price']);
    // }
    // if(isset($_POST['rooms'])) {
    //     $properties->setRooms($_POST['rooms']);
    // }
    // if(isset($_POST['booking'])) {
    //     $properties->setBooking($_POST['booking']);
    // }
    // if(isset($_POST['address'])) {
    //     $properties->setAddress($_POST['address']);
    // }
    // if(isset($_POST['latitude'])) {
    //     $properties->setLatitude($_POST['latitude']);
    // }
    // if(isset($_POST['longitude'])) {
    //     $properties->setLongitude($_POST['longitude']);
    // }
    // if(isset($_POST['bedrooms'])) {
    //     $properties->setBedrooms($_POST['bedrooms']);
    // }
    // if(isset($_POST['surface'])) {
    //     $properties->setSurface($_POST['surface']);
    // }
    // if(isset($_POST['reference'])) {
    //     $properties->setReference($_POST['reference']);
    // }
    // if(isset($_POST['zipCode'])) {
    //     $properties->setZipCode($_POST['zipCode']);
    // }
    // if(isset($_POST['country'])) {
    //     $properties->setCountry($_POST['country']);
    // }
>>>>>>> master


    public function updateAttributesAnswers(Request $request, SendEmailModifyProperties $SendEmail, MailerInterface $mailer)
    {

        $data = $_POST["attributesanswer"];
        $properties = $request->attributes->get('data');
        $idProperties = $properties->getId();

        if ($data && count($data) > 0) {
            foreach ($data as $attributesanswer) {
                $answer = array();
                $answer = new AttributesAnswers();
                $attributesid = $attributesanswer["id"];


                $answer = $this->attributesanswersrepo->findAttributesAnswersByid($attributesid);
                $answer = $answer[0];


                $answer->setResponseString($attributesanswer["response_string"]);
                $answer->setResponseBool($attributesanswer["response_bool"]);
                $answer->setResponseNbr($attributesanswer["response_nbr"]);
                $this->manager->persist($answer);
                $this->manager->flush();
            }
        }
<<<<<<< HEAD
        
        $findOwnerProperties = $this->propertiesrepo->findByIdUser($idProperties);
        $findCheckOwnerProperties = $findOwnerProperties;

            if($findCheckOwnerProperties =! []){
                $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
                $response =  new Response('Les réponses ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la modification des réponses ...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
=======
>>>>>>> master

        return new Response('Les réponses ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function updateCaracteristics(Request $request, SendEmailModifyProperties $SendEmail, MailerInterface $mailer)
    {
        $properties = $request->attributes->get('data');
        $idProperties = $properties->getId();

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        if (isset($_POST['price'])) {

            $properties->setPrice($_POST['price']);
        }

        if (isset($_POST['rooms'])) {

            $properties->setRooms($_POST['rooms']);
        }
        if (isset($_POST['capacity'])) {

            $properties->setCapacity($_POST['capacity']);
        }

        if (isset($_POST['bedrooms'])) {

            $properties->setBedrooms($_POST['bedrooms']);
        }

        if (isset($_POST['surface'])) {

            $properties->setSurface($_POST['surface']);
        }

        $this->manager->persist($properties);
        $this->manager->flush();

        $findOwnerProperties = $this->propertiesrepo->findByIdUser($idProperties);
        $findCheckOwnerProperties = $findOwnerProperties;

            if($findCheckOwnerProperties =! []){
                $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
                $response =  new Response('Les caractéristiques de la propriété ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
            }
            else{  
                $response = new Response("Une erreur est survenu lors de la modification des caractéristiques de la propriété ...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
            }
        return $response;
    }

    public function updateEquipements(Request $request, SendEmailModifyProperties $SendEmail, MailerInterface $mailer)
    {
        $properties = $request->attributes->get('data');
        $idProperties = $properties->getId();

        $propertiesid = $properties->getId();

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        $equipements = [];

        if (isset($_POST['equipements'])) {

            $equipements = $_POST['equipements'];

            $sql = 'DELETE FROM properties_equipements WHERE properties_equipements.properties_id = :id';

            $stmt = $this->manager->getConnection()->prepare($sql);
            $result = $stmt->executeQuery(['id' => $propertiesid])->fetchAllAssociative();


            if ($equipements && count($equipements) > 0) {
                foreach ($equipements as $equipement) {
                    $equipement = $this->manager->getReference("App\Entity\Equipements", $equipement);
                    $properties->addEquipement($equipement);
                }
            }
        }
        $this->manager->persist($properties);
        $this->manager->flush();

        $findOwnerProperties = $this->propertiesrepo->findByIdUser($idProperties);
        $findCheckOwnerProperties = $findOwnerProperties;

        if($findCheckOwnerProperties =! []){
            $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
            $response =  new Response('Equipements modifiés avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
        }
        else{  
            $response = new Response("Une erreur est survenu lors de la modification des Equipements ...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
        }
        return $response;
    }


    public function insertNewGalleryPictures(Request $request, SendEmailModifyProperties $SendEmail, MailerInterface $mailer)
    {

        $properties = $request->attributes->get('data');
        $idProperties = $properties->getId();


        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        $pictures = $request->files->get('pictures');

        $propertyRef =  $this->manager->getReference("App\Entity\Properties", $properties->getId());

        foreach ($pictures as $picture) {

            $newGalleryPicture = new PropertiesGallery();
            $newGalleryPicture->setProperties($propertyRef);
            $newGalleryPicture->setFile($picture);


            $this->manager->persist($newGalleryPicture);
            $this->manager->flush();
        }

        $findOwnerProperties = $this->propertiesrepo->findByIdUser($idProperties);
        $findCheckOwnerProperties = $findOwnerProperties;

        if($findCheckOwnerProperties =! []){
            $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
            $response =  new Response('Nouvelles photos insérées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
        }
        else{  
            $response = new Response("Une erreur est survenu lors de la modification des nouvelles photos ...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
        }
        return $response;
    }


    public function updateLocality(Request $request, SendEmailModifyProperties $SendEmail, MailerInterface $mailer)
    {

        $properties = $request->attributes->get('data');
<<<<<<< HEAD
        $idProperties = $properties->getId();
        
=======

>>>>>>> master

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        if (isset($_POST["latitude"])) {

            $properties->setLatitude($_POST["latitude"]);
        }

        if (isset($_POST["longitude"])) {

            $properties->setLongitude($_POST["longitude"]);
        }

        if (isset($_POST["city"])) {

            $properties->setCity($_POST["city"]);
        }

        if (isset($_POST["address"])) {

            $properties->setAddress($_POST["address"]);
        }

        if (isset($_POST["country"])) {

            $properties->setCountry($_POST["country"]);
        }

        $this->manager->persist($properties);
        $this->manager->flush();

        $findOwnerProperties = $this->propertiesrepo->findByIdUser($idProperties);
        $findCheckOwnerProperties = $findOwnerProperties;

        if($findCheckOwnerProperties =! []){
            $SendEmail->sendEmailModifyProperties($mailer, $request, $findOwnerProperties);
            $response =  new Response('Localité modifiée avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
        }
        else{  
            $response = new Response("Une erreur est survenu lors de la modification de la Localité...",Response::HTTP_BAD_REQUEST,['content-type' => 'application/json']);     
        }
        return $response;
    }



    public function updatepicture(Request $request)
    {

        $properties = $request->attributes->get('data');

        //dd($propertiesid);

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        $properties->setFile($request->files->get('picture'));
        $properties->setUpdatedAt(new \DateTime());
        $this->manager->persist($properties);
        $this->manager->flush();
        
        return new Response('La photo de la propriété a été modifiée avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }


}
