<?php

    class m130810_133918_administration_user extends CDbMigration
    {

        /**
         * Migrate Up
         *
         * @access public
         * @return void
         */
        public function up()
        {
            // Create a user.
            $phpass = new \Phpass\Hash;
            $this->insert('{{user}}', array(
                'username'  => 'admin',
                'password'  => $phpass->hashPassword('admin'),
                'firstname' => 'System',
                'nickname'  => 'Sysadmin',
                'lastname'  => 'Administrator',
                'created'   => microtime(true),
            ));
        }

        /**
         * Migrate Down
         *
         * @access public
         * @return void
         */
        public function down()
        {
            $this->delete(
                '{{user}}',
                array('AND',
                    implode('=', array(
                        Yii::app()->db->quoteColumnName('username'),
                        Yii::app()->db->quoteValue('admin'),
                    )),
                )
            );
        }

    }
