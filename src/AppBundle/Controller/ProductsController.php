<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/8/17
 * Time: 12:53 PM
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {
        $product_repo = $this->container
            ->get('product_repository');

        return $this->render('products/index.html.twig', array(
            'products' => $product_repo->findAll()
        ));
    }

    public function newAction()
    {
        return $this->render('products/new.html.twig', array(
            []
        ));
    }


}