<?php

    class m130807_182716_user_table extends CDbMigration
    {

        /**
         * Migrate Up
         *
         * @access public
         * @return void
         */
        public function up()
        {
            $this->createTable(
                '{{user}}',
                array(
                    // Entities.
                    'id'            => 'pk                                      COMMENT "The automatic, machine-readable identifier (integer) for a staff member represented in this table."',
                    'username'      => 'VARCHAR(64)     NOT NULL UNIQUE         COMMENT "The human-readable identifier string for a staff member represented in this table."',
                    'password'      => 'CHAR(60)        NOT NULL                COMMENT "A 60 character hash of the users password."',
                    'firstname'     => 'VARCHAR(128)    NOT NULL                COMMENT "The users first name, used for reporting data about staff."',
                    'nickname'      => 'VARCHAR(128)                            COMMENT "The users preferred name, used for addressing the user."',
                    'lastname'      => 'VARCHAR(128)    NOT NULL                COMMENT "The users last name, used for reporting data about staff."',
                    'created'       => 'DOUBLE UNSIGNED NOT NULL                COMMENT "The micro timestamp of when the users account was created."',
                    'last_login'    => 'DOUBLE UNSIGNED                         COMMENT "A micro timestamp of the users last successful login."',
                    'active'        => 'BIT(1)          NOT NULL DEFAULT b\'1\' COMMENT "A boolean flag as to whether the user is active within the system (switch to false to ban the user from logging in)."',
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = "The user definitions and credentials of the staff members using this system."',
                    'AUTO_INCREMENT  = 1',
                ))
            );
        }

        /**
         * Migrate Down
         *
         * @access public
         * @return void
         */
        public function down()
        {
            $this->dropTable('{{user}}');
        }

    }
