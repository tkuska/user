<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tkuska\UserBundle\EventListener;

use Tkuska\UserBundle\TkuskaUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailConfirmationListener implements EventSubscriberInterface
{
    private $mailer;
    private $tokenGenerator;
    private $router;
    private $session;
    private $forceChangePassword;

    public function __construct(MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UrlGeneratorInterface $router, SessionInterface $session, $forceChangePassword = true)
    {
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->router = $router;
        $this->session = $session;
        $this->forceChangePassword = (Boolean) $forceChangePassword;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TkuskaUserEvents::CREATION_SUCCESS => 'onCreationSuccess',
        );
    }

    public function onCreationSuccess(FormEvent $event)
    {
        /** @var $user Tkuska\UserBundle\Entity\User */
        $user = $event->getForm()->getData();

        $user->setPlainPassword(substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10));
        $user->setEnabled(false);
        if ($this->forceChangePassword) {
            $user->setPasswordExpireAt(new \DateTime());
        }
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $this->mailer->sendCreationEmailMessage($user);

        $this->session->set('fos_user_send_confirmation_email/email', $user->getEmail());

        $url = $this->router->generate('tkuska_user_creation_create');
        $event->setResponse(new RedirectResponse($url));
    }
}
