<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 2:40 PM
 */

namespace AppBundle\Voter;


use AppBundle\Model\Product;
use AppBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RandomVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Product
            && $attribute == 'VIEW';
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var $subject Product */
        $user = $token->getUser();
        if(!$user instanceof User)
        {
            return false;
        }

        switch($attribute) {
            case 'VIEW':
                return false;
            default:
                throw new \Exception('What is '.$attribute);

        }
    }

}