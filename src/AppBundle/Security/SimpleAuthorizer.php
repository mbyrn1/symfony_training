<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 12:49 PM
 */

namespace AppBundle\Security;


interface SimpleAuthorizer
{
    function preMethodCheck();
}