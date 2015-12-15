<?php

namespace Tkuska\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Listener responsible to change the redirection at the end of the password change.
 */
class PasswordChangeListener implements EventSubscriberInterface
{
    private $token_storage;
    private $router;
    private $usermanager;
    private $password_expire_time;

    public function __construct(UrlGeneratorInterface $router, TokenStorageInterface $token_storage, UserManager $usermanager, $password_expire_time = null)
    {
        $this->token_storage = $token_storage;
        $this->router = $router;
        $this->usermanager = $usermanager;
        $this->password_expire_time = $password_expire_time;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onChangePasswordSuccess',
        );
    }

    public function onChangePasswordSuccess(FormEvent $event)
    {
        $user = $this->token_storage->getToken()->getUser();
        if (!is_null($this->password_expire_time)) {
            $currentDate = new \DateTime();
            $currentDate->add(new \DateInterval($this->password_expire_time));
            $user->setPasswordExpireAt($currentDate);
        } else {
            $user->setPasswordExpireAt();
        }
        $this->usermanager->updateUser($user);

        $url = $this->router->generate('homepage');
        $event->setResponse(new RedirectResponse($url));
    }
}
