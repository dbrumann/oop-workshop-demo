<?php

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\ProductController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testCreateProductIsAccessible(): void
    {
        $client = static::createClient();

        $client->request('GET', '/admin/products/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create a new product');
    }

    public function testCreateProductSubmitCreatesProductAndRedirectsToList(): void
    {
        $client = static::createClient();

        $client->request('GET', '/admin/products/new');
        $client->followRedirects();

        $crawler = $client->submitForm('submit', [
            'product[name]' => 'My Test Product',
            'product[description]' => 'This describes my test product.',
            'product[amount]' => 19.99,
            'product[currency]' => 'EUR',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Products');
        self::assertGreaterThan(1, $crawler->filter('h3')->count());
    }

    public function testCreateProductFailsWithInvalidAmount(): void
    {
        $client = static::createClient();

        $client->request('GET', '/admin/products/new');

        $client->submitForm('submit', [
            'product[name]' => 'My Test Product',
            'product[description]' => 'This describes my test product.',
            'product[amount]' => -19.99,
            'product[currency]' => 'EUR',
        ]);

        $this->assertSelectorTextContains('li', 'This value should be either positive or zero.');
    }

    public function testCreateProductFailsWithTooShortName(): void
    {
        $client = static::createClient();

        $client->request('GET', '/admin/products/new');

        $client->submitForm('submit', [
            'product[name]' => 'A',
            'product[description]' => 'This describes my test product.',
            'product[amount]' => 19.99,
            'product[currency]' => 'EUR',
        ]);

        $this->assertSelectorTextContains('li', 'This value is too short.');
    }
}
