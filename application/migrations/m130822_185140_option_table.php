<?php

    class m130822_185140_option_table extends CDbMigration
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
                '{{option}}',
                array(
                    'id'            => 'pk                                      COMMENT "The automatic, machine-readable identifier (integer) for an option represented in this table."',
                    'column'        => 'VARCHAR(255)    NOT NULL                COMMENT "The name of the column that the option represented in this table belongs to, in the format \'table_name.column_name\'."',
                    'data'          => 'TEXT                                    COMMENT "A string of serialised data that the option represented in the table has been assigned."',
                    'name'          => 'TEXT                                    COMMENT "An optional label (name) for the option represented in this table."',
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = ""',
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
            $this->dropTable('{{option}}');
        }

    }
