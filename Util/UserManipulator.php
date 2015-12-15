<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tkuska\UserBundle\Util;

use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Executes some manipulations on the users.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class UserManipulator
{
    /**
     * User manager.
     *
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Creates a user and returns it.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $name
     * @param string $lastName
     * @param bool   $active
     * @param bool   $superadmin
     *
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function create($username, $password, $email, $name, $lastName, $active, $superadmin, $changePassword)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setName($name);
        $user->setLastName($lastName);
        $user->setEnabled((Boolean) $active);
        $user->setSuperAdmin((Boolean) $superadmin);
        if ((Boolean) $changePassword) {
            $user->setPasswordExpireAt(new \DateTime());
        }
        $this->userManager->updateUser($user);

        return $user;
    }
}
