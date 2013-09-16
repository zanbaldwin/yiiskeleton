<?php

    namespace application\components;

    use \Yii;
    use \CException;

    /**
     * Controller
     *
     * Controller is the customized base controller class. All controller classes for this application should extend
     * from this base class.
     */
    abstract class Controller extends \CController
    {

        /**
         * Constructor Method
         *
         * @access public
         * @reutrn void
         */
        public function __construct($id, $module = null)
        {
            parent::__construct($id, $module);
            // Attach all registered event handlers and behaviours for the current controller.
            \application\components\EventManager::attach($this);
        }

        /**
         * @var string $layout
         * The default layout for the controller view.
         */
        public $layout = '//layouts/column1';

        /**
         * @var array $menu
         * Context menu items. This property will be assigned to CMenu::items.
         */
        public $menu = array();

        /**
         * @var array $breadcrumbs
         * The breadcrumbs of the current page. The value of this property will be assigned to CBreadcrumbs::links.
         */
        public $breadcrumbs = array();

    }
