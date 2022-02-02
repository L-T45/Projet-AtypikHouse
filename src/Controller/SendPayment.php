<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SendPayment extends AbstractController
{

    public function __invoke(Request $request)
    {
       \Stripe\Stripe::setApiKey('sk_test_51JgqhcIa3urCExBYCvJ7QnV4zHH5IFi2rmZE1DKeWbmN5bViKXKY5nSHsHby8p1mSqolDvClEBFp4wD2lraRMdC200ofYf0tqL');

        //header('Content-Type: application/json');
        $post= json_decode($request->getContent());
    
        $property= $post->property;
        $reservation= $post->reservation;
        $user= $post->customer_email;
      
      $YOUR_DOMAIN = 'https://atypikhouse.vercel.app';
      
        $checkout_session = \Stripe\Checkout\Session::create([
          'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price_data'=>["unit_amount"=> 50000],
            'customer_email'=>$user,
            'quantity' => 1,
          ]],
          'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/reservation/recapitulatif',
            'cancel_url' => $YOUR_DOMAIN . '/property/'. $property,
        ]);
        
        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);

        
    }
}