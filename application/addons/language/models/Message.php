<?php

    namespace application\models\db;

    use \Yii;
    use \CException;
    use \application\components\ActiveRecord;

    /**
     * This is the model class for table "{{message}}".
     *
     * The followings are the available columns in table '{{message}}':
     * @property integer $id
     * @property string $category
     * @property string $message
     *
     * The followings are the available model relations:
     * @property Translation[] $translations
     */
    class Message extends ActiveRecord
    {

        /**
         * Table Name
         *
         * @access public
         * @return string
         */
        public function tableName()
        {
            return '{{message}}';
        }

        /**
         * Validation Rules
         *
         * @access public
         * @return array
         */
        public function rules()
        {
            return array(
                array('category', 'required'),
                array('category', 'length', 'max' => 32),
                array('message', 'safe'),
                array('id, category, message', 'safe', 'on' => 'search'),
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
            return array(
                'translations' => array(self::HAS_MANY, '\\application\\models\\db\\Translation', 'id'),
            );
        }

        /**
         * Attribute Labels
         *
         * Please note that you should NOT wrap these attribute labels in Yii::t(). This is because the development
         * behaviour MissingMessageBehaviour will generate a fatal infinite recursion loop when it encounters a missing
         * translation.
         *
         * @access public
         * @return array
         */
        public function attributeLabels()
        {
            return array(
                'id'        => Yii::t('application', 'Message ID'),
                'category'  => Yii::t('application', 'Category'),
                'message'   => Yii::t('application', 'Message'),
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
            $criteria = new \CDbCriteria;
            $criteria->compare('id', $this->id);
            $criteria->compare('category', $this->category, true);
            $criteria->compare('message', $this->message, true);
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
    }
