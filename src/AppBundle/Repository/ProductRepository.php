<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/8/17
 * Time: 1:58 PM
 */

namespace AppBundle\Repository;
use AppBundle\Model\Product;
use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Serializer\Serializer;


/**
 * @class ProductRepository
 */
class ProductRepository
{
    private $guzzle_client;
    private $logger;
    private $serializer;

    public function __construct(Client $guzzle_client, Logger $logger, Serializer $serializer) {
        //$this->pdo = $pdo;
        /*$this->guzzle_client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://107.23.36.113',
            // You can set any number of default request options.
            'timeout'  => 3.0,
        ]);*/

        $logger->pushHandler(new StreamHandler('/Users/mbyrnes/Desktop/symfony_training.txt', Logger::INFO));
        $this->logger = $logger;

        $this->serializer = $serializer;

        $this->guzzle_client = $guzzle_client;
    }

/**
  * @return Product[]
 * http://107.23.36.113/products.json
  */
    public function findAll(){
        $result = $this->guzzle_client->request('GET', '/products.json');

        $products = [];
        $json_response = json_decode($result->getBody());

        foreach ($json_response as $json_object) {
            $product = new Product();
            $product->setId($json_object->id);
            $product->setName($json_object->name);
            $product->setDescription($json_object->description);
            $product->setCreatedAt($json_object->created_at);
            $product->setPrice($json_object->price);
            $products[] = $product;
        }
        /*$result = $this->pdo->query('SELECT * FROM product');

        $products = [];
        foreach ($result as $productData){
            $product = new Product();
            $product->setId($productData['id']);
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setCreatedAt($productData['created_at']);
            $product->setPrice($productData['price']);
            $products[] = $product;
        }*/

        $this->logger->info('Found '.count($products).' many items');
        return $products;
    }

    /**
     * @param int $id
     * @return Product
     * GET /products/{ID}.json
     */
    public function find($id)
    {
        $result = $this->guzzle_client->request('GET', '/products/'.$id.'.json');

        $json_response = json_decode($result->getBody());
        $product = new Product();

        $product->setId($json_response->id);
        $product->setName($json_response->name);
        $product->setDescription($json_response->description);
        $product->setCreatedAt($json_response->created_at);
        $product->setPrice($json_response->price);
        $this->logger->info('Found item id:'.$id);
        return $product;
    }

    /**
     * @param Product $product
     * POST /products.json with JSON body containing: name, description, price
     */
    public function create(Product $product)
    {
        /*$stmt = $this->pdo->prepare('
    INSERT INTO product (name, description, price, created_at)
    VALUES (:name, :description, :price, :createdAt)
');
        $stmt->bindValue(':name', $product->getName());
        $stmt->bindValue(':description', $product->getDescription());
        $stmt->bindValue(':price', $product->getPrice());
        $stmt->bindValue(':createdAt', date('Y-m-d H:i:s'));

        $stmt->execute();*/

        //$json_payload = json_encode($product);
        //$json_payload = json_encode(['name' => $product->getName(), 'description' => $product->getDescription(), 'price' => $product->getPrice()]);

        //$json_payload = Serializer
        $json_payload = $this->serializer->serialize($product, 'json');
//        dump($json_payload);die;

        //dump($product);
        //dump($json_payload);die;
        $result = $this->guzzle_client->request('POST', '/products.json', ['body' => $json_payload]);
        $this->logger->info('Created new item');

    }
    /**
     * @param Product $product
     * PUT /products/{ID}.json with JSON body containing: name, description, price
     */
    public function update(Product $product)
    {
        $json_payload = json_encode(['name' => $product->getName(), 'description' => $product->getDescription(), 'price' => $product->getPrice()]);
        $this->guzzle_client->request('PUT', '/products/'.$product->getId().'.json', ['body' => $json_payload]);
        $this->logger->info('Updated item id:'.$product->getId());
    }
    /**
     * http://107.23.36.113/_db/rebuild.json
     */
    public function reset_db()
    {
        $this->guzzle_client->request('GET', '/_db/rebuild.json');
        $this->logger->info('Reset the database');
    }
}