<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
///
use App\Entity\Properties;
use App\Entity\Reservations;
use App\Entity\Payments;
//
use App\Repository\PropertiesRepository;
use App\Repository\ReservationsRepository;
use App\Repository\PaymentsRepository;


class RetrieveSessionController extends AbstractController
{


    public function __construct(EntityManagerInterface $manager, ReservationsRepository $reservationsRepo, PaymentsRepository $paymentRepo)
    {
        $this->manager = $manager;
        $this->reservationsRepo = $reservationsRepo;
        $this->paymentRepo = $paymentRepo;
    }


    public function createReservation($start_date, $end_date, $user, $property, $participants, $amount, $stripe_session)
    {

        $newReservation = new Reservations();
        $newPayment = new Payments();

        $session_exist = $this->paymentRepo->findByStripeSession($stripe_session);


        if (is_array($session_exist) && count($session_exist) === 0) {

            $propertyRef = $this->manager->getReference("App\Entity\Properties", $property);
            $userRef = $this->manager->getReference("App\Entity\User", $user);

            $newPayment->setUser($userRef);
            $newPayment->setAmount($amount);
            $newPayment->setIsPaidback(true);
            $newPayment->setPaidbackState("Payé");
            $newPayment->setStripeSession($stripe_session);

            $this->manager->persist($newPayment);
            $this->manager->flush();
            $paymentId = $newPayment->getId();
            $paymentRef = $this->manager->getReference("App\Entity\Payments", $paymentId);

            $newReservation->setStartdate(new \DateTime($start_date));
            $newReservation->setEndDate(new \DateTime($end_date));
            $newReservation->setParticipantsNbr($participants);
            $newReservation->setProperties($propertyRef);
            $newReservation->setUser($userRef);
            $newReservation->setPayments($paymentRef);

            $this->manager->persist($newReservation);
            $this->manager->flush();
            //
            $reservationId = $newReservation->getId();

            return $newReservation->getId();
        } else {
            return false;
        }
    }


    /**
     * @Route("/api/check_payment_session", methods={"POST"})
     */
    public function retrieveSession(Request $request)
    {
        $post = json_decode($request->getContent());
        $session_id = $post->session_id;
        // dd($session_id);
        /// retrieve session
        \Stripe\Stripe::setApiKey('sk_test_51JgqhcIa3urCExBYCvJ7QnV4zHH5IFi2rmZE1DKeWbmN5bViKXKY5nSHsHby8p1mSqolDvClEBFp4wD2lraRMdC200ofYf0tqL');
        $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
        $metadata = $checkout_session->metadata;
        $amount = $checkout_session->amount_total;
        //// retrieve lines
        $stripe = new \Stripe\StripeClient("sk_test_51JgqhcIa3urCExBYCvJ7QnV4zHH5IFi2rmZE1DKeWbmN5bViKXKY5nSHsHby8p1mSqolDvClEBFp4wD2lraRMdC200ofYf0tqL");
        $line_items = $stripe->checkout->sessions->allLineItems($checkout_session->id);

        //// if paid
        if ($checkout_session->payment_status === "paid") {


            $id_created =  $this->createReservation($metadata->start_date, $metadata->end_date, $metadata->user, $metadata->property, $metadata->participants, $amount, $session_id);
            if ($id_created != false) {
                return new JsonResponse(["session" => $checkout_session->metadata, "lines" => $line_items, "id" => $id_created, "checkout" => $checkout_session]);
            }
        } else {
            return new JsonResponse(["status" => 402, "message" => "Réservation déja effectuée"]);
        }
        return new JsonResponse(["status" => 402, "message" => "Réservation non fonctionnelle"]);
    }
}
