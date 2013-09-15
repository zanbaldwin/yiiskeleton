<?php

    namespace application\controllers;

    use \Yii;
    use \CException;
    use \application\components\Controller;

    class NewformController extends Controller
    {

        /**
         * Action: Index
         *
         * @access public
         * @return void
         */
        public function actionIndex()
        {
            // Create a new Form object; specify where to find the form configuration file and associate a form model with it.
            $form = new \application\components\Form('application.forms.anewform', new \application\models\form\NewForm);
            // Set default form model attributes here, like so:
                # $user = User::model()->findByPk(1);
                # $form->model->attributes = $user->attributes;
            if($form->submitted() && $form->validate()) {
                // The form validates! Save whatever was submitted, like so:
                    # $user->attributes = $form->model->attributes;
                    # $user->save();
                // If you want to check if a specific button has been pressed, specify the name of the button as it is
                // in the form configuration:
                    # $form->submitted('submit');
            }
            $this->render('index', array('form' => $form));
        }

    }
