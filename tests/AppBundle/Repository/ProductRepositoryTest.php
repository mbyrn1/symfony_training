<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Model\Product;
use AppBundle\Repository\ProductRepository;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\app\AppKernel;
use Symfony\Component\Serializer\Serializer;

class DefaultControllerTest extends TestCase
{
    public function testFindAll()
    {
        $json = json_encode([['id' => 1, 'name' => 'Product1', 'price' => '123', 'description' => 'stuff', 'created_at' => date('Y-m-d H:i:s')],
                            ['id' => 2, 'name' => 'Product1', 'price' => '123', 'description' => 'stuff', 'created_at' => date('Y-m-d H:i:s')]]);
        $apiClient = $this->prophesize(Client::class);
        $apiClient->request('GET','/products.json')
            ->willReturn(new Response(200, [], $json));
        $loggerClient = $this->prophesize(Logger::class);
        $serializer = $this->prophesize(Serializer::class);


        $productRepository = new ProductRepository($apiClient->reveal(), $loggerClient->reveal(), $serializer->reveal());
        $products = $productRepository->findAll();

        $this->assertCount(2, $products);
        $this->assertEquals('Product1',
            $products[0]->getName());

    }

    public function testFind()
    {
        $json = json_encode(['id' => 1, 'name' => 'Product1', 'price' => '123', 'description' => 'stuff', 'created_at' => date('Y-m-d H:i:s')]);
        $apiClient = $this->prophesize(Client::class);
        $apiClient->request('GET','/products/1.json')
            ->willReturn(new Response(200, [], $json));
        $loggerClient = $this->prophesize(Logger::class);
        $serializer = $this->prophesize(Serializer::class);

        $productRepository = new ProductRepository($apiClient->reveal(), $loggerClient->reveal(), $serializer->reveal());
        $product = $productRepository->find(1);

        $this->assertTrue(count($product) == 1);
    }

    public function testCreate()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        $serializer = $container->get('serializer');
        $loggerClient = $this->prophesize(Logger::class);

        $product = new Product();
        $product->setname('Product1');
        $product->setPrice('123');
        $product->setDescription('t');
        $expected_json = $serializer->serialize($product, 'json');
        $apiClient = $this->prophesize(Client::class);
        $apiClient->request('POST','/products.json', ['body' => $expected_json])
            ->willReturn(new Response(200, []));

        $productRepository = new ProductRepository($apiClient->reveal(), $loggerClient->reveal(), $serializer);
        $productRepository->create($product);
    }
}
