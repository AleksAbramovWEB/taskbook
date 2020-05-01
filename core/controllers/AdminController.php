<?php


    namespace controllers;


    use base\Controller;
    use library\Filter;
    use library\Validator;

    class AdminController extends Controller
    {

        public function __construct()
        {
            parent::__construct();
            if (!$_SESSION['admin']){
                self::redirect('auto');
            }

        }

        public function actionList(){
            $this->_data['tasks'] = $this->tasks->selectTacks($_GET['view'], $_GET['order'], $_GET['desc'], 10);
            $this->_data['count'] = $this->tasks->countTacks();
            $this->_data['desc'] = ($_GET['desc'])? "&view=".$_GET['view'] :"&desc=yes&view=".$_GET['view'];
            $this->_view->setData($this->_data);
            $this -> _view -> render('list');
        }


        public function actionShow($id){
            if (!$this->tasks->tacksExist($id)) self::redirect('');
            if ($this->_data['feedback']['error']){
                    $this->_data['tasks'] = $this->_data['feedback']['data'];
                    $this->_data['tasks']['id'] = $id;
            }else   $this->_data['tasks'] = $this->tasks->selectById($id);

            $this->_view->setData($this->_data);
            $this -> _view -> render('update');
        }

        public function actionUpdate($id){
            if ($this->tasks->tacksExist($id) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
                $valid = new Validator([
                    'email' => Filter::sanSTR($_POST["email"]),
                    'name' => Filter::sanSTR($_POST["name"]),
                    'text' => Filter::sanSTR($_POST["text"])
                ],[
                    'email' => ['required', 'email'],
                    'name' => ['required', 'strMin3', 'strMax40'],
                    'text' => ['required', 'strMin5', 'strMax700']
                ]);
                if ($valid->getError()){
                    $_SESSION['feedback']['error'] = $valid->getError();
                    $_SESSION['feedback']['data'] = $valid->getData();
                }else{
                    $this->tasks->updateById($id, $valid->getData());
                    $_SESSION['feedback']['update'] = 'успешно сохранено';
                }
            }
            self::come_back();
        }

        public function actionPerformed($id){
            if ($this->tasks->tacksExist($id)) $this->tasks->setStatus($id);
            self::come_back();
        }

        public function actionExit(){
            unset($_SESSION['admin']);
            self::come_back();
        }

    }