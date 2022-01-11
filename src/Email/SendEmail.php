<?php

namespace App\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;    
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Validator\Constraints as Assert;


class SendEmail extends AbstractController {

    // Pour le formulaire de contact

    /** 
     * @Assert\Type("string") 
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    public $forname;

    /** 
     * @Assert\Type("string") 
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters"
     * )
     */
    public $lastname;

    /** 
     * @Assert\Type("integer") 
     * @Assert\Length(
     *      max = 15,
     *      maxMessage = "Your phone cannot be longer than {{ limit }} characters"
     * )
     */ 
    public $phone;

    /** 
     * @Assert\Email( * message = "l'adresse mail '{{ value }}' n'est pas une adresse mail valide ." * ) 
     * @Assert\Regex (?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])
     * @Assert\Length(
     *      min = 6,
     *      max = 80,
     *      minMessage = "Your email must be at least {{ limit }} characters long",
     *      maxMessage = "Your email cannot be longer than {{ limit }} characters"
     * )
     */
    public $email;

    /** 
     * @Assert\Type("string") 
     * @Assert\Length(
     *      max = 60,
     *      maxMessage = "Your objet cannot be longer than {{ limit }} characters"
     * )
     */    
    public $objet;

    /** 
     * @Assert\Type("string") 
     * @Assert\Length(
     *      min = 6,
     *      max = 800,
     *      minMessage = "Your message must be at least {{ limit }} characters long",
     *      maxMessage = "Your message name cannot be longer than {{ limit }} characters"
     * )
     */
    public $message;

    public function sendEmailFormContact(MailerInterface $mailer, Request $request): Response{

        $data = json_decode( $request->getContent(), true );

        // Données du formulaire de contact

        // On vérifie si les champs sont vides
        if(!empty($data["forname"]) & !empty($data["lastname"]) & !empty($data["email"]) & !empty($data["message"])){
            //dd(strlen($data["forname"]));
            // On vérifie que les champs réspectent les asserts !
            if(strlen($data["forname"])<60 & strlen($data["forname"])>2 & strlen($data["lastname"])<60 & strlen($data["lastname"])>2 & 
            strlen($data["email"])<80 & strlen($data["email"])>6 & strlen($data["message"])<800 & strlen($data["message"])>6 &
            strlen($data["phone"])<15 & strlen($data["objet"])<60){

                $forname = $data["forname"];   
                $lastname = $data["lastname"];
                $phone = $data["phone"]; 
                $email = $data["email"];
                $objet = $data["objet"];   
                $message = $data["message"]; 

                $email = (new Email())
                    ->from('atypikhouse.communication@gmail.com')
                    ->to('atypikhouse.communication@gmail.com')
                    ->subject($objet)
                    ->text($forname.' '.$lastname."\n"."\n".'Message: '.$message."\n"."\n".'Contact: '.$email.' '.$phone);

                $mailer->send($email);  
                return new JsonResponse( [ 'status' => '200', 'title' => 'Send'  ], JsonResponse::HTTP_CREATED ); 

            }else{
                return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => 'some informations to short or to long' ], JsonResponse::HTTP_CREATED ); 
            }
        }else{
            return new JsonResponse( [ 'status' => '400', 'title' => 'Bad Request', 'message' => 'some informations not specified' ], JsonResponse::HTTP_CREATED ); 
        }    
        
    }

}