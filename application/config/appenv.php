<?php

    // Determine the application environment.
    $appenv = file_exists($envfile = dirname(__FILE__) . '/.environment')
        ? trim(file_get_contents($envfile))
        : false;

    defined('VALIDLABEL') || define('VALIDLABEL', '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*');
    if(!is_string($appenv) || !preg_match('/^' . VALIDLABEL . '$/', trim($appenv))) {
        throw new Exception(
            'Could not determine a valid application environment in "' . str_replace('\\', '/', $envfile) . '".'
        );
    }

    defined('APPENV') || define('APPENV', strtolower($appenv));
    defined('PRODUCTION') || define('PRODUCTION', APPENV === 'production');
    unset($appenv, $envfile);
