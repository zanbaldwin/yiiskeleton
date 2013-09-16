<?php

    namespace application\addons\extrasecurity\behaviours;

    use \Yii;
    use \CException;

    class CheckExtraParams extends \CBehavior
    {

        /**
         * Events
         *
         * @access public
         * @return array
         */
        public function events()
        {
            return array(
                'onAuthenticated' => 'checkParams',
            );
        }

        public function checkParams($event)
        {
            // Check a couple of things for security, like if the user is on the same IP address and browser that
            // they used to log in with. Also check that the user exists in the database, and has not somehow been
            // banned from the system.
            if(
                $event->sender->getState('userAgent') != $_SERVER['HTTP_USER_AGENT']
             || $event->sender->getState('loginIP') != $_SERVER['REMOTE_ADDR']
             || !is_object($event->sender->model())
             || !$event->sender->model()->active
            ) {
                // If any of these simple checks fail, then log the user out immediately. Refer to the lengthy
                // explaination in the Logout controller as to why we pass bool(false).
                $event->sender->logout(false);
                // Set a flash message explaining that the user has been logged out (nothing worse than being kicked
                // out without an explaination - people may complain about the system being faulty otherwise).
                $event->sender->setFlash(
                    'logout',
                    Yii::t(
                        'system60',
                        'You have been logged out because an attempted security breach has been detected. If this happens again please contact an administrator, as someone may be trying to access your account.'
                    )
                );
            }
        }

    }
