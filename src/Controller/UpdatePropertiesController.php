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


    public function updateInfos(Request $request)
    {
        $properties = $request->attributes->get('data');
        //dd($properties);

        $post = json_decode($request->getContent(), true);
        //   dd($post["title"]);


        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        if (isset($post["title"])) {
            $properties->setTitle($post["title"]);
        }
        if (isset($post['category'])) {

            $categoryRef = $this->manager->getReference("App\Entity\Categories", $post['category']);
            $properties->setCategories($categoryRef);
        }
        $this->manager->persist($properties);
        $this->manager->flush();
        return new Response('Les informations de la propriété ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }


    public function updateAttributesAnswers(Request $request)
    {

        $post = json_decode($request->getContent(), true);
        $data = $post["attributesanswer"];

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

        return new Response('Les réponses ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function updateCaracteristics(Request $request)
    {
        $properties = $request->attributes->get('data');

        $post = json_decode($request->getContent(), true);

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        if (isset($post['price'])) {

            $properties->setPrice($post['price']);
        }

        if (isset($post['rooms'])) {

            $properties->setRooms($post['rooms']);
        }
        if (isset($post['capacity'])) {

            $properties->setCapacity($post['capacity']);
        }

        if (isset($post['bedrooms'])) {

            $properties->setBedrooms($post['bedrooms']);
        }

        if (isset($post['surface'])) {

            $properties->setSurface($post['surface']);
        }

        $this->manager->persist($properties);
        $this->manager->flush();
        return new Response('Les caractéristiques de la propriété ont été modifiées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function updateEquipements(Request $request)
    {
        $properties = $request->attributes->get('data');
        //dd($properties);
        $propertiesid = $properties->getId();

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        $post = json_decode($request->getContent(), true);
        $equipements = [];

        if (isset($post['equipements'])) {

            $equipements = $post['equipements'];

            //dd($equipements);

            //$findEquipements = $this->equipementrepo->DeleteEquipementsByProperties($propertiesid);
            //dd($findEquipements);

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
        return new Response('Equipements modifiés avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }


    public function insertNewGalleryPictures(Request $request)
    {

        $properties = $request->attributes->get('data');

        //dd($propertiesid);

        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        $pictures = $request->files->get('pictures');
        // dd($pictures);

        $propertyRef =  $this->manager->getReference("App\Entity\Properties", $properties->getId());

        foreach ($pictures as $picture) {

            $newGalleryPicture = new PropertiesGallery();
            $newGalleryPicture->setProperties($propertyRef);
            $newGalleryPicture->setFile($picture);


            $this->manager->persist($newGalleryPicture);
            $this->manager->flush();
        }
        return new Response('Nouvelles photos insérées avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
    }



    public function updateLocality(Request $request)
    {

        $properties = $request->attributes->get('data');
        $post = json_decode($request->getContent(), true);

        //dd($post);
        if (!($properties instanceof Properties)) {
            throw new \RuntimeException('Propriété attendue');
        }

        if (isset($post["latitude"])) {

            $properties->setLatitude($post["latitude"]);
        }

        if (isset($post["longitude"])) {

            $properties->setLongitude($post["longitude"]);
        }

        if (isset($post["city"])) {

            $properties->setCity($post["city"]);
        }

        if (isset($post["address"])) {

            $properties->setAddress($post["address"]);
        }

        if (isset($post["country"])) {

            $properties->setCountry($post["country"]);
        }

        $this->manager->persist($properties);
        $this->manager->flush();
        return new Response('Localité modifiée avec succès', Response::HTTP_OK, ['content-type' => 'application/json']);
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
