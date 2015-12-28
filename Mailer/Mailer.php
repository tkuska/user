<?php

namespace Tkuska\UserBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\Mailer as FOSMailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Mailer extends FOSMailer
{
    /**
     * {@inheritdoc}
     */
    public function sendCreationEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['creation.template'];
		$url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL );
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'password' => $user->getPlainPassword(),
            'confirmationUrl' => $url,
        ));
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['creation'], $user->getEmail());
    }
}
