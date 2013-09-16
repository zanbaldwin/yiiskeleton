<?php

    namespace application\models\db;

    use \Yii;
    use \CException;
    use \application\components\ActiveRecord;
    use \application\components\IP;

    /**
     * This is the model class for table "user".
     *
     * The followings are the available columns in table 'user':
     * @property integer $id
     * @property string $username
     * @property string $password
     * @property string $firstname
     * @property string $nickname
     * @property string $lastname
     * @property double $created
     * @property double $last_login
     * @property string $branch
     * @property integer $active
     *
     * The followings are the available model relations:
     * @property Branch $Branch
     */
    class User extends ActiveRecord
    {

        /**
         * @var string $displayName
         */
        protected $displayName;

        /**
         * @var string $fullName
         */
        protected $fullName;

        /* ------------------ *\
        |  GII AUTOMATED CODE  |
        \* ------------------ */

        /**
         * Table Name
         *
         * @access public
         * @return string
         */
        public function tableName()
        {
            return '{{user}}';
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
                array('username, password, firstname, lastname, created', 'required'),
                array('created, last_login', 'numerical'),
                array('username', 'length', 'max' => 64),
                array('password', 'length', 'max' => 60),
                array('firstname, nickname, lastname', 'length', 'max' => 128),
                array('active', 'boolean'),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array(
                    'id, username, password, firstname, nickname, lastname, created, last_login, active',
                    'safe',
                    'on' => 'search'
                ),
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
			    'failedLogins' => array(self::HAS_MANY, 'FailedLogins', 'user'),
			    'meta' => array(self::HAS_ONE, 'UserMeta', 'user'),
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
                'id'            => Yii::t('application', 'ID'),
                'username'      => Yii::t('application', 'Username'),
                'password'      => Yii::t('application', 'Password'),
                'firstname'     => Yii::t('application', 'Firstname'),
                'nickname'      => Yii::t('application', 'Nickname'),
                'lastname'      => Yii::t('application', 'Lastname'),
                'created'       => Yii::t('application', 'Created'),
                'last_login'    => Yii::t('application', 'Last Login'),
                'active'        => Yii::t('application', 'Active?'),
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
            $criteria->compare('id', $this->id, true);
            $criteria->compare('username', $this->username, true);
            $criteria->compare('password', $this->password, true);
            $criteria->compare('firstname', $this->firstname, true);
            $criteria->compare('nickname', $this->nickname, true);
            $criteria->compare('lastname', $this->lastname, true);
            $criteria->compare('created', $this->created);
            $criteria->compare('last_login', $this->last_login);
            $criteria->compare('active', $this->active);
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

        /* ------------------------- *\
        |  END:   GII AUTOMATED CODE  |
        |  BEGIN: NAMING METHODS      |
        \* ------------------------- */

        /**
         * Display Name
         *
         * @access public
         * @return string
         */
        public function getDisplayName()
        {
            if(!is_null($this->displayName)) {
                return $this->displayName;
            }
            $firstname = is_string($this->nickname) && $this->nickname
                ? ucwords($this->nickname)
                : ucwords($this->firstname);
            $this->displayName = $firstname . ' ' . ucwords(substr($this->lastname, 0, 1));
            return $this->displayName;
        }

        /**
         * Full Name
         *
         * @access public
         * @return string
         */
        public function getFullName()
        {
            if(!is_null($this->fullName)) {
                return $this->fullName;
            }
            $this->fullName = ucwords($this->firstname) . ' ' . ucwords($this->lastname);
            return $this->fullName;
        }

        /* -------------------------------- *\
        |  END:   NAMING METHODS             |
        |  BEGIN: PASSWORD-SPECIFIC METHODS  |
        \* -------------------------------- */

        /**
         * Hash Password
         *
         * A useful function that can be called without creating a new instance of the User model, to transform a
         * string into a password hash.
         *
         * @static
         * @access public
         * @param string
         * @return string
         */
        public static function hashPassword($password)
        {
            $phpass = new \Phpass\Hash;
            return $phpass->hashPassword($password);
        }

        /**
         * Check Password
         *
         * Check that the password supplied to this method equates to the same password hash that is stored in the
         * database for the user identified by the current (this) model instance.
         *
         * @access public
         * @param string $password
         * @return boolean
         */
        public function password($password)
        {
            $phpass = new \Phpass\Hash;
            return $phpass->checkPassword($password, $this->password);
        }

        /**
         * PHP Magic Function: Set
         *
         * Override the method to extend the functionality (hash a password that is set as an attribute before adding it
         * to the model).
         *
         * @access public
         * @param string $name
         * @param mixed $value
         * @return void
         */
        public function __set($property, $value)
        {
            // If an override method exists for a certain property, call it to alter the value before passing it to the
            // model to be saved to the database.
            $method = 'set' . ucwords($property);
            if(method_exists($this, $method)) {
                $value = $this->{$method}($value);
            }
            // Carry on setting it to the model as normal.
            parent::__set($property, $value);
        }

        /**
         * Set: Password
         *
         * @access protected
         * @param string $password
         * @return void
         */
        protected function setPassword($password)
        {
            return self::hashPassword($password);
        }

        /* -------------------------------- *\
        |  END:   PASSWORD-SPECIFIC METHODS  |
        \* -------------------------------- */

    }
