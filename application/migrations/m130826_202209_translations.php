<?php

    class m130826_202209_translations extends CDbMigration
    {

        /**
         * Migrate: Up
         *
         * @access public
         * @return void
         */
        public function up()
        {
            $this->createTable(
                '{{message}}',
                array(
                    'id'            => 'pk                                      COMMENT ""',
                    'category'      => 'VARCHAR(32)     NOT NULL                COMMENT ""',
                    'message'       => 'text                                    COMMENT ""',
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = ""',
                    'AUTO_INCREMENT  = 1',
                ))
            );
            $this->createTable(
                '{{translation}}',
                array(
                    'id'            => 'INT             NOT NULL                COMMENT ""',
                    'language'      => 'VARCHAR(16)     NOT NULL                COMMENT ""',
                    'translation'   => 'text            NOT NULL                COMMENT ""',
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = ""',
                    'AUTO_INCREMENT  = 1',
                ))
            );
            $this->addPrimaryKey('translation_pk', '{{translation}}', 'id, language');
            $this->addForeignKey('translation_id_fk', '{{translation}}', 'id', '{{message}}', 'id');
        }

        /**
         * Migrate: Down
         *
         * @access public
         * @return void
         */
        public function down()
        {
            $this->dropTable('{{translation}}');
            $this->dropTable('{{message}}');
        }

    }
