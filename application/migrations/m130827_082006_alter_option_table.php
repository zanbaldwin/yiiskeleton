<?php

    class m130827_082006_alter_option_table extends CDbMigration
    {

        /**
         * Migrate: Up
         *
         * @access public
         * @return void
         */
        public function up()
        {
            $this->addColumn('{{option}}', 'table', 'string NOT NULL COMMENT "The name of the database table (without table prefix) that this option belongs to." AFTER `id`');
        }

        /**
         * Migrate: Down
         *
         * @access public
         * @return void
         */
        public function down()
        {
            $this->dropColumn('{{option}}', 'table');
        }

    }
