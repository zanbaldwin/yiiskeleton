<?php

    namespace application\components;

    use \Yii;
    use \CException;
    use \application\models\db\User;

    /**
     * Web User
     *
     * @author      Zander Baldwin <mynameiszanders@gmail.com>
     * @license     MIT/X11 <http://j.mp/mit-license>
     * @copyright   Zander Baldwin <http://mynameis.zande.rs>
     */
    class WebUser extends \CWebUser
    {

        protected $user;


        /**
         * Initialisation Method
         *
         * @access public
         * @return void
         */
        public function init()
        {
            parent::init();
            // Is the user logged in?
            if($this->isGuest === false) {
                // Check a couple of things for security, like if the user is on the same IP address and browser that
                // they used to log in with. Also check that the user exists in the database, and has not somehow been
                // banned from the system.
                if(
                    $this->getState('userAgent') != $_SERVER['HTTP_USER_AGENT']
                 || $this->getState('loginIP') != $_SERVER['REMOTE_ADDR']
                 || !is_object($this->user = User::model()->findByPk($this->getState('id')))
                 || !$this->user->active
                ) {
                    // If any of these simple checks fail, then log the user out immediately. Refer to the lengthy
                    // explaination in the Logout controller as to why we pass bool(false).
                    $this->logout(false);
                    // Set a flash message explaining that the user has been logged out (nothing worse than being kicked
                    // out without an explaination - people may complain about the system being faulty otherwise).
                    $this->setFlash(
                        'logout',
                        Yii::t(
                            'application',
                            'You have been logged out because an attempted security breach has been detected. If this happens again please contact an administrator, as someone may be trying to access your account.'
                        )
                    );
                }
            }
        }


        /**
         * User Model
         *
         * @access public
         * @return User|null
         */
        public function model()
        {
            return is_object($this->user)
                ? $this->user
                : null;
        }


        /**
         * Get: Display Name
         *
         * @access public
         * @return string|null
         */
        public function getDisplayName()
        {
            return is_object($this->user)
                ? $this->user->displayName
                : null;
        }


        /**
         * Get: Full Name
         *
         * @access public
         * @return string|null
         */
        public function getFullName()
        {
            return is_object($this->user)
                ? $this->user->fullName
                : null;
        }


        /**
         * Get: Current Branch
         *
         * Returns the ID of the branch the currently logged-in user is viewing the site as. If a branch has not been
         * specified, then the ID of the branch the user actually belongs to is returned.
         *
         * @access public
         * @return integer
         */
        public function getBranch()
        {
            return $this->getState('branch', $this->user->branch);
        }


        /**
         * Get: Current Organisation
         *
         * Returns the ID of the organisation the currently logged-in user is viewing the site as. If an organisation
         * has not been specified, then the ID of the organisation the user actually belongs to is returned.
         *
         * @access public
         * @return integer
         */
        public function getOrganisation()
        {
            return $this->getState('organisation', $this->user->organisation);
        }

    }
