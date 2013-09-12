<?php

    namespace application\models\db;

    use \Yii;
    use \CException;
    use \CActiveRecord;

    /**
     * This is the model class for table "{{translation}}".
     *
     * The followings are the available columns in table '{{translation}}':
     * @property integer $id
     * @property string $language
     * @property integer $translation
     *
     * The followings are the available model relations:
     * @property Message $id0
     */
    class Translation extends CActiveRecord
    {

        /**
         * Table Name
         *
         * @access public
         * @return string
         */
        public function tableName()
        {
            return '{{translation}}';
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
                array('id, language, translation', 'required'),
                array('id, translation', 'numerical', 'integerOnly' => true),
                array('language', 'length', 'max' => 16),
                array('id, language, translation', 'safe', 'on' => 'search'),
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
                'ID' => array(self::BELONGS_TO, '\\application\\models\\db\\Message', 'id'),
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
                'id'            => Yii::t('application', 'Translation ID'),
                'language'      => Yii::t('application', 'Language'),
                'translation'   => Yii::t('application', 'Translation'),
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
            $criteria->compare('language', $this->language, true);
            $criteria->compare('translation', $this->translation);
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
