<?php

    use \application\models\db\User;
    use \application\models\db\FailedLogin;

    /**
     * User Identity
     *
     * Represents the data need to identify a user. It contains the authentication method used to check if the
     * credentials provided by the end-user are correct in order to authenticate that end-user with the details of the
     * associated user provided by the User model.
     */
    class UserIdentity extends \CUserIdentity
    {

        /**
         * @var integer $id
         */
        protected $id;

        /**
         * Error Constants
         */
        const ERROR_IP_INVALID = 3;
        const ERROR_THROTTLED = 4;
        const ERROR_ID_INVALID = 5;


        /**
         * Get: User ID
         *
         * This implementation is to override the default behaviour of getId() in CUserIdentity, which returns the
         * username as the user ID. We want the user ID to be the user ID, because y'know, that's what it is?
         *
         * @access public
         * @return integer
         */
        public function getId()
        {
            return $this->id;
        }


        /**
        * Load User
        *
        * Create an identity based upon the details a user in the database with the ID specified.
        *
        * @access public
        * @param integer|string $id
        * @return boolean
        */
        public function load($id)
        {
            // Attempt to load the user specified by the ID passed from the database.
            $user = is_int($id)
                ? User::model()->findByPk($id)
                : User::model()->findByAttributes(array('username' => $id));
            // If a user with that ID does not exist, set the error code to ERROR_ID_INVALID, and return false.
            if(!is_object($user)) {
                $this->errorCode = self::ERROR_ID_INVALID;
                return false;
            }
            // Set the identity ID to the ID of the user we are loading.
            $this->id = (int) $user->id;
            // Set the user variables that we would like persisted accross subsequent HTTP requests in the session
            // state.
            $this->setPersistentStates(array(
                // The ID of the user that is logged in. This is required at the very least (if you don't specify a
                // user, who's logged in?)
                'id' => $this->id,
                // Set this to false to quickly identify that the user is not a guest and is, in fact, an authenticated
                // user. Yii doesn't seem to set this automatically, which is disappointing.
                'isGuest' => false,
            ));
            // Now that information has been store to the session state, specify that we did not come across an error
            // and return true.
            $this->errorCode = self::ERROR_NONE;
            return true;
        }


        /**
         * Authenticate User
         *
         * Without specifying all of the events, which are listed below, this method performs the following:
         *
         * - Load a model of the user defined by the username given.
         * - If the user does not exist in the database, set the error code to ERROR_USERNAME_INVALID, and return false.
         * - Check that the password suppled matched the hash stored in the database.
         * - If the password was incorrect, set the error code to ERROR_PASSWORD_INVALID, and return false.
         * - User has now passed authentication. Set the error code to ERROR_NONE, set the states that are to be
         *   persisted in the session and return true.
         *
         * @event onAuthenticateStart
         * @event onUsernameInvalid
         * @event onUsernameValid
         * @event onPasswordIncorrect
         * @event onPasswordCorrect
         * @event onStatesPersisted
         *
         * @access public
         * @return boolean
         */
        public function authenticate()
        {
            // Raise the "startAuthenticate" event.
            $this->onAuthenticateStart(new CEvent($this));

            // Load the model of the user defined by the username provided by the end-user.
            $user = User::model()->findByAttributes(array('username' => $this->username));
            // If the user does not exist in the database, or the user has been disabled (inactive), set the error code
            // to ERROR_USERNAME_INVALID, return false.
            if(!is_object($user) || !$user->active) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
                // Raise "onPasswordIncorrect" event; specifying that the password that the end-user entered was
                // incorrect.
                $this->onUsernameInvalid(new CEvent($this));
                return false;
            }
            // Store the user ID in a local scope variable so that we don't have to query the User model object each
            // time we reference it.
            $this->id = (int) $user->id;

            // Raise the "onUsernameValid" event; specifying that the username that the end-user entered has been found
            // in the database.
            $this->onUsernameValid(new CEvent($this));

            // Check that the password supplied matched the hash stored in the database. If it doesn't add a FailedLogin
            // entry, set the error code to ERROR_PASSWORD_INVALID, return false.
            if(!$user->password($this->password)) {
                // Set the error code.
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                // Raise the "onPasswordIncorrect" event; specifying that the password that the end-user entered was
                // incorrect.
                $this->onPasswordIncorrect(new CEvent($this));
                return false;
            }

            // Raise the "onPasswordCorrect" event; specifying that the password that the end-user entered was correct.
            $this->onPasswordCorrect(new CEvent($this));

            // Set the user variables that we would like persisted accross subsequent HTTP requests in the session
            // state.
            $this->setPersistentStates(array(
                // The ID of the user that is logged in. This is required at the very least (if you don't specify a
                // user, who's logged in?)
                'id' => $this->id,
                // Set this to false to quickly identify that the user is not a guest and is, in fact, an authenticated
                // user. Yii doesn't seem to set this automatically, which is disappointing.
                'isGuest' => false,
            ));

            // Raise the "onStatesPersisted" event; specifying that the variables to be saved in the user-specific
            // session have been defined.
            $this->onStatesPersisted(new CEvent($this));

            // Now that information has been store to the session state, specify that we did not come across an error
            // and return true.
            $this->errorCode = self::ERROR_NONE;
            return true;
        }

        /* ================= *\
        |  EVENT DEFINITIONS  |
        \* ================= */

        /**
         * Event: Start Authenticate Process
         *
         * @access public
         * @return void
         */
        public function onAuthenticateStart($event)
        {
            // Use __FUNCTION__ instead of __METHOD__, as the latter will also return the name of the class that the
            //method belongs to, which is not desired.
            if($this->hasEventHandler($name = __FUNCTION__)) {
                $this->raiseEvent($name, $event);
            }
        }

        /**
         * Event: Start Authenticate Process
         *
         * @access public
         * @return void
         */
        public function onUsernameInvalid($event)
        {
            // Use __FUNCTION__ instead of __METHOD__, as the latter will also return the name of the class that the
            //method belongs to, which is not desired.
            if($this->hasEventHandler($name = __FUNCTION__)) {
                $this->raiseEvent($name, $event);
            }
        }

        /**
         * Event: Start Authenticate Process
         *
         * @access public
         * @return void
         */
        public function onUsernameValid($event)
        {
            // Use __FUNCTION__ instead of __METHOD__, as the latter will also return the name of the class that the
            //method belongs to, which is not desired.
            if($this->hasEventHandler($name = __FUNCTION__)) {
                $this->raiseEvent($name, $event);
            }
        }

        /**
         * Event: Start Authenticate Process
         *
         * @access public
         * @return void
         */
        public function onPasswordIncorrect($event)
        {
            // Use __FUNCTION__ instead of __METHOD__, as the latter will also return the name of the class that the
            //method belongs to, which is not desired.
            if($this->hasEventHandler($name = __FUNCTION__)) {
                $this->raiseEvent($name, $event);
            }
        }

        /**
         * Event: Start Authenticate Process
         *
         * @access public
         * @return void
         */
        public function onPasswordCorrect($event)
        {
            // Use __FUNCTION__ instead of __METHOD__, as the latter will also return the name of the class that the
            //method belongs to, which is not desired.
            if($this->hasEventHandler($name = __FUNCTION__)) {
                $this->raiseEvent($name, $event);
            }
        }

        /**
         * Event: Start Authenticate Process
         *
         * @access public
         * @return void
         */
        public function onStatesPersisted($event)
        {
            // Use __FUNCTION__ instead of __METHOD__, as the latter will also return the name of the class that the
            //method belongs to, which is not desired.
            if($this->hasEventHandler($name = __FUNCTION__)) {
                $this->raiseEvent($name, $event);
            }
        }

    }
