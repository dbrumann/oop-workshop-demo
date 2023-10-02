<?php

namespace App\Tests\Controller\Api\Product;

use App\Controller\Api\Product\CreateProductController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateProductControllerTest extends WebTestCase
{
    public function testCreateProductFromJson(): void
    {
        $client = static::createClient();

        $payload = [
            'name' => 'My API Product',
            'description' => 'Example for a product created through the API.',
            'amount' => 2335,
            'currency' => 'EUR',
        ];

        $client->request(
            method: 'POST',
            uri: '/api/products',
            content: json_encode($payload)
        );
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        self::assertJson($response->getContent());
    }

    public function testCreateProductFailsWithInvalidAmount(): void
    {
        $client = static::createClient();

        $payload = [
            'name' => 'My API Product',
            'description' => 'Example for a product created through the API.',
            'amount' => -2335,
            'currency' => 'EUR',
        ];

        $client->request(
            method: 'POST',
            uri: '/api/products',
            content: json_encode($payload)
        );
        $response = $client->getResponse();

        self::assertSame(400, $response->getStatusCode());
        self::assertJson($response->getContent());
        $data = json_decode(json: $response->getContent(), associative: true);
        self::assertArrayHasKey('title', $data);
        self::assertSame('Validation Failed', $data['title']);
    }
}
