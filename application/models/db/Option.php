<?php

    namespace application\models\db;

    use \Yii;
    use \CException;
    use \application\components\ActiveRecord;

    /**
     * This is the model class for table "{{option}}".
     *
     * The followings are the available columns in table '{{option}}':
     * @property integer $id
     * @property string $table
     * @property string $column
     * @property string $data
     * @property string $name
     * @property integer $organisation
     * @property integer $branch
     *
     * The followings are the available model relations:
     * @property Customer[] $customers
     * @property Branch $branch0
     * @property Organisation $organisation0
     * @property Vehicle[] $vehicles
     * @property Vehicle[] $vehicles1
     */
    class Option extends ActiveRecord
    {

        /**
         * Table Name
         *
         * @access public
         * @return string
         */
    	public function tableName()
    	{
    		return '{{option}}';
    	}

        /**
         * Validation Rules
         *
         * @access public
         * @return array
         */
    	public function rules()
    	{
    		// NOTE: you should only define rules for those attributes that
    		// will receive user inputs.
    		return array(
    			array('table, column', 'required'),
    			array('table, column', 'length', 'max' => 255),
    			array('data, name', 'safe'),
    			// The following rule is used by search().
    			// @todo Please remove those attributes that should not be searched.
    			array('id, table, column, data, name', 'safe', 'on' => 'search'),
    		);
    	}

        /**
         * Table Relations
         *
         * @access public
         * @return array
         */
    	public function relations()
    	{
    		// NOTE: you may need to adjust the relation name and the related
    		// class name for the relations automatically generated below.
    		return array();
    	}

        /**
         * Attribute Labels
         *
         * @access public
         * @return array
         */
    	public function attributeLabels()
    	{
    		return array(
    			'id'     => Yii::t('application', 'Option ID'),
    			'table'  => Yii::t('application', 'Table'),
    			'column' => Yii::t('application', 'Column'),
    			'data'   => Yii::t('application', 'Data'),
    			'name'   => Yii::t('application', 'Name'),
    		);
    	}

        /**
         * Search
         *
         * Retrieves a list of models based on the current search/filter conditions. A typical usecase involves:
         * - Initialize the model fields with values from filter form.
         * - Execute this method to get CActiveDataProvider instance which will filter models according to data in
         *   model fields.
         * - Pass data provider to CGridView, CListView or any similar widget.
         *
         * @access public
         * @return CActiveDataProvider
         */
    	public function search()
    	{
    		// @todo Please modify the following code to remove attributes that should not be searched.

    		$criteria = new \CDbCriteria;
    		$criteria->compare('id', $this->id);
    		$criteria->compare('table', $this->table, true);
    		$criteria->compare('column', $this->column, true);
    		$criteria->compare('data', $this->data, true);
    		$criteria->compare('name', $this->name, true);
    		$criteria->compare('organisation', $this->organisation);
    		$criteria->compare('branch', $this->branch);
    		return new \CActiveDataProvider($this, array(
    			'criteria' => $criteria,
    		));
    	}

        /**
         * Model Instance
         *
         * Returns a static model of the specified ActiveRecord class. This exact method should be in all classes that
         * extend CActiveRecord.
         *
         * @access public
         * @param string $class_name
         * @return User
         */
    	public static function model($class_name = __CLASS__)
    	{
    		return parent::model($class_name);
    	}

        /**
         * Item Models
         *
         * Return an array of Option models that belong to the table and column specified.
         *
         * @static
         * @access public
         * @param string $tableColumns
         * @return Option[]
         */
        public static function models($tableColumns)
        {
            if(is_string($tableColumns)) {
                $tableColumns = preg_split('/\\s*\\.\\s*/', $tableColumns, -1, PREG_SPLIT_NO_EMPTY);
            }
            if(
                !is_array($tableColumns)
             || !isset($tableColumns[0]) || !is_string($tableColumns[0])
             || !isset($tableColumns[1]) || !is_string($tableColumns[1])
            ) {
                throw new CException(
                    Yii::t(
                        'application',
                        'Invalid parameter passed to models() method of Option active record model. Please supply an array of table and column names, or a string containing the table and column concatenated with a full-stop.'
                    )
                );
            }

            $query = Yii::app()->db->createCommand();
            $query->from = self::model()->tableName();
            $query->where(array('AND',
                Yii::app()->db->quoteColumnName('table') . ' = :table',
                Yii::app()->db->quoteColumnName('column') . ' = :column',
                array('OR',
                    Yii::app()->db->quoteColumnName('organisation') . ' = :organisation',
                    Yii::app()->db->quoteColumnName('organisation') . ' IS NULL',
                ),
                array('OR',
                    Yii::app()->db->quoteColumnName('branch') . ' = :branch',
                    Yii::app()->db->quoteColumnName('branch') . ' IS NULL',
                ),
            ));
            return self::model()->findAllBySql($query->text, array(
                ':table' => $tableColumns[0],
                ':column' => $tableColumns[1],
                ':organisation' => Yii::app()->user->organisation,
                ':branch' => Yii::app()->user->branch,
            ));
        }

        /**
         * Dropdown List Items
         *
         * @static
         * @access public
         * @param string $tableColumns
         * @param boolean $showParents
         * @return array
         */
        public static function items($tableColumns, $showParents = true)
        {
            // Fetch all the options from the database.
            $models = self::models($tableColumns);
            // And define a couple of arrays to hold the option IDs in.
            $parents = $items = array();
            // Iterate over the items returned, sorting them into individual options, or children of an option group.
            foreach($models as $model) {
                // Does the item have a parent, and if so, does the user want the items sorted by parent?
                if(!is_null($model->parent) && $showParents) {
                    // To prevent PHP notices, we'll make sure that the variable we are setting items to is an array
                    // that exists.
                    if(!isset($parents[$model->parent]) || !is_array($parents[$model->parent])) {
                        $parents[$model->parent] = array();
                    }
                    // Store it in another array for now while we determine all the parent IDs.
                    $parents[$model->parent][$model->id] = Yii::t('message', $model->name);
                }
                // The item does not have a parent, add it to the items list on its own.
                else {
                    $items[$model->id] = Yii::t('message', $model->name);
                }
            }
            // Do any of the items have parents?
            if(count($parents) > 0) {
                // Grab all the IDs of the parent items.
                $parent_ids = array_keys($parents);
                // So we can load all of them from the database, and into a model, in one transaction.
                $parent_models = self::model()->findAllBySql(
                    'SELECT * FROM {{option}} WHERE `id` IN ('.implode(',', $parent_ids).');'
                );
                // Now, loop through all the parents from the database to assign their names as the option group
                // heading, and then merge with the rest of the items.
                foreach($parent_models as $parent) {
                    $items[Yii::t('message', $parent->name)] = $parents[$parent->id];
                }
            }
            return $items;
        }

    }
