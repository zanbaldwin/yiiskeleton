<?php

    namespace application\components;

    class FormModel extends \CFormModel
    {

        /**
         * Constructor Method
         *
         * @access public
         * @return void
         */
        public function __construct($scenario = '')
        {
            parent::__construct($scenario);
            \application\components\EventManager::attach($this);
        }

    }
