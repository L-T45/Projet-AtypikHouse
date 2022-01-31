<?php

namespace App\Requests;

use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;  
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\File;

class Register extends AbstractController{
    
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
    private $encoder;
    private $UserRepository;

    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    //    
    // public function __invoke(Request $request)
    // {
    //   
    //    $user = $request->attributes->get('data');
    //    //dd($user);
    //    if(!($user instanceof User)) {
    //        throw new \RuntimeException('User attendu');
    //    }   
    //    
       
    //   // $_FILES;
    //    //dd($_FILES);
    //   // $user = $request->files->get('files');
    //   // dd($_FILES);
    //     //$user->setFile($request->files->get('file'));
    //     //dd($user);
    //   // $user->setUpdatedAt(new \DateTime());
    //    return $user;
    //    //dd($user);

    // }
    
    

    public function __invoke(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $encoder, UserRepository $UserRepository): Response
    {
        $user = Array();
        $user = new User();
        

        $_FILES;

        // Données du formulaire de register  
        $firstname = $_POST["firstname"];
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

        //encodage password
        $password = $encoder->encodePassword($user, $password);

        $address = $_POST["address"]; 
        $address = serialize($address);
        $address = $this->cutChaine($address, ':"', '";');

        $city = $_POST["city"]; 
        $city = serialize($city);
        $city = $this->cutChaine($city, ':"', '";');

        $birthdate = $_POST["birthdate"]; 
        $birthdate = serialize($birthdate);
        $birthdate = $this->cutChaine($birthdate, ':"', '";');
        $birthdate = new \DateTime($birthdate);

        $zipCode = $_POST["zipCode"]; 
        $zipCode = serialize($zipCode);
        $zipCode = $this->cutChaine($zipCode, ':"', '";');

        $country = $_POST["country"]; 
        $country = serialize($country);
        $country = $this->cutChaine($country, ':"', '";');

        //$pictures = $_POST["pictures"]; 
        $file = $request->files->get('file');
        //dd($file);
      //dd($request->files->get('file'));
        //dd($_FILES);
    //    $picture = serialize($picture);
    //     $picture = $this->cutChaine($picture, ':"', '";');

    //     $file = $_POST["file"]; 
    //     $file = $request->files->get('file');
    //     dd($file);
        //$picture = serialize($picture);
        //$picture = $this->cutChaine($picture, ':"', '";');
   
       $picture = uniqid().'_'.$_FILES['file']['name'][0];
       //dd($picture);
    
       //dd($picture);

       
        

        $this->UserRepository = $UserRepository;
        $findUser = $this->UserRepository->findByEmailCheckIfExist($email);
        $findUserCheck = $findUser;
        
        if($findUserCheck === [])
        { 
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
            $user->setFile($file[0]);
            $user->setIsBlocked(0);
        
            $manager->persist($user);
            $manager->flush();
            return new JsonResponse( ['status' => '200', 'title' => 'Votre compte a bien été créé'], JsonResponse::HTTP_CREATED ); 
        }else{
            return new JsonResponse( ['status' => '400', 'title' => 'Bad Request', 'message' => 'Un utilisateur est déjà créé avec cette adresse mail !'], JsonResponse::HTTP_CREATED );
        }
    }
}
