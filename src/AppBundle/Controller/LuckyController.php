<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/8/17
 * Time: 10:03 AM
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class LuckyController extends Controller
{
    /**
     * Route("/lucky/number/{$max}")
     *
     */
    public function numberAction($max)
    {
        $this->container;

        return $this->render('lucky/number.html.twig', array(
            'number' => mt_rand(0, $max)
        ));
    }
}
