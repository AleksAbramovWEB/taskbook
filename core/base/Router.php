<?php


    namespace base;


    use library\SxGeo;
    use library\Url;
    use models\administration\AntiHacking;

    class Router
    {
        private $routes;

        public function __construct()
        {
            $this->routes = require_once "core/configs/routes.conf.php";
        }

        private function getURL()
        {
            if (!empty($_SERVER['REQUEST_URI'])) return trim($_GET['url']);
        }




        public function run()
        {
            $url = $this -> getURL();
            foreach ($this -> routes as $urlPattern => $route) {
                if (preg_match("~$urlPattern~", $url, $matches, PREG_UNMATCHED_AS_NULL )) {
                    // получаем внутренний путь
                    $internalRoute = preg_filter ("~$urlPattern~", $route, $matches[0]);
                    $segments = explode('/', $internalRoute);
                    $controllerName = '\controllers\\' . ucfirst(array_shift($segments) . 'Controller');
                    $actionName = 'action' . ucfirst(array_shift($segments));
                    // проверка на существование
             //       if(!file_exists('core'.$controllerName.'.php')) throw new \exceptions\Exception500('контроллер core/'.$controllerName.'.php не найден');
                    $controllerObj = new $controllerName();
                    if(method_exists($controllerObj, $actionName)) {
                        call_user_func_array(array($controllerObj, $actionName), $segments);
                        break;
                    }else{
                        throw new \Exception('метод '.$actionName.' контроллера core/'.$controllerName.'.php не существует');
                    }
                }
            }
        }




    }