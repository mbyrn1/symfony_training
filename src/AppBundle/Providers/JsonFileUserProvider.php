<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 1:33 PM
 */

namespace AppBundle\Providers;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Model\User;

class JsonFileUserProvider implements UserProviderInterface
{
    private $json_file_path;

    public function __construct($json_file_path)
    {
        $this->json_file_path = $json_file_path;
    }

    public function loadUserByUsername($username)
    {
        $string = file_get_contents($this->json_file_path);
        $json_a = json_decode($string, true);

        foreach ($json_a as $user)
        {
            if($user["username"] == $username)
            {
                return new User($user["username"], $user["firstName"], $user["roles"]);
            }
        }

        //if not
        throw new UsernameNotFoundException();
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }
    public function supportsClass($class)
    {
        return true;
    }

}