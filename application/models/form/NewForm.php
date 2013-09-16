<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    /**
     * LoginForm: Form Model
     *
     * LoginForm is the model for defining how the HTML login form is used.
     */
    class NewForm extends FormModel
    {

        public $firstinput;
        public $secondinput;


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
                array('secondinput', 'required'),
                array('firstinput', 'length', 'max' => 64),
            );
        }


        /**
         * Attribute Labels
         *
         * @access public
         * @return array
         */
        public function attributeLabels()
        {
            return array(
                'firstinput' => Yii::t('application', 'First Input'),
                'secondinput' => Yii::t('application', 'Second Input'),
            );
        }

    }
