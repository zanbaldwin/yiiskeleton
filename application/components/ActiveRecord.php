<?php

    namespace application\components;

    class ActiveRecord extends \CActiveRecord
    {

        /**
         * Constructor Method
         *
         * @access public
         * @return void
         */
        public function __construct($scenario = 'insert')
        {
            parent::__construct($scenario);
            \application\components\EventManager::attach($this);
        }

    }
