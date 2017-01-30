<?php

namespace Tkuska\UserBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\TwigSwiftMailer as FOSMailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SwiftMailer extends FOSMailer
{
    /**
     * {@inheritdoc}
     */
    public function sendCreationEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['creation.template'];
        $url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL );
        $context = array(
            'user' => $user,
            'password' => $user->getPlainPassword(),
            'confirmationUrl' => $url,
        );
        $this->sendMessage($template, $context, $this->parameters['from_email']['creation'], $user->getEmail());
    }
}
