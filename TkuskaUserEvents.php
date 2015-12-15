<?php

namespace Tkuska\UserBundle;

/**
 * Contains all events thrown in the TkuskaUserBundle.
 */
final class TkuskaUserEvents
{
    /**
     * The CREATION_INITIALIZE event occurs when the creation process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a FOS\UserBundle\Event\UserEvent instance.
     */
    const CREATION_INITIALIZE = 'tkuska_user.creation.initialize';

    /**
     * The CREATION_SUCCESS event occurs when the creation form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a FOS\UserBundle\Event\FormEvent instance.
     */
    const CREATION_SUCCESS = 'tkuska_user.creation.success';

    /**
     * The CREATION_COMPLETED event occurs after saving the user in the creation process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a FOS\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const CREATION_COMPLETED = 'tkuska_user.creation.completed';

    /**
     * The CREATION_CONFIRM event occurs just before confirming the account.
     *
     * This event allows you to access the user which will be confirmed.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseUserEvent instance.
     */
    const CREATION_CONFIRM = 'tkuska_user.creation.confirm';

    /**
     * The CREATION_CONFIRMED event occurs after confirming the account.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a FOS\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const CREATION_CONFIRMED = 'tkuska_user.creation.confirmed';
    
    /**
     * The EDITION_INITIALIZE event occurs when the edition process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a FOS\UserBundle\Event\UserEvent instance.
     */
    const EDITION_INITIALIZE = 'tkuska_user.edition.initialize';

    /**
     * The EDITION_SUCCESS event occurs when the edition form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a FOS\UserBundle\Event\FormEvent instance.
     */
    const EDITION_SUCCESS = 'tkuska_user.edition.success';

    /**
     * The EDITION_COMPLETED event occurs after saving the user in the edition process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a FOS\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const EDITION_COMPLETED = 'tkuska_user.edition.completed';
}
