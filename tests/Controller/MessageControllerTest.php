<?php

namespace App\Tests\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    public function testListMessages(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/messages');

        $messageRepository = static::getContainer()->get(MessageRepository::class);
        $serializer = static::getContainer()->get('serializer');
        $testList = $messageRepository->findAll();
        $data = $serializer->serialize($testList, 'json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($data, $client->getResponse()->getContent());
    }

    public function testGetMessage(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/message', content: 'Test Message');

        $messageRepository = static::getContainer()->get(MessageRepository::class);
        $serializer = static::getContainer()->get('serializer');
        $testMessage = $messageRepository->find(json_decode($client->getResponse()->getContent()));
        $data = $serializer->serialize($testMessage, 'json');

        $client->request('GET', '/api/message/' . json_decode($client->getResponse()->getContent()));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($data, $client->getResponse()->getContent());
    }

    public function testCreateMessage(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/message', content: 'Test Message');

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
