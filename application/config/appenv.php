<?php

    // Define the Perl-Compatible Regular Expression for valid labels in PHP, as application environments must adhere
    // to this rule.
    defined('VALIDLABEL') || define('VALIDLABEL', '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*');


    // If a front-controller has specified the ENVIRONMENT constant, it means they wish to override the default
    // application environment with another (for example, index-test.php may wish to force the use of the "test"
    // environment).
    if(defined('ENVIRONMENT')) {
        $appenv = trim(ENVIRONMENT);
    }
    else {
        // Determine the default application environment from the "environment configuration file".
        $appenv = file_exists($envfile = str_replace('\\', '/', dirname(__FILE__)) . '/.environment')
            ? trim(file_get_contents($envfile))
            : false;
    }

    // Make sure the application environment specified adheres to a the same rules as a valid PHP label.
    if(!is_string($appenv) || !preg_match('/^' . VALIDLABEL . '$/', trim($appenv))) {
        throw new Exception(
            'Could not determine a valid application environment in '
          . (isset($envfile) ? 'environment configuration file "' . $envfile . '".' : 'ENVIRONMENT constant.')
        );
    }

    defined('APPENV')       || define('APPENV',     strtolower($appenv));
    defined('PRODUCTION')   || define('PRODUCTION', APPENV === 'production');
    unset($appenv, $envfile);
