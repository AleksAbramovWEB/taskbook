<?php


    namespace base;


    class View {
          protected $title;
          protected $includes;
          protected $description;
          protected $css = [];
          protected $layout;
          protected $_data = [];
          protected $html = [];
          protected $icon = "/assets/img/anarhia.png";

        public function setLayout($layout){
            $this->_layout = $layout;
        }

        /**
         * @param array $description
         */
        public function setDescription($description)
        {
            $this -> description = $description;
        }

        /**
         * @param array $data
         */
        public function setData(array $data)
        {
            $this -> _data = $data;
        }

        public function render($includes){
            $this->includes = $includes;
            $data = $this->_data;
            self::fileExists("core/views/layout/".$this->_layout.'.php');
            self::fileExists('core/views/includes/'.$this->includes.'.inc.php');

            include "core/views/layout/".$this->_layout.'.php';
        }

        public function setTittle($str){
            $this->title = $str;
        }

        /**
         * @param array $css
         */
        public function setCss($css)
        {
            array_push($this->css, $css );
        }



        public static function fileExists($file){
            if (!file_exists($file)){
                throw new \Exception('фаил: '. $file.' не найден');
            }
            
        }





    }