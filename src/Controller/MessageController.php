<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{Request, JsonResponse};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'api_')]
class MessageController extends AbstractController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        MessageRepository $messageRepository,
        SerializerInterface $serializer,
    )
    {
        $this->entityManager = $entityManager;
        $this->messageRepository = $messageRepository;
        $this->serializer = $serializer;
    }

    #[Route('/messages', name: 'message_list', methods: ['GET'])]
    public function listMessages(): JsonResponse
    {
        $messages = $this->messageRepository->findAll();
        $data = $this->serializer->normalize($messages, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    #[Route('/message/{uuid}', name: 'message_get', methods: ['GET'])]
    public function getMessage(string $uuid): JsonResponse
    {
        $message = $this->messageRepository->find($uuid);
        $data = $this->serializer->normalize($message, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    #[Route('/message', name: 'message_create', methods: ['POST'])]
    public function createMessage(Request $request): JsonResponse
    {
        $message = new Message();
        $message->setContent($request->getContent());

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return new JsonResponse($message->getId(), JsonResponse::HTTP_CREATED);
    }
}
