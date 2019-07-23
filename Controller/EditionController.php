<?php

namespace Tkuska\UserBundle\Controller;

use Tkuska\UserBundle\TkuskaUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller managing the registration.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class EditionController extends Controller
{
    public function editAction(Request $request, $username)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('tkuska_user.edition.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByUsername($username);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(TkuskaUserEvents::EDITION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(TkuskaUserEvents::EDITION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('tkuska_user_edition_edit', array('username' => $user->getUsername()));
                $response = new RedirectResponse($url);
            }
            $dispatcher->dispatch(TkuskaUserEvents::EDITION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render($this->getParameter('tkuska_user.edition.form.template'), array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}
