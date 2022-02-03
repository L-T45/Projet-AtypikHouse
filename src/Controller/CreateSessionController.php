<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Properties;
use App\Entity\Reservations;
use App\Repository\PropertiesRepository;
use App\Repository\ReservationsRepository;
use Symfony\Component\Routing\Annotation\Route;


class CreateSessionController extends AbstractController
{


  public function __construct(ReservationsRepository $reservationsRepo, PropertiesRepository $propertiesRepo)
  {
    $this->reservationsRepo = $reservationsRepo;
    $this->propertiesRepo = $propertiesRepo;
  }


  private function createDateRangeArray($strDateFrom, $strDateTo)
  {
    //YYYY-MM-DD
    $aryRange = [];
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
      array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
      while ($iDateFrom < $iDateTo) {
        $iDateFrom += 86400; // add 24 hours
        array_push($aryRange, date('Y-m-d', $iDateFrom));
      }
    }
    return $aryRange;
  }


  private function checkIfDatesAvaible($property_id, $reservationArray)
  {
    $findReservation = $this->reservationsRepo->findReservation($property_id);
    $isCorresponding = false;

    foreach ($findReservation as $reservation) {
      $start = date_format($reservation["start_date"], "Y-m-d");
      $end =  date_format($reservation["end_date"], "Y-m-d");
      $arrReservation = $this->createDateRangeArray($start, $end);
      //  dd($arrReservation);
      $isCorresponding = array_intersect($reservationArray, $arrReservation) ? true : false;
    }
    return !$isCorresponding;
  }



  /**
   * @Route("/api/send_payment", methods={"POST"})
   */
  public function  createSession(Request $request)
  {
    //header('Content-Type: application/json');
    $post = json_decode($request->getContent());
    /// DATA
    $property = $post->property;
    $reservation = $post->reservation;
    $user = $post->customer_email;
    $domain = $post->domain;

    /// AMOUNT
    $nights = $reservation->quantity;
    $finded = $this->propertiesRepo->findById($property->id);
    $totalPerNight = $nights * $finded;
    // commission de 10%
    $total = $totalPerNight + $totalPerNight / 10;

    //// CHECK IF RESERVATION IS AVAIBLE

    $reservationArray = $this->createDateRangeArray($reservation->startDate, $reservation->endDate);
    $isAvailable = $this->checkIfDatesAvaible($property->id, $reservationArray);

    if ($isAvailable === false) {
      return new JsonResponse(['status' => '402', 'title' => 'Votre réservation n\'a pas été créé']);
    }


    ///////////////////////////////////////////////////////////////////////
    ///// STRIPE

    \Stripe\Stripe::setApiKey('sk_test_51JgqhcIa3urCExBYCvJ7QnV4zHH5IFi2rmZE1DKeWbmN5bViKXKY5nSHsHby8p1mSqolDvClEBFp4wD2lraRMdC200ofYf0tqL');

    header('Content-Type: application/json');

    //// DATE FORMAT
    $date_start = date_format(date_create($reservation->startDate), 'd/m/Y');
    $date_end = date_format(date_create($reservation->endDate), 'd/m/Y');
    /// URL
    $success = $domain . '/reservation/recapitulatif';
    $cancel = $domain . '/property' . '/' . $property->id;

    $checkout_session = \Stripe\Checkout\Session::create([
      'customer_email' => $user,
      'metadata' => ["start_date" => $reservation->startDate, "end_date" => $reservation->endDate, "participants" => $reservation->participants, "total" => $total, 'pic' => $property->picture, "name" => $property->name, "user" => $reservation->user, "property" => $property->id],
      'line_items' => [
        [
          "price_data" => [
            'unit_amount' => $total * 100,
            'currency' => 'EUR',
            'product_data' => [
              'name' => $property->name,
              'description' => "Du " . $date_start . ' au ' . $date_end,
              //  'metadata' => ["start_date" => $reservation->startDate, "end_date" => $reservation->endDate],
              'images' => ["https://2las-atypik-house.fr/media/properties/" . $property->picture],

            ]
          ],
          'quantity' => 1,
        ]
      ],
      'mode' => 'payment',
      'success_url' => $success . '?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => $cancel,
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    return new JsonResponse($checkout_session);
  }
}
