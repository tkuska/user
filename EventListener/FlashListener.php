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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Session\Session;
use Tkuska\UserBundle\TkuskaUserEvents;
use FOS\UserBundle\EventListener\FlashListener as FOSFlashListener;

class FlashListener extends FOSFlashListener
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    private static $successMessages = array(
        TkuskaUserEvents::CREATION_SUCCESS => 'Użytkownik został utworzony.',
        TkuskaUserEvents::CREATION_COMPLETED => 'Dane dostępowe zostały wysłane na adres email z formularza.',
    );

    public static function getSubscribedEvents()
    {
        return array(
            TkuskaUserEvents::CREATION_COMPLETED => 'addSuccessFlash',
            TkuskaUserEvents::CREATION_SUCCESS => 'addSuccessFlash',
        );
    }

    public function addSuccessFlash(Event $event, $eventName = null)
    {
        // BC for SF < 2.4
        if (null === $eventName) {
            $eventName = $event->getName();
        }

        if (!isset(self::$successMessages[$eventName])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', self::$successMessages[$eventName]);
    }
}
