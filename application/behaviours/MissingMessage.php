<?php

    namespace application\behaviours;

    use \Yii;
    use \CException;
    use \application\models\db\Message;
    use \application\models\db\Translation;

    class MissingMessage extends \CBehavior
    {

        /**
         * @var CDbConnection $db
         */
        protected $db;

        /**
         * Behaviour Events
         *
         * @access public
         * @return void
         */
        public function events()
        {
            return array(
                'onMissingTranslation' => 'saveMessage',
            );
        }

        /**
         * Save Message
         *
         * @access public
         * @return void
         */
        public function saveMessage($event)
        {
            // If we are in production mode, then do not run this method. It is slow and produces upto an unnecessary
            // two database requests per missing message.
            if(defined('PRODUCTION') && PRODUCTION) {
                return;
            }
            // Grab the database connection that the message component uses, rather than just "Yii::app()->db", as they
            // may be different.
            $this->db = $event->sender->getDbConnection();
            // Load the message.
            $source = Message::model()->find(
                $this->db->quoteColumnName('message') . ' = :message AND '
              . $this->db->quoteColumnName('category') . ' = :category',
                array(
                    ':message' => $event->message,
                    ':category' => $event->category,
                )
            );
            // If we didn't find the message, then we need to add it.
            if(!$source) {
                $model = new Message;
                $model->category = $event->category;
                $model->message = $event->message;
                $model->save();
            }
            // We now have the message in the database, don't bother with creating an entry for the translation and we
            // have no idea what the translation would be. Would could go into the Google Translate API, but that's not
            // something we want running on every page load - more of a CRON job or admin task to be honest.
        }

    }
