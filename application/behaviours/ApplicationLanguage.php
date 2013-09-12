<?php

    namespace application\behaviours;

    use \Yii;
    use \CException;

    class ApplicationLanguage extends \CBehavior
    {

        /**
         * Behaviour Events
         *
         * @access public
         * @return void
         */
        public function events()
        {
            return array(
                'onBeginRequest' => 'useLanguage',
            );
        }

        /**
         * Use Language
         *
         * @access public
         * @return void
         */
        public function useLanguage()
        {
            // If the user has specified an alternative language to view the application in, use that. If they haven't,
            // use their preferred language as specified by the headers sent by their browser.
            Yii::app()->language = isset(Yii::app()->session['language'])
                ? Yii::app()->session['language']
                : Yii::app()->request->preferredLanguage;
        }

    }
