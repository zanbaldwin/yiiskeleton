<?php

    namespace application\components;

    use \Yii;
    use \CException;

    class EventManager extends \CApplicationComponent
    {

        protected static $events = array();
        protected static $behaviours = array();

        /**
         * Register: Event Handler
         *
         * Really wish I could put "callable" type-hinting for the third parameter, but I plan on keeping PHP 5.3
         * support for as long as possible, so is_callable() will have to be used inside the method.
         *
         * @static
         * @access public
         * @param string $container
         * @param string $eventName
         * @param callable $closure
         * @return void
         */
        public static function registerEventHandler($container, $eventName, $handler)
        {
            if(is_string($container) && strlen($container = ltrim($container, '\\')) > 0) {
                if(is_string($eventName)) {
                    if(is_callable($handler)) {
                        if(!isset(self::$events[$container]) || !is_array(self::$events[$container])) {
                            self::$events[$container] = array();
                        }
                        self::$events[$container][$eventName][] = $handler;
                    }
                    else {
                        throw new CException(
                            Yii::t(
                                'darsyn',
                                'Invalid data type passed to {method}; the event must be a callable closure or function/method reference.',
                                array('{method}' => __METHOD__)
                            )
                        );
                    }
                }
                else {
                    throw new CException(
                        Yii::t(
                            'darsyn',
                            'Invalid data type passed to {method}; the event name must be a string.',
                            array('{method}' => __METHOD__)
                        )
                    );
                }
            }
            else {
                throw new CException(
                    Yii::t(
                        'darsyn',
                        'Invalid data type passed to {method}; the container name must be a string.',
                        array('{method}' => __METHOD__)
                    )
                );
            }
        }

        /**
         * Register: Behaviour
         *
         * @static
         * @access public
         * @param string $container
         * @param class|object $behaviour
         * @return void
         */
        public static function registerBehaviour($container, $behaviour)
        {
            if(is_string($container) && strlen($container = ltrim($container, '\\')) > 0) {
                if(((is_string($behaviour) && class_exists($behaviour)) || is_object($behaviour)) && is_subclass_of($behaviour, '\\CBehavior')) {
                    if(!isset(self::$behaviours[$container]) || !is_array(self::$behaviours[$container])) {
                        self::$behaviours[$container] = array();
                    }
                    self::$behaviours[$container][] = $behaviour;
                }
                else {
                    throw new CException(
                        Yii::t(
                            'darsyn',
                            'Invalid data type passed to {method}; the behaviour must be an object or string reference of a class that extends CBehavior.',
                            array('{method}' => __METHOD__)
                        )
                    );
                }
            }
            else {
                throw new CException(
                    Yii::t(
                        'darsyn',
                        'Invalid data type passed to {method}; the container name must be a string.',
                        array('{method}' => __METHOD__)
                    )
                );
            }
        }

        /**
         * Attach Events and Behaviours
         *
         * @static
         * @access public
         * @param CComponent $component
         * @return void
         */
        public static function attach(\CComponent $component)
        {
            $container = get_class($component);
            // Attach events.
            if(isset(self::$events[$container])) {
                foreach(self::$events[$container] as $eventName => $handlers) {
                    foreach($handlers as $handler) {
                        $component->attachEventHandler($eventName, $handler);
                    }
                }
            }
            // Attach behaviours.
            if(isset(self::$behaviours[$container])) {
                $component->attachBehaviors(self::$behaviours[$container]);
            }
        }

    }
