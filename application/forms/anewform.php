<?php

    return array(
        'title' => Yii::t('application', 'A New Form.'),
        'description' => Yii::t('application', 'This is an example form combining the form object, model, configuration and views.'),
        'method' => 'post',

        'elements' => array(
            'firstinput' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'This input is a text field.'),
            ),
            'secondinput' => array(
                'type' => 'password',
                'hint' => Yii::t('application', 'This input is a password field.'),
            ),
        ),

        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Process Form'),
            ),
        ),
    );
