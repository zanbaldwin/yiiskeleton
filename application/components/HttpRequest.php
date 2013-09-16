<?php

    namespace application\components;

    use \Yii;
    use \CException;

    class HttpRequest extends \CHttpRequest
    {

        protected $segments;

        /**
         * Constructor method
         *
         * @access public
         * @return void
         */
        public function __construct()
        {
            \application\components\EventManager::attach($this);
        }

        /**
         * Determine Application URI Segments
         *
         * @access protected
         * @return void
         */
        protected function determineSegments()
        {
            $segment_string = trim($this->getPathInfo(), '/');
            $segments = $segment_string
                ? explode('/', $segment_string)
                : array();
            array_unshift($segments, null);
            unset($segments[0]);
            $this->segments = $segments;
        }

        /**
         * Get Segments
         *
         * @access public
         * @return array
         */
        public function segments()
        {
            if(!is_array($this->segments)) {
                $this->determineSegments();
            }
            return $this->segments;
        }

        /**
         * Get Segment
         *
         * @access public
         * @param integer $index
         * @param mixed $return
         * @return mixed
         */
        public function segment($index, $return = null)
        {
            // Check that the index provided is a positive integer, or at least a string of a positive integer.
            if(!is_int($index)) {
                if(!is_string($index) || !preg_match('/^[1-9][0-9]*$/', $index)) {
                    return $return;
                }
                $index = (int) $index;
            }
            elseif($index < 1) {
                return $return;
            }
            // If the array of segments has not been determined yet, do so. Apparently this is some super cool
            // functionality they call "lazy loading".
            if(!is_array($this->segments)) {
                $this->determineSegments();
            }
            return isset($this->segments[$index])
                ? $this->segments[$index]
                : $return;
        }

        /**
         * Get: Application Referer
         *
         * Only return the HTTP referrer if the URL came from within the application itself. We are not interested in
         * outside sources.
         *
         * @access public
         * @return string|null
         */
        public function getApplicationReferrer()
        {
            static $return = false;
            if($return === false) {
                // Determine the base URL of this application.
                $base = Yii::app()->getBaseUrl(true);
                // Save the value of the referrer, to prevent calling the magic method getter each time.
                $referrer = $this->urlReferrer;
                // If the referrer of this request was a page belonging to this application, return it. Otherwise return null
                // as if there was no referrer.
                $return = is_string($referrer) && substr($referrer, 0, strlen($base)) === $base
                    ? $referrer
                    : null;
            }
            return $return;
        }

    }
