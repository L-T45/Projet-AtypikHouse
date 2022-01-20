<?php

namespace App\Requests;

use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class Register extends AbstractController {
    // Pour le formulaire de register
    private $firstname;
    private $lastname;
    private $phone;
    private $email; 
    private $password;
    private $address;
    private $city;
    private $birthdate;
    private $zipCode;
    private $country;
    private $picture;

    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);

    }

    public function newUser(ObjectManager $manager): void
    {

        // Données du formulaire de register  
        $firstname = $_POST["firstname"];
        dump($firstname);
        $firstname = serialize($firstname); 
        $firstname = $this->cutChaine($firstname, ':"', '";'); 
        
        $lastname = $_POST["lastname"];
        $lastname = serialize($lastname);
        $lastname = $this->cutChaine($lastname, ':"', '";'); 
        
        $phone = $_POST["phone"];
        $phone = serialize($phone);
        $phone = $this->cutChaine($phone, ':"', '";'); 
        
        $email = $_POST["email"];
        $email = serialize($email);
        $email = $this->cutChaine($email, ':"', '";'); 
        
        $password = $_POST["password"];
        $password = serialize($password);
        $password = $this->cutChaine($password, ':"', '";'); 
        
        $address = $_POST["address"]; 
        $address = serialize($address);
        $address = $this->cutChaine($address, ':"', '";');

        $city = $_POST["city"]; 
        $city = serialize($city);
        $city = $this->cutChaine($city, ':"', '";');

        $birthdate = $_POST["birthdate"]; 
        $birthdate = serialize($birthdate);
        $birthdate = $this->cutChaine($birthdate, ':"', '";');

        $zipCode = $_POST["zipCode"]; 
        $zipCode = serialize($zipCode);
        $zipCode = $this->cutChaine($zipCode, ':"', '";');

        $country = $_POST["country"]; 
        $country = serialize($country);
        $country = $this->cutChaine($country, ':"', '";');

        $picture = $_POST["picture"]; 
        $picture = serialize($picture);
        $picture = $this->cutChaine($picture, ':"', '";');

        $user = Array();

        $user = new User();
        $user->setEmail($email);        
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($password);
        $user->setLastname($lastname);
        $user->setPhone($phone);
        $user->setAddress($address);
        $user->setCity($city);
        $user->setBirthdate($birthdate);
        $user->setZipCode($zipCode);
        $user->setEmailvalidated(0);
        $user->setFirstname($firstname);
        $user->setCountry($country);
        $user->setPicture($picture);
        $user->setIsBlocked(0);

        $manager->persist($user);
        $manager->flush();
        }

}
