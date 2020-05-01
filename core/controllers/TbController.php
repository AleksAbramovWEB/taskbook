<?php


    namespace controllers;


    use base\Controller;
    use library\Filter;
    use library\Validator;

    use models\Tasks;


    class TbController extends Controller
    {



        public function actionIndex()
        {
            $this->_data['tasks'] = $this->tasks->selectTacks($_GET['view'], $_GET['order'], $_GET['desc'] , 3);
            $this->_data['count'] = $this->tasks->countTacks();
            $this->_data['desc'] = ($_GET['desc'])? "&view=".$_GET['view'] :"&desc=yes&view=".$_GET['view'];
            $this->_view->setData($this->_data);
            $this -> _view -> render('index');
        }

        public function actionAuto(){
            if($_SESSION['admin']) self::redirect('admin/list');
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($_POST['name'] == 'admin1' AND $_POST['password'] == '321'){
                    $_SESSION['admin'] = true;
                    self::redirect('admin/list');
                }else{
                    if ($_POST['name'] !== 'admin1') $this->_data['error']['name'] = 'не верное имя пользователя';
                    if ($_POST['password'] !== '321') $this->_data['error']['password'] = 'не верный пароль';
                }
            }
            $this->_view->setData($this->_data);
            $this -> _view -> render('auto');
        }


        public function actionCreate(){
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') self::come_back();
            $valid = new Validator([
                'email' => Filter::sanSTR($_POST["email"]),
                'name' => Filter::sanSTR($_POST["name"]),
                'text' => Filter::sanSTR($_POST["task"])
            ],[
                'email' => ['required', 'email'],
                'name' => ['required', 'strMin3', 'strMax40'],
                'text' => ['required', 'strMin5', 'strMax700']
            ]);

            if ($valid->getError()){
                $_SESSION['feedback']['error'] = $valid->getError();
                $_SESSION['feedback']['data'] = $valid->getData();
            }else{
                $this->tasks->createTacks($valid->getData());
                $_SESSION['feedback']['create'] = 'успешно сохранено';
            }
            self::redirect('');
        }




    }
