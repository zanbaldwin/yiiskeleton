<?php

    use \application\components\Controller;

    class HomeController extends Controller
    {

        /**
         * Action: Index
         *
         * @access public
         * @return void
         */
        public function actionIndex()
        {
            $this->render('index');
        }

    }
