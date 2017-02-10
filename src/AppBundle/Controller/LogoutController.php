<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 2:04 PM
 */

namespace AppBundle\Controller;


class LogoutController
{
    public function indexAction(Request $request)
    {
        return $this->render('default/login.html.twig');
    }
}