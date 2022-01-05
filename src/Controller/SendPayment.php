<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SendPayment extends AbstractController
{

    public function PayoutAction(Request $request)
    {
        \Stripe\Stripe::setApiKey("STRIPE_SECRET_KEY_TEST");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 1000, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            //$this->addFlash("success","Bravo ça marche !");
            return new RedirectResponse('/api');

        } catch(\Stripe\Error\Card $e) {

            //$this->addFlash("error","Snif ça marche pas :(");
           // return $this->redirectToRoute("order_prepare");
           return new RedirectResponse('/api/reservations');
            // The card has been declined
        }
    }
}