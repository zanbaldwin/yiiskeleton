<?php

    // The following paths represent where to find Composer's Autoloader, the main application configuration file, and
    // the Yii Framework bootstrap file.

    $app        = dirname(__FILE__) . '/../application';

    $yii        = $app . '/vendor/yiisoft/yii/framework/yii.php';
    $config     = $app . '/config/main.php';
    $env        = dirname($config)  . '/appenv.php';

    /* ========================================== *\
    |  Application Environment and Debug Settings  |
    \* ========================================== */

    // Require the configuration file that sets the application environment (unless it has already been set by another
    // front-controller).
    require_once $env;

    // If we are not in production mode, we want to enable debugging, HTML logging, and backtraces.
    // Note that YII_DEBUG must be defined BEFORE we include the Yii Framework bootstrap file.
    if(!PRODUCTION) {
        headers_sent() || header('Application-Environment: ' . ucwords(APPENV));
        defined('YII_DEBUG') || define('YII_DEBUG', true);
        defined('YII_TRACE_LEVEL') || define('YII_TRACE_LEVEL', 3);
    }

    /* ========================================== *\
    |  Yii Framework and Web Application + Config  |
    \* ========================================== */

    // Require the Yii Framework bootstrap file.
    require_once $yii;
    // And create our web application!
    Yii::createWebApplication($config)->run();
