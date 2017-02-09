<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/8/17
 * Time: 1:58 PM
 */

namespace AppBundle\Repository;
use AppBundle\Model\Product;

class ProductRepository
{
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

/**
  * @return Product[]
  */
    public function findAll(){
        $result = $this->pdo->query('SELECT * FROM product');
        $products = [];
        foreach ($result as $productData){
            $product = new Product();
            $product->setId($productData['id']);
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setCreatedAt($productData['created_at']);
            $product->setPrice($productData['price']);
            $products[] = $product;
        }
        return $products;
    }
}