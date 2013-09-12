<?php

    namespace application\model\form;

    use \Yii;
    use \CException;

    /**
     * LoginForm: Form Model
     *
     * LoginForm is the model for defining how the HTML login form is used.
     */
    class Logout extends \CFormModel
    {

        /**
         * @var boolean $switch
         */
        public $switch;


        /**
         * Validation Rules
         *
         * Defines the validation rules for the form inputs.
         *
         * @access public
         * @return array
         */
        public function rules()
        {
            return array(
                array('switch', 'boolean'),
            );
        }

    }
