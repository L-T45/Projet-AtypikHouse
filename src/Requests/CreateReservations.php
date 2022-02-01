<?php

namespace App\Requests;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Reservations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\DateInterval;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse; 
use App\Repository\ReservationsRepository; 
use App\Repository\PropertiesRepository;

use App\Entity\User;
use App\Entity\Properties;


class CreateReservations extends AbstractController{
    
    // Pour le formulaire de création de propriété
    private $start_date;
    private $end_date;
    private $participants_nbr;
    private $properties; 
    private $user;
  

    public function cutChaine($string, $start, $end){
        $string = ' ' . $string;   
        $ini = strpos($string, $start);  
        if ($ini == 0) return '';   
        $ini += strlen($start);  
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    // public function __invoke(Request $request)
    // {

    //    $properties = $request->attributes->get('data');
    //    //dd($properties);
    //    if(!($properties instanceof Properties)) {
    //        throw new \RuntimeException('Propriété attendue');
    //    }   
       
       
    //    //dd($_FILES);
    //    //$properties = $request->files->get('file');
    //    $properties->setFile($request->files->get('file'));
    //    dd($properties);
    //    $properties->setUpdatedAt(new \DateTime());
    //    return $properties;
    //    //dd($properties);

    // }

    public function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.
        // could test validity of dates here but I'm already doing
        // that in the main script
        $aryRange = [];
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }


    public function __invoke(EntityManagerInterface $manager, Request $request, ReservationsRepository $reservationsRepository, PropertiesRepository $PropertiesRepository, int $id): Response
    {
       $reservations = Array();
        $reservations = new Reservations();
        $em = $this->getDoctrine()->getManager();


        // Données du formulaire de reservation  
        $start_date = $_POST["start_date"];
        //dd($start_date);
       
        $end_date = $_POST["end_date"];
        $properties_id = $_POST["properties"];
      
        $reservationArray = $this->createDateRangeArray($start_date, $end_date);
        //dd($reservationArray);

        $participants_nbr = $_POST["participants_nbr"];
        //dd($participants_nbr);
        


        $postProperties = $_POST["properties"]; 
        $postProperties = serialize($postProperties);
        $postProperties = $this->cutChaine($postProperties, ':"', '";'); 
        $properties = new Properties();
        $properties = $em->getReference("App\Entity\Properties", $postProperties);
        //dd($properties);

        $postUser = $_POST["user"]; 
        $postUser = serialize($postUser);
        $postUser = $this->cutChaine($postUser, ':"', '";');
        $user = new User();
        $user = $em->getReference("App\Entity\User", $postUser);
        //dd($user);

       // $this->$reservationsRepository = $reservationsRepository;
       $isAvailable = true;
        $findReservation = $reservationsRepository->findReservation($properties_id);
        //$findReservationCheck = $findReservation;
        foreach($findReservation as $reservation){
            $start = date_format($reservation["start_date"], "Y-m-d") ;
            $end =  date_format($reservation["end_date"], "Y-m-d") ;
          $arrReservation = $this->createDateRangeArray($start, $end);
        //  dd($arrReservation);
          if(array_intersect($reservationArray, $arrReservation)){
            $isAvailable=false;
            return new JsonResponse( ['status' => '400', 'title' => 'Bad Request', 'message' => 'Votre réservation est impossible à ces dates !'], JsonResponse::HTTP_CREATED );
          }
        }

        if($isAvailable == true){

            $reservations->setStartdate(new \DateTime($start_date));
            $reservations->setEndDate(new \DateTime($end_date));
            $reservations->setParticipantsNbr($participants_nbr);
            $reservations->setProperties($properties);
            $reservations->setUser($user);

            $manager->persist($reservations);
            $manager->flush();
            return new JsonResponse( ['status' => '200', 'title' => 'Votre réservation a bien été créé'], JsonResponse::HTTP_CREATED );
        } 
        else{
            return new JsonResponse( ['status' => '400', 'title' => 'Bad Request', 'message' => 'Votre réservation n\'a pas pu aboutir !'], JsonResponse::HTTP_CREATED );
        }

        }
        
      
    
}
