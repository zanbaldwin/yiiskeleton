<?php

    namespace application\controllers;

    use \Yii;
    use \CException;
    use \application\components\Controller;

    class LanguageController extends Controller
    {

        const SUCCESS                   = 0;
        const ERROR_NO_LANGUAGE         = 1;
        const ERROR_INVALID_LANGUAGE    = 3;

        /**
         * @var integer $errorCode
         * The integer identifier of the error code for switching languages.
         */
        protected $errorCode;

        /**
         * Action: Index
         *
         * @access public
         * @return void
         */
        public function actionIndex()
        {
            // Set a quick variable to specify which query string variable is going to be holding the user's selection.
            $query_var = 'lang';
            // If the language has not been specified in the query string, use the correct error code.
            if(!isset($_GET[$query_var]) || !$_GET[$query_var]) {
                $this->errorCode = self::ERROR_NO_LANGUAGE;
            }
            // If a language has been specified in the query string, but that language is invalid, use the appropriate
            // error code for that.
            elseif(
                !is_dir(Yii::getPathOfAlias('application.messages') . '/' . $_GET[$query_var])
             && $_GET[$query_var] !== Yii::app()->sourceLanguage
            ) {
                $this->errorCode = self::ERROR_INVALID_LANGUAGE;
            }
            // Otherwise...
            else {
                // Specify that there was no error in selecting the language.
                $this->errorCode = self::SUCCESS;
                // Set the user's selection of language from the query string to the language property of the
                // application, but also save it to the session so we can keep on using it on every subsequent request
                // without specifying it in the URL each time.
                Yii::app()->language = Yii::app()->session['language'] = $_GET[$query_var];
            }
            // If this was clicked on from a link within this application, redirect back to that page.
            if(is_string($referrer = Yii::app()->request->applicationReferrer)) {
                $this->redirect($referrer);
            }
            // Render a page informing the user whether or not the application language was successfully changed.
            $this->render('index', array('errorCode' => $this->errorCode));
        }

    }
