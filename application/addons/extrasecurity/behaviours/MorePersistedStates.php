<?php

    namespace application\addons\extrasecurity\behaviours;

    use \Yii;
    use \CException;

    class MorePersistedStates extends \CBehavior
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
                'onStatesPersisted' => 'persistMoreStates',
            );
        }

        /**
         * Persist More States
         *
         * @access public
         * @return void
         */
        public function persistMoreStates($event)
        {
            // Keep track of the IP and User Agent that the user logged in with, if any of these change it it likely
            // that someone has stolen the session cookie and is trying to use it to masquerade themselves as the
            // original user.
            $event->sender->setState('loginIP', $_SERVER['REMOTE_ADDR']);
            $event->sender->setState('userAgent', $_SERVER['HTTP_USER_AGENT']);
        }

    }
