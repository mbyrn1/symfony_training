<?php

namespace AppBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @Assert\NotBlank()
     */
    private $username;
    /**
     * @Assert\NotBlank()
     */
    private $firstname;
    /**
     * @Assert\NotBlank()
     */
    private $roles;

    public function __construct($username, $firstname = null, $roles = null)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }
    public function getPassword()
    {
        // TODO: Implement getPassword() method. Not needed for now
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method. Not needed for now
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method. Not needed for now
    }

}