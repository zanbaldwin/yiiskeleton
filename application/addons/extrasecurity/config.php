<?php

    \application\components\EventManager::registerBehaviour(
        '\\application\\components\\UserIdentity',
        new \application\addons\extrasecurity\behaviours\MorePersistedStates
    );

    return array(
        'components' => array(
            'user' => array(
                'behaviors' => array(
                    '\\application\\addons\\extrasecurity\\behaviours\\CheckExtraParams',
                ),
            ),
        ),
    );
