<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 11:45 AM
 */

namespace AppBundle\Security;

use AppBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class SimpleLoginAuthenticator extends AbstractGuardAuthenticator
{
    private $router;

    /**
     * SimpleLoginAuthenticator constructor.
     * @param Router $router
     */
    public function __construct (Router $router)
    {
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        if($request->getPathInfo() != '/login' || !$request->isMethod('POST') )
        {
            //do nothing, let request continue
            return;
        }

        return ['username' => $request
            ->request->get('username')
        ];
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return User
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //gets info passed from getcredentials
        //dump(User($credentials));die;
        try
        {
            $user = $userProvider->loadUserByUsername($credentials['username']);
        }
        catch(UsernameNotFoundException $unfe)
        {
            $this->onAuthenticationFailure();
        }
        return $user;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        //normally you would check the users password here
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        //invite the user to login again
        $url = $this->router
            ->generate('login');
        return new RedirectResponse($url);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        //where does the user go assuming success, set default page here,
        //  can change later to store their original http request and redirect them here
        $url = $this->router
                ->generate('products');
        return new RedirectResponse($url);

    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }


    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        //invite the user to login
        $url = $this->router
            ->generate('login');
        return new RedirectResponse($url);
    }
}