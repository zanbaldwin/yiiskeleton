<?php

    class m130807_183909_user_meta_table extends CDbMigration
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
                '{{user_meta}}',
                array(
                    // Entities.
                    'user'  => 'INT             NOT NULL    COMMENT "The automatic, machine-readable identifier (integer) for a staff member represented in this table."',
                    'email' => 'VARCHAR(255)    UNIQUE      COMMENT "An email address that is associated with the user account to be used as the main point of contact."',
                    'phone' => 'CHAR(11)        UNIQUE      COMMENT "A UK mobile phone number to be used for sending SMS\'s to; for 2-step verification, or similar security situations."',
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = "Any extra information about the users of this system that is not necessarily required by the system but may facilitate additional functionality."',
                    'AUTO_INCREMENT  = 1',
                ))
            );
            $this->addPrimaryKey('user_meta_pk', '{{user_meta}}', 'user');
            $this->addForeignKey('user_meta_user_fk', '{{user_meta}}', 'user', '{{user}}', 'id');
        }

        /**
         * Migrate Down
         *
         * @access public
         * @return void
         */
        public function down()
        {
            $this->dropTable('{{user_meta}}');
        }

    }
