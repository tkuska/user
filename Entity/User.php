<?php

namespace Tkuska\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Description of Uzytkoenik.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
abstract class User extends BaseUser
{
    /**
     * @var \DateTime
     */
    protected $passwordExpireAt;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @return \DateTime
     */
    public function getPasswordExpireAt()
    {
        return $this->passwordExpireAt;
    }

    /**
     * @param \DateTime $passwordExpireAt
     *
     * @return \Tkuska\UserBundle\Model\User
     */
    public function setPasswordExpireAt(\DateTime $passwordExpireAt = null)
    {
        $this->passwordExpireAt = $passwordExpireAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Tkuska\UserBundle\Model\User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return \Tkuska\UserBundle\Model\User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function __toString()
    {
        return $this->name.' '.$this->lastName;
    }
}
