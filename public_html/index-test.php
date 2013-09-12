<?php

    defined('APPENV') || define('APPENV', 'test');
    defined('PRODUCTION') || define('PRODUCTION', APPENV === 'production');

    require_once dirname(__FILE__) . '/index.php';
