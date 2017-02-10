<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/8/17
 * Time: 12:53 PM
 */

namespace AppBundle\Controller;
use AppBundle\Form\ProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ProductsController extends Controller
{
    // /products
    public function indexAction()
    {
        $product_repo = $this->container
            ->get('product_repository');

        return $this->render('products/index.html.twig', array(
            'products' => $product_repo->findAll()
        ));
    }

    // /products/new
    public function newAction(Request $request)
    {
        $form = $this->createForm(
            ProductFormType::class
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product_repo = $this->container
                ->get('product_repository');
            $product = $form->getData();

            $product_repo->create($product);

            $this->addFlash('success', 'Product saved');

            return $this->redirectToRoute('products');

        }

        return $this->render('products/new.html.twig', array(
            'productForm' => $form->createView()
        ));
    }

    //reset_db
    public function resetAction()
    {
        $product_repo = $this->container
            ->get('product_repository');
        $product_repo->reset_db();
        return $this->redirectToRoute('products');
    }

    // /products/update/id
    public function updateAction(Request $request, $id)
    {
        $product_repo = $this->container
            ->get('product_repository');

        $product = $product_repo->find($id);

        $form = $this->createForm(
            ProductFormType::class,
            $product
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product_repo = $this->container
                ->get('product_repository');
            $product = $form->getData();

            $product_repo->update($product);

            $this->addFlash('success', 'Product saved');

            return $this->redirectToRoute('products');

        }

        return $this->render('products/edit.html.twig', array(
            'productForm' => $form->createView()
        ));
    }
}
