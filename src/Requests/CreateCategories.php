<?php

namespace App\Requests;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CategoriesRepository;
use App\Email\SendEmailModifyListCategories;
use App\Repository\UserRepository;
use App\Entity\Attributes;
use Symfony\Component\Mailer\MailerInterface;

class CreateCategories extends AbstractController
{

    // Pour le formulaire de création de catégories
    private $title;
    private $slug;
    private $picture;
    private $description;

    public function cutChaine($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function newCategories(EntityManagerInterface $manager, Request $request, CategoriesRepository $CategoriesRepository, SendEmailModifyListCategories $SendEmail, MailerInterface $mailer, UserRepository $UserRepository): Response
    {
        $SendEmail->PostNewCategories($mailer, $request);
        $categories = array();
        $categories = new Categories();

        // Données du formulaire de catégories  
        $title = $_POST["title"];
        $title = serialize($title);
        $title = $this->cutChaine($title, ':"', '";');

        $slug = $_POST["slug"];
        $slug = serialize($slug);
        $slug = $this->cutChaine($slug, ':"', '";');

        // $picture = $_POST["picture"]; 
        // $picture = serialize($picture);
        // $picture = $this->cutChaine($picture, ':"', '";');

        $file = $request->files->get('file');
        //dd($file);

        $attributes = [];
        if(isset($_POST["dynamic"]) && !empty($_POST["dynamic"])){
            $attributes = $_POST["dynamic"];
        }

        $description = $_POST["description"];
        $description = serialize($description);
        $description = $this->cutChaine($description, ':"', '";');

        $this->CategoriesRepository = $CategoriesRepository;
        $findCategories = $this->CategoriesRepository->findByCategories($title);
        $findCategoriesCheck = $findCategories;

        if ($findCategoriesCheck === []) {
            $categories->setPicture($file);
            $categories->setFile($file);
            $categories->setTitle($title);
            $categories->setSlug($slug);
            $categories->setDescription($description);
            $manager->persist($categories);
            $manager->flush();
            $categoriesId = $categories->getId();

            if(count($attributes) != 0){
                foreach ($attributes as $attribute) {

                    $newAttribute = new Attributes();
                    $categoryRef = $manager->getReference("App\Entity\Categories", $categoriesId);
                    $newAttribute->setTitle($attribute['title']);
                    $newAttribute->setCategories($categoryRef);
                    $newAttribute->setRequired($attribute['required']);
                    $newAttribute->setResponseType($attribute['response_type']);
                    $manager->persist($newAttribute);
                    $manager->flush();
                }
            }
            $SendEmail->PostNewCategories($mailer, $request);

            return new JsonResponse(['status' => '200', 'title' => 'Votre categorie a bien été créé'], JsonResponse::HTTP_CREATED);
        } else {
            return new JsonResponse(['status' => '400', 'title' => 'Bad Request', 'message' => 'Création de votre catégorie impossible car une catégorie est déjà créé avec ce nom !'], JsonResponse::HTTP_CREATED);
        }
    }
}
