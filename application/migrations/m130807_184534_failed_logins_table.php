<?php

    class m130807_184534_failed_logins_table extends CDbMigration
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
                '{{failed_logins}}',
                array(
                    'user'      => 'INT             NOT NULL            COMMENT "The machine-readable indentifier of the user account that the failed login attempt focused on."',
                    'timestamp' => 'DOUBLE UNSIGNED NOT NULL            COMMENT "The micro timestamp of the of failed login attempt."',
                    'password'  => 'CHAR(40)        NOT NULL            COMMENT "A SHA1 hash of the password used in the failed login attempt, for referecing against other users."',
                    'ip'        => 'VARCHAR(45)     NOT NULL            COMMENT "The IP address that the failed login attempt originated from."',
                    'attempts'  => 'INT             NOT NULL DEFAULT 0  COMMENT "The number of premature attempts that happened before the throttling threshold had expired."',
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = ""',
                    'AUTO_INCREMENT  = 1',
                ))
            );
            $this->addPrimaryKey('failed_logins_pk', '{{failed_logins}}', 'user, timestamp');
            $this->addForeignKey('failed_logins_user_fk', '{{failed_logins}}', 'user', '{{user}}', 'id');
        }

        /**
         * Migrate Down
         *
         * @access public
         * @return void
         */
        public function down()
        {
            $this->dropTable('{{failed_logins}}');
        }

    }
