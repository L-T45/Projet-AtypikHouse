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

class CreateProperties extends AbstractController{
    
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

    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function newProperties(EntityManagerInterface $manager, Request $request, PropertiesRepository $PropertiesRepository): Response
    {
        $properties = Array();
        $properties = new Properties();

        // Données du formulaire de register  
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

        $picture = $_POST["picture"]; 
        $picture = serialize($picture);
        $picture = $this->cutChaine($picture, ':"', '";');

        $capacity = $_POST["capacity"]; 
        $capacity = serialize($capacity);
        $capacity = $this->cutChaine($capacity, ':"', '";');

        $equipements = $_POST["equipements"]; 

        $categories = $_POST["categories"]; 
        $categories = serialize($categories);
        $categories = $this->cutChaine($categories, ':"', '";');

        $propertiesgallery = $_POST["propertiesgallery"]; 
        $propertiesgallery = serialize($propertiesgallery);
        $propertiesgallery = $this->cutChaine($propertiesgallery, ':"', '";');

        $user = $_POST["user"]; 
        $user = serialize($user);
        $user = $this->cutChaine($user, ':"', '";');

        $this->PropertiesRepository = $PropertiesRepository;
        $findProperties = $this->PropertiesRepository->findAddress($address);
        $findPropertiesCheck = $findProperties;
        
        if($findPropertiesCheck === [])
        { 
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
            $properties->setPicture($picture);
            $properties->setCountry($country);
            $properties->setCapacity($capacity);
            $properties->setZipCode($zipCode);
            $properties->getEquipements($equipements);
            $properties->getCategories($categories);
            $properties->getPropertiesGalleries($propertiesgallery);
            $properties->getUser($user);  

            $manager->persist($properties);
            $manager->flush();
            return new JsonResponse( ['status' => '200', 'title' => 'Votre location de bien a bien été créé'], JsonResponse::HTTP_CREATED ); 
        }
        else{
            return new JsonResponse( ['status' => '400', 'title' => 'Bad Request', 'message' => 'Création de votre location de bien impossible car un bien est déjà créé à cette adresse !'], JsonResponse::HTTP_CREATED );
        }
    }
}
