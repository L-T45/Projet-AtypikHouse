<?php

namespace App\Controller;

use App\Entity\Properties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Equipements;
use App\Entity\AttributesAnswers;
use App\Entity\PropertiesGallery;

class UpdatePropertiesController

{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function updateInfos(Request $request)
    {
        $properties = $request->attributes->get('data');
        if (isset($_POST['title'])) {

            if (!($properties instanceof Properties)) {
                throw new \RuntimeException('Propriété attendue');
            }

            if (isset($_POST['title'])) {
                $properties->setTitle($_POST['title']);
            }
            if (isset($_POST['category'])) {

                $categoryRef = $this->manager->getReference("App\Entity\Equipements", $_POST['category']);
                $properties->setCategories($categoryRef);
                //dd($_POST['title']);

            }
            $this->manager->persist($properties);
            $this->manager->flush();
            return new Response('Propriétés modifiés', Response::HTTP_OK, ['content-type' => 'application/json']);
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



    }











    public function updateAttributesAnswers(Request $request)
    {
        $properties = $request->attributes->get('data');

        $attributesanswers = [];

        if (isset($_POST["attributesanswers"])) {
            $attributesanswers = $_POST["attributesanswers"];
        }


        if ($attributesanswers && count($attributesanswers) > 0) {
            foreach ($attributesanswers as $attributesanswer) {
                $attributesanswer = $this->manager->getReference("App\Entity\AttributesAnswers", $attributesanswer);
                $properties->addAttributesAnswer($attributesanswer);
            }
        }


        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }
        $this->manager->persist($properties);
        $this->manager->flush();
    }

    public function updateCaracteristics(Request $request)
    {
        $properties = $request->attributes->get('data');
        if (isset($_POST['price'])) {

            $properties->setPrice($_POST['price']);
        }
        $this->manager->persist($properties);
        $this->manager->flush();

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }
    }

    public function updateEquipements(Request $request)
    {
        $properties = $request->attributes->get('data');

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }
        $equipements = [];
        if (isset($_POST['equipements'])) {

            $equipements = [];

            if (isset($_POST['equipements'])) {
                $equipements = $_POST['equipements'];
            }

            if ($equipements && count($equipements) > 0) {
                foreach ($equipements as $equipement) {
                    $equipement = $this->manager->getReference("App\Entity\Equipements", $equipement);
                    $properties->addEquipement($equipement);
                }
            }
        }
        $this->manager->persist($properties);
        $this->manager->flush();
        return new Response('Equipements modifiés', Response::HTTP_OK, ['content-type' => 'application/json']);
    }


    public function insertNewGalleryPictures(Request $request)
    {

        $properties = $request->attributes->get('data');
        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }
        $post = json_decode($request->getContent(), true);
        $pictures = $request->files->get('pictures');

        $propertyRef =  $this->manager->getReference("App\Entity\Properties", $post["categories"]);

        foreach ($pictures as $key => $value) {

            $newGalleryPicture = new PropertiesGallery();
            $newGalleryPicture->getProperties($propertyRef);
            $newGalleryPicture->setFile($value);


            $this->manager->persist($newGalleryPicture);
            $this->manager->flush();
        }
        return new Response('Nouvelles photos bien insérées', Response::HTTP_OK, ['content-type' => 'application/json']);
    }



    public function updateLocality(Request $request)
    {

        $properties = $request->attributes->get('data');
        $post = json_decode($request->getContent(), true);

        dd($post);
        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }
        $properties->setLatitude($post->lat);
        $properties->setLongitude($post->lat);
        $properties->setCity($post->lat);
        $properties->setAddress($post->lat);
        $properties->setCountry($post->lat);

        $this->manager->persist($properties);
        $this->manager->flush();
        return new Response('Localité modifié avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}
