<?php

    // Set the correct file paths for the published classes made available with this addon.
    Yii::$classMap['application\\models\\db\\Message'] = dirname(__FILE__) . '/models/Message.php';

    return array(

        'behaviors' => array(
            // Attach a a behaviour to the main application to set the application language for the end-user on the
            // "beginRequest" event.
            '\\application\\addons\\language\\behaviours\\ApplicationLanguage',
        ),

        'components' => array(
            // System Components: Messages.
            'messages' => array(
                'behaviors' => array('\\application\\addons\\language\\behaviours\\MissingMessage'),
                'cacheID' => 'cache',
                'cachingDuration' => 60 * 30,
                'class' => 'system.i18n.CDbMessageSource',
                'connectionID' => 'db',
                'forceTranslation' => true,
                'sourceMessageTable' => '{{message}}',
                'translatedMessageTable' => '{{translation}}',
            ),
        ),

    );
