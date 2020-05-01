<?php


  /*
   * тразакции
      $dbh->beginTransaction();
         $dbh->exec("insert into staff (id, first, last) values (23, 'Joe', 'Bloggs')");
         $dbh->exec("insert into salarychange (id, amount, changedate)  values (23, 50000, NOW())");
      $dbh->commit();
   * константы получения данных
   * \PDO::FETCH_NUM  - возращает пронумерованный массив
   * \PDO::FETCH_ASSOC - возращает ассоцоативный массив
   * \PDO::FETCH_BOTH - возращает ассоциативный и нумерованный массив одновременно
   * \PDO::FETCH_OBJ - возвращает обьект
   *
   *
   */

    namespace library;


    use exceptions\Exception500;
    use exceptions\ExceptionDB;

    class Db
    {
        private static $db = null;
        private $pdo;
        private $config;


        public function __construct(){
            if (!file_exists('core/configs/db.conf.php'))  throw new Exception("___fail config Db not found!");
            $this->config = require_once 'core/configs/db.conf.php';
            $this->pdo = new \PDO(
        "mysql:host={$this->config['host']};
            dbname={$this->config['db_name']};
            charset={$this->config['charset']}",
                    $this->config['user'],
                    $this->config['password'],
                    array(
                        // создание постоянного соединения
//                \PDO::ATTR_PERSISTENT => true,
                        // ошибки вызывают исключения
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                    ));

                //pgsql, sqlite, odbc






        }

        public static function getDB() {
            if (is_null(self::$db)) self::$db = new Db();
            return self::$db;
        }

        public function queryOne($sql, $param = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $arr = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(is_array($arr)) return $arr;
        }

        public function queryAll($sql, $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $arr = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(is_array($arr)) return $arr;
        }

        public function queryFetchColumn($sql, $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            $str = $stmt->fetchColumn();
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            if(!is_null($str)) return $str;
        }

        public function queryBool($sql, $param  = []){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            return $stmt;
        }

        public function insert($table, array $data = []){
            $data = array_filter($data);
            $table = Filter::sanSTR($table);
            foreach ($data as $key => $datum) {
                 $column[] = $key;
                 $value[] = ":".$key;
                 $dataNew[':'.$key] = $datum;
            }
            $sql = "INSERT INTO `$table` (".implode(',', $column).") VALUES (".implode(',', $value).")";
//            echo $sql;
//            var_dump($dataNew);
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute($dataNew);
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            return $res;
        }

        public function update($table, $where, array $data = []){
            $data = array_filter($data);
            $table = Filter::sanSTR($table);
            foreach ($data as $key => $datum) {
                $dataUp[] = "$key = :$key";
                $dataNew[':'.$key] = $datum;
            }
            $sql = "UPDATE `$table` SET ".implode(',', $dataUp)." WHERE $where";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute($dataNew);
            if (!is_null($stmt->errorInfo()[2])) throw new \PDOException($stmt->errorInfo()[0].','.$stmt->errorInfo()[1].','.$stmt->errorInfo()[2]);
            return $res;
        }

        public function lastInsertId(){
            return $this->pdo->lastInsertId();
        }


        private function select_while($sql, $param  = [], $function){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            while ($arr = $stmt->fetсh(\PDO::FETCH_ASSOC)){
              $array[] =  $function($arr);
            }
            return $array;
        }










        // перебрать все строки результируещего набора
//            while ($rov = $result->fetсh(\PDO::FETCH_ASSOC)){
//                echo "кино: ". $rov['name'];
//            }
            // получить двухмерный массив
//            $rov = $result->fetсhAll(\PDO::FETCH_ASSOC);

            // именнованные плейсхолдары
//            $sql = "SELECT * FROM users WHERE id = :id";
//            $stmt = $this->pdo->prepare($sql);
//            $params = [':id'=> '12'];
//            $stmt->execute($params);
//            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
//            // позиционные плейсхолдары
//            $sql = "SELECT * FROM users WHERE id = ?";
//            $stmt = $this->pdo->prepare($sql);
//            $params = ['12'];
//            $stmt->execute($params);
//            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);



//        protected function antiInjection ($str){
//            return  $this->mysqli->real_escape_string($str);
//        }
//
//
//
//        protected function mysqliQuery($sql) {
//            $result = $this->mysqli->query($sql);
//            if (!$result) {
//              throw new ExceptionDB('<br>ошибка запроса: '.$sql.'<br> инфо: '.$this->mysqli->error);
//            }
//         return $result;
//        }
//
//        /**
//         * возрат всех строк таблицы
//         * @param $table
//         * @return array MYSQLI_ASSOC
//         * @throws ExceptionDB
//         */
//        public function selectDataFetchAll($table){
//           $table = $this->antiInjection($table);
//           $sql = "SELECT * FROM `$table`";
//           $result = $this->mysqliQuery($sql);
//           return $this->fetch_all($result);
//        }
//
//        public function selectDataTwoFetchAll($table, $column1, $val1, $operator = NULL, $column2= NULL, $val2 = NULL){
//              $args = func_get_args();
//              $sql = $this->argsValid($args, 'selectDataTwoFetchAll');
//              $result = $this->mysqliQuery($sql);
//              return $this->fetch_all($result);
//        }
//
//        public function selectDataTwoFetchAssos($table, $column1, $val1, $operator = NULL, $column2= NULL, $val2 = NULL){
//            $args = func_get_args();
//            $sql = $this->argsValid($args, 'selectDataTwoFetchAssos');
//            $result = $this->mysqliQuery($sql);
//            return $this->fetch_assoc($result);
//        }
//
//        public function selectCount($table, $column1, $val1, $operator = NULL, $column2= NULL, $val2 = NULL){
//            $args = func_get_args();
//            $sql = $this->argsValid($args, 'selectCount', 'COUNT(*)' );
//            $result = $this->mysqliQuery($sql);
//            if ($result->num_rows> 0) {
//                $count= $result->fetch_assoc();
//                return (int)$count['COUNT(*)'];
//            }
//        }
//
//        public function insert($table ,array $data = []){
//            $data = array_filter($data);
//            $table = $this->antiInjection($table);
//            foreach ($data as $key => $val) {
//                $column[] = " `".$this->antiInjection($key)."`";
//                $value[] = " '".$this->antiInjection($val)."'";
//            }
//            $sql = "INSERT INTO `$table` (".implode(',', $column).") VALUES (".implode(',', $value).")";
//            return $this->mysqliQuery($sql);
//        }
//
//        public function updateData ($table, $columnUp, $valUp, $column1, $val1, $column2= NULL, $val2 = NULL){
//            $args = array_filter(func_get_args());
//            foreach ($args as $key => $arg) $args[$key] = $this->antiInjection($arg);
//            $sql2 =  (count($args)== 7) ? "AND `{$args[0]}`.`{$args[5]}` = '{$args[6]}'":"";
//            $sql = "UPDATE `{$args[0]}` SET `{$args[1]}` = '{$args[2]}' WHERE `{$args[0]}`.`{$args[3]}` = '{$args[4]}' ".$sql2;
//            return $this->mysqliQuery($sql);
//        }
//
//
//
//
//
//         // служебные
//        private function argsValid($args, $string, $count = '*'){
//            foreach ($args as $key => $value){
//                if($key == 3 && is_null($value))  break;
//                $argsValid[$key] = $this->antiInjection($value);
//            }
//            if(count($argsValid) == 3){
//                return " SELECT $count FROM `{$argsValid[0]}` WHERE `{$argsValid[1]}` = '{$argsValid[2]}' ";
//            }elseif (count($argsValid) == 5){
//                return " SELECT $count FROM `{$argsValid[0]}` WHERE `{$argsValid[1]}` = '{$argsValid[2]}' {$argsValid[3]} `{$argsValid[4]}` = '{$argsValid[5]}' ";
//            }else {
//                throw new ExceptionDB('неверное количество аргументов определено в методе '.$string);
//            }
//        }
//
//        private function fetch_all($result){
//            if ($result->num_rows> 0) {
//                return  $result->fetch_all(MYSQLI_ASSOC);
//            }
//        }
//
//        private function fetch_assoc($result){
//            if ($result->num_rows> 0) {
//                return $result->fetch_assoc();
//            }
//        }
//
//
//        public function __destruct(){
//             $this->mysqli->close();
//          }

    }