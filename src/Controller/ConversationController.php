<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Conversations;
use App\Entity\User;
use App\Entity\Messages;
use App\Repository\ConversationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


class ConversationController
{

    private $security;

    public function __construct(EntityManagerInterface $manager, ConversationsRepository  $conversationRepo, JWTEncoderInterface $jwt, Security $security)
    {

        $this->jwt = $jwt;
        $this->manager = $manager;
        $this->conversationRepo = $conversationRepo;
        $this->security = $security;
    }


    function array_flatten($array)
    {

        $result = [];
        foreach ($array as $key => $value) {
            array_push($result, $value["id"]);
        }
        return array_values($result);
    }

    /**
     * @Route("/api/create_conversation", methods={"POST"})
     */
    public function createConversation(Request $request)
    {

        $post = json_decode($request->getContent());

        $userId = $post->userId;
        $otherId = $post->otherId;

        $myConversations = $this->array_flatten($this->conversationRepo->findConvIdByUser($userId));
        $myConversations2 = $this->array_flatten($this->conversationRepo->findConvIdByUser($otherId));

        $diff = array_intersect($myConversations, $myConversations2);

        if (count($diff) === 0) {


            $userRef = $this->manager->getReference("App\Entity\User", $userId);
            $otherRef = $this->manager->getReference("App\Entity\User", $otherId);

            $newConversation = new Conversations();
            $newConversation->addUser($userRef);
            $newConversation->addUser($otherRef);
            $this->manager->persist($newConversation);
            $this->manager->flush();

            $newConversationId = $newConversation->getId();

            return new JsonResponse(['status' => '201', 'convId' => $newConversationId]);
        } else {
            return new JsonResponse(['status' => '201', 'convId' => $diff[0]]);
        }
    }


    // /**
    //  * 
    //  * @Route("/api/create_message", methods={"POST"})
    //  */
    // public function createMessage(Request $request)
    // {

    //     $post = json_decode($request->getContent());
    //     $user = $this->security->getUser();
    //     $userId = $user->getUserIdentifier();
    //     $userRef = $this->manager->getReference("App\Entity\User", $userId);
    //     $convRef = $this->manager->getReference("App\Entity\Conversations", $post->convId);

    //     $newMessage = new Messages();
    //     $newMessage->setBody($post->body);
    //     $newMessage->setConversations($convRef);
    //     $newMessage->setUser($userRef);
    //     $this->manager->persist($newMessage);
    //     $this->manager->flush();
    //     $newMessageId = $newMessage->getId();

    //     dd($user);

    //     return new JsonResponse(['status' => '201', 'convId' => $newMessageId]);
    // }
}
