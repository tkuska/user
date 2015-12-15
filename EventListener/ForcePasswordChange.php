<?php

namespace Tkuska\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Service("request.set_messages_count_listener")
 */
class ForcePasswordChange
{
    private $token_storage;
    private $authorization_checker;
    private $router;
    private $session;

    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authorization_checker, TokenStorageInterface $token_storage, Session $session)
    {
        $this->token_storage = $token_storage;
        $this->authorization_checker = $authorization_checker;
        $this->router = $router;
        $this->session = $session;
    }

    public function onCheckStatus(GetResponseEvent $event)
    {
        if (($this->token_storage->getToken()) && ($this->authorization_checker->isGranted('IS_AUTHENTICATED_FULLY'))) {
            $route_name = $event->getRequest()->get('_route');
            $user = $this->token_storage->getToken()->getUser();
            if (isset($route_name) && $route_name != 'fos_user_change_password') {
                if ($user instanceof \Tkuska\UserBundle\Entity\User && !is_null($user->getPasswordExpireAt()) && $user->getPasswordExpireAt() < new \DateTime(date('Y-m-d H:i:s'))) {
                    $response = new RedirectResponse($this->router->generate('fos_user_change_password'));
                    $this->session->getFlashBag()->add('notice', sprintf('Twoje hasło straciło ważność dnia %s, proszę ustanowić nowe hasło.', $this->token_storage->getToken()->getUser()->getPasswordExpireAt()->format('Y-m-d H:i:s')));
                    $event->setResponse($response);
                }
            }
        }
    }
}
