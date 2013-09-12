<?php

    class m130829_122928_add_parent_options extends CDbMigration
    {

        /**
         * Migrate: Up
         *
         * @access public
         * @return void
         */
    	public function up()
    	{
            $this->addColumn('{{option}}', 'parent', 'integer AFTER `id`');
            $this->addForeignKey('option_parent_fk', '{{option}}', 'parent', '{{option}}', 'id');
    	}

        /**
         * Migrate: Down
         *
         * @access public
         * @return void
         */
    	public function down()
    	{
    		$this->dropForeignKey('option_parent_fk', '{{option}}');
            $this->dropColumn('{{option}}', 'parent');
    	}

    }
