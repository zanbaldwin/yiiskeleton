<?php

    // Set the date timezone so we don't keep getting all those annoying warnings.
    date_default_timezone_set('Europe/London');

    /* ======================= *\
    |  Set Application Aliases  |
    \* ======================= */

    // Set an alias to the new themes directory.
    Yii::setPathOfAlias('themes', dirname(__FILE__) . '/../themes');
    // Set a Yii alias to the composer packages directory.
    Yii::setPathOfAlias('composer', realpath(dirname(__FILE__) . '/../vendor'));

    /* ======================== *\
    |  Set Database Credentials  |
    \* ======================== */

    // Require the database credentials configuration. Do not use require_once because the database credentials may be
    // needed elsewhere in the application; it does not include any code that would cause an error if included again.
    $databases = require dirname(__FILE__) . '/databases.php';
    if(!isset($databases[APPENV]) || !is_array($databases[APPENV])) {
        throw new CDbException(
            Yii::t(
                'application',
                'Could not select the correct database credentials; please verify the application environment and database definitions.'
            )
        );
    }

    /* ======================== *\
    |  Composer Package Manager  |
    \* ======================== */

    // Require Composer's autoloader to use the packages that this project has a dependency on.
    require_once Yii::getPathOfAlias('composer') . '/autoload.php';

    /* ============================== *\
    |  Main Application Configuration  |
    \* ============================== */

    // This is the main Web application configuration. Any writable CWebApplication properties can be configured here.
    return array(
        'basePath' => dirname(__FILE__) . '/..',
        'name' => Yii::t('application', 'New Project'),
        'sourceLanguage' => 'en',
        'theme' => 'classic',
        'defaultController' => 'home',

        // Preloading 'log' component.
        'preload' => array('log'),

        'behaviors' => array(
            // Attach a a behaviour to the main application to set the application language for the end-user on the
            // "beginRequest" event.
            '\\application\\behaviours\\ApplicationLanguage',
        ),

        // Autoloading model and component classes. Hopefully this will eventually become obsolete by making use of
        // namespaces in all classes apart from controllers.
        'import' => array(
            'application.components.*',
        ),

        'modules' => array(
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'password',
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters'=>array('127.0.0.1', '::1'),
            ),
        ),

        // Application components.
        'components' => array(

            // System Component: Asset Manager.
            'assetManager' => array(
                'class' => 'system.web.CAssetManager',
                'linkAssets' => true,
            ),

            // System Component: Cache.
            'cache' => array(
                'class' => 'system.caching.CDummyCache',
            ),

            // System Component: Database.
            'db' => CMap::mergeArray(
                // This array should contain all the default settings for the database component, ready to be
                // overwritten by application environment specific credentials that are defined inside the database
                // configuration file.
                array(
                    'charset' => 'utf8',
                    'class' => 'system.db.CDbConnection',
                    'emulatePrepare' => true,
                ),
                // Pull the database credentials, and other settings (such as table prefix), for the current application
                // environment from the database configuration file and use them to override the default settings.
                $databases[APPENV]
            ),

            // System Component: Error Handler.
            'errorHandler' => array(
                'class' => 'system.base.CErrorHandler',
                // Use 'error/index' action to display errors.
                'errorAction' => 'error/index',
            ),

            // System Component: Log.
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'system.logging.CFileLogRoute',
                        'levels' => 'error, warning',
                    ),
                ),
            ),

            // System Components: Messages.
            'messages' => array(
                // NOTE: Please remove this behaviour in production, it is extremely database heavy. Only use in
                // development when populating the database with new messages and translations.
                'behaviors' => array('\\application\\behaviours\\MissingMessage'),
                'cacheID' => 'cache',
                'cachingDuration' => 60 * 30,
                'class' => 'system.i18n.CDbMessageSource',
                'connectionID' => 'db',
                'forceTranslation' => true,
                'sourceMessageTable' => '{{message}}',
                'translatedMessageTable' => '{{translation}}',
            ),

            // Application Component: HTTP Request.
            'request' => array(
                'class' => 'application\\components\\HttpRequest',
                'enableCookieValidation' => true,
            ),

            // System Component: HTTP Database Session.
            'session' => array(
                'autoStart' => true,
                'class' => 'system.web.CDbHttpSession',
                'connectionID' => 'db',
                'cookieMode' => 'only',
                'sessionName' => 'application',
                'sessionTableName' => '{{session}}',
                'timeout' => 64800,
            ),

            // System Component: Theme Manager.
            'themeManager' => array(
                'basePath' => Yii::getPathOfAlias('themes'),
                'class' => 'system.web.CThemeManager',
            ),

            // System Component: URL Manager.
            'urlManager' => array(
                'appendParams' => false,
                'class' => 'system.web.CUrlManager',
                'rules' => require dirname(__FILE__) . '/routes.php',
                'showScriptName' => false,
                'urlFormat' => 'path',
            ),

            // Application Component: Web User.
            'user' => array(
                // Enable cookie-based authentication.
                'allowAutoLogin' => true,
                'class' => '\\application\\components\\WebUser',
                'loginUrl' => array('/login'),
            ),

        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
            // Define the minimum amount of time allowed between login attempts.
            'login.throttle' => 0.5,
        ),
    );
