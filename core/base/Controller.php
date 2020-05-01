<?php


    namespace base;


    use library\Db;
    use models\connection\Friends;
    use models\connection\News;
    use models\DeleteUsers;
    use models\GalleryPhoto;
    use models\NewMessages;
    use models\Tasks;
    use models\User;

    class Controller{
        protected $_data = [];
        protected $_view;
        protected $_viewLayut = 'tb';
        protected $tasks;

        public function __construct() {
            $this->_view = new View();
            $this->_view->setLayout($this->_viewLayut);

            $this->tasks = new Tasks();
            $this->_view->setCss('bootstrap');

            if ($_SESSION['feedback']){
                $this->_data['feedback'] = $_SESSION['feedback'];
                unset($_SESSION['feedback']);
            }
        }


        public static function redirect($redirect){
            header('Location:/'.$redirect);
        }

        public static function come_back(){
            sleep(0.1);header('location:'.$_SERVER['HTTP_REFERER']);
        }









    }