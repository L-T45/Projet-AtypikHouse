<?php

namespace App\Requests;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PropertiesRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Entity\User;
use App\Entity\PropertiesGallery;
use App\Entity\Categories;
use App\Entity\Equipements;
use App\Entity\AttributesAnswers;
use Attribute;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CreateProperties extends AbstractController
{

    // Pour le formulaire de création de propriété
    private $title;
    private $slug;
    private $price;
    private $rooms;
    private $booking;
    private $address;
    private $city;
    private $latitude;
    private $longitude;
    private $bedrooms;
    private $surface;
    private $reference;
    private $zipCode;
    private $country;
    private $picture;
    private $capacity;
    private $equipements;
    private $categories;
    private $propertiesgallery;
    private $user;
    private $CheckNewToken;

    public function cutChaine($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    public function __invoke(EntityManagerInterface $manager, Request $request, PropertiesRepository $PropertiesRepository, JWTTokenManagerInterface $JWTManager): Response
    {
        $properties = array();
        $properties = new Properties();


        // Données du formulaire de properties  
        $title = $_POST["title"];
        $title = serialize($title);
        $title = $this->cutChaine($title, ':"', '";');

        $slug = $_POST["slug"];
        $slug = serialize($slug);
        $slug = $this->cutChaine($slug, ':"', '";');

        $price = $_POST["price"];
        $price = serialize($price);
        $price = $this->cutChaine($price, ':"', '";');

        $rooms = $_POST["rooms"];
        $rooms = serialize($rooms);
        $rooms = $this->cutChaine($rooms, ':"', '";');

        $booking = $_POST["booking"];
        $booking = serialize($booking);
        $booking = $this->cutChaine($booking, ':"', '";');

        $address = $_POST["address"];
        $address = serialize($address);
        $address = $this->cutChaine($address, ':"', '";');

        $city = $_POST["city"];
        $city = serialize($city);
        $city = $this->cutChaine($city, ':"', '";');

        $latitude = $_POST["latitude"];
        $latitude = serialize($latitude);
        $latitude = $this->cutChaine($latitude, ':"', '";');

        $longitude = $_POST["longitude"];
        $longitude = serialize($longitude);
        $longitude = $this->cutChaine($longitude, ':"', '";');

        $bedrooms = $_POST["bedrooms"];
        $bedrooms = serialize($bedrooms);
        $bedrooms = $this->cutChaine($bedrooms, ':"', '";');

        $surface = $_POST["surface"];
        $surface = serialize($surface);
        $surface = $this->cutChaine($surface, ':"', '";');

        $reference = $_POST["reference"];
        $reference = serialize($reference);
        $reference = $this->cutChaine($reference, ':"', '";');

        $zipCode = $_POST["zipCode"];
        $zipCode = serialize($zipCode);
        $zipCode = $this->cutChaine($zipCode, ':"', '";');

        $country = $_POST["country"];
        $country = serialize($country);
        $country = $this->cutChaine($country, ':"', '";');

        $file = $request->files->get('file');

        $capacity = $_POST["capacity"];
        $capacity = serialize($capacity);
        $capacity = $this->cutChaine($capacity, ':"', '";');

        $equipements = [];
        if (isset($_POST["equipements"])) {
            $equipements = $_POST["equipements"];
            //dd($equipements);
        }

        $attributesanswers = [];
        if (isset($_POST["attributesanswers"])) {

            $attributesanswers = $_POST["attributesanswers"];
        }

        $postCategories = $_POST["categories"];
        $postCategories = serialize($postCategories);
        $postCategories = $this->cutChaine($postCategories, ':"', '";');
        $categories = new Categories();
        $categories = $manager->getReference("App\Entity\Categories", $postCategories);

        $postUser = $_POST["user"];
        $postUser = serialize($postUser);
        $postUser = $this->cutChaine($postUser, ':"', '";');
        $user = new User();
        $user = $manager->getReference("App\Entity\User", $postUser);

        $this->PropertiesRepository = $PropertiesRepository;
        $findProperties = $this->PropertiesRepository->findAddress($address);
        $findPropertiesCheck = $findProperties;

        if ($findPropertiesCheck === []) {
            $properties->setTitle($title);
            $properties->setSlug($slug);
            $properties->setPrice($price);
            $properties->setRooms($rooms);
            $properties->setAddress($address);
            $properties->setBooking($booking);
            $properties->setCity($city);
            $properties->setLatitude($latitude);
            $properties->setLongitude($longitude);
            $properties->setBedrooms($bedrooms);
            $properties->setSurface($surface);
            $properties->setReference($reference);
            $properties->setPicture($file);
            $properties->setFile($file);
            $properties->setCountry($country);
            $properties->setCapacity($capacity);
            $properties->setZipCode($zipCode);

            if ($equipements && count($equipements) > 0) {
                foreach ($equipements as $equipement) {

                    $equipement = $manager->getReference("App\Entity\Equipements", $equipement);
                    $properties->addEquipement($equipement);
                }
            }

            $properties->setCategories($categories);
            $properties->setUser($user);

            $manager->persist($properties);
            $manager->flush();
            $propertiesid = $properties->getId();
            
            $this->PropertiesRepository = $PropertiesRepository;
            $findPropertiesUser = $this->PropertiesRepository->FindByUserCreateProperties($postUser);

            if ($findPropertiesUser[0]['roles'] == ["ROLE_USER"]) {
                $user->setRoles(['ROLE_USER','ROLE_OWNER']);
                $manager->persist($user);
                $manager->flush();
                $NewToken = $JWTManager->create($user);
                $CheckNewToken = $NewToken;
            }
            else {
                $CheckNewToken = "";
            }
    
            if ($attributesanswers && count($attributesanswers) > 0) {
                foreach ($attributesanswers as $attributesanswer) {

                    $AttributesRef = $manager->getReference("App\Entity\Attributes", $attributesanswer["attributes"]);
                    $propertyRef = $manager->getReference("App\Entity\Properties", $propertiesid);

                    $newAttributes = new AttributesAnswers();
                    $newAttributes->setProperties($propertyRef);
                    $newAttributes->setAttributes($AttributesRef);
                    $newAttributes->setResponseBool($attributesanswer["response_bool"]);
                    $newAttributes->setResponseString($attributesanswer["response_string"]);
                    $newAttributes->setResponseNbr(intval($attributesanswer["response_number"]));
                    $manager->persist($newAttributes);
                    $manager->flush();
                }
            }

            if($CheckNewToken != ""){
                return new JsonResponse(['status' => '200', 'Properties id' => $propertiesid, "New token" => $NewToken, 'title' => 'Votre location de bien a bien été créé'], JsonResponse::HTTP_CREATED);
            }
            else{
                return new JsonResponse(['status' => '200', 'Properties id' => $propertiesid, 'title' => 'Votre location de bien a bien été créé'], JsonResponse::HTTP_CREATED);
            }

            
        } else {
            return new JsonResponse(['status' => '400', 'title' => 'Bad Request', 'message' => 'Création de votre location de bien impossible car un bien est déjà créé à cette adresse !'], JsonResponse::HTTP_CREATED);
        }
    }
}
