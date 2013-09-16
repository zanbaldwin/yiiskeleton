<?php

    namespace application\models\db;

    use \Yii;
    use \CException;
    use \application\components\ActiveRecord;

    /**
     * This is the model class for table "failed_logins".
     *
     * The followings are the available columns in table "failed_logins":
     * @property string $user
     * @property double $timestamp
     * @property string $password
     * @property string $ip
     * @property integer $attempts
     *
     * The followings are the available model relations:
     * @property User $User
     */
    class FailedLogin extends ActiveRecord
    {


        /**
         * Table Name
         *
         * @access public
         * @return string
         */
        public function tableName()
        {
            return '{{failed_logins}}';
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
                array('user, timestamp, password, ip', 'required'),
                array('user, attempts', 'numerical', 'integerOnly' => true),
                array('timestamp', 'numerical'),
                array('password', 'length', 'max' => 40),
                array('ip', 'length', 'max' => 45),
                array('user, timestamp, password, ip, attempts', 'safe', 'on' => 'search'),
            );
        }


        /**
         * Relations
         *
         * @access public
         * @return array
         */
        public function relations()
        {
            return array(
                'User' => array(self::BELONGS_TO, '\\application\\model\\db\\User', 'user'),
            );
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
                'user'      => Yii::t('application', 'User ID'),
                'timestamp' => Yii::t('application', 'Timestamp'),
                'password'  => Yii::t('application', 'Password'),
                'ip'        => Yii::t('application', 'IP Address'),
                'attempts'  => Yii::t('application', 'Premature Attempts'),
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
            $criteria->compare('user',      $this->user,        true);
            $criteria->compare('timestamp', $this->timestamp);
            $criteria->compare('password',  $this->password,    true);
            $criteria->compare('ip',        $this->ip,          true);
            $criteria->compare('attempts',  $this->attempts);
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
         * @return FailedLogin
         */
        public static function model($class_name = __CLASS__)
        {
            return parent::model($class_name);
        }

    }
