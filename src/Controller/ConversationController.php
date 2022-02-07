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
use App\Repository\MessagesRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


class ConversationController
{

    private $security;

    public function __construct(EntityManagerInterface $manager, ConversationsRepository  $conversationRepo, JWTEncoderInterface $jwt, Security $security, MessagesRepository $messagesRepository)
    {

        $this->jwt = $jwt;
        $this->manager = $manager;
        $this->conversationRepo = $conversationRepo;
        $this->messagesRepository = $messagesRepository;
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



    public function findConversationByUser(Request $request, ConversationsRepository $conversationsRepository, EntityManagerInterface $em)
    {



        $user = $request->attributes->get('data');
        //dd($user);
        $userId = $user->getId();

        $sql = 'SELECT `conversations_id`as id FROM `user_conversations` WHERE user_id= 26';

        $stmt = $this->manager->getConnection()->prepare($sql);
        $result = $stmt->executeQuery()->fetchAllAssociative();
        // dd($result);
        //dd(array_merge(...array_values($result)));
        //dd($this->array_flatten($result));

        $conversations = $conversationsRepository->findConvsByUser($this->array_flatten($result));
        //dd($conversations);
        return new JsonResponse($conversations);
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


    /**
     * 
     * @Route("/api/create_message", methods={"POST"})
     */
    public function createMessage(Request $request)
    {

        $post = json_decode($request->getContent());
        $user = $this->security->getUser();
        $userId = $user->getUserIdentifier();
        $userRef = $this->manager->getReference("App\Entity\User", $userId);
        $convRef = $this->manager->getReference("App\Entity\Conversations", $post->convId);

        $newMessage = new Messages();
        $newMessage->setBody($post->body);
        $newMessage->setConversations($convRef);
        $newMessage->setUser($userRef);
        $this->manager->persist($newMessage);
        $this->manager->flush();
        $newMessageId = $newMessage->getId();

        dd($user);

        return new JsonResponse(['status' => '201', 'convId' => $newMessageId]);
    }


    public function findMessages(Request $request)
    {
        $conversation = $request->attributes->get('data');
        $conversationId = $conversation->getId();
        $messages = $this->messagesRepository->findConversationsByid($conversationId);


        //dd($messages);

        return new JsonResponse($messages);
    }
}
