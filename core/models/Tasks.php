<?php


    namespace models;


    use library\Db;
    use library\Filter;

    class Tasks
    {

        public function selectTacks($view, $order, $desc, $col){
            if (is_null($desc)) $desc = 'ASC';
            else $desc = 'DESC';
            $view = Filter::sanINT($view);
            $col = Filter::sanINT($col);
            $order = Filter::sanSTR($order);
            $column = ['email', 'name', 'status'];
            if(!in_array($order,  $column)) $order = 'id';
            return   Db::getDB()->queryAll("
            SELECT * FROM `tasks` ORDER BY `$order` $desc LIMIT $view , $col");
        }

        public function updateById($id, $array){
            if(!$_SESSION['admin']) return;
            $id = Filter::sanINT($id);
            $array['status_admin'] = 1;
            Db::getDB()->update('tasks', "`id` = '$id'", $array);
        }

        public function selectById($id){
            return Db::getDB()->queryOne("SELECT * FROM `tasks` WHERE `id` = ?", [Filter::sanINT($id)]);
        }

        public function tacksExist($id){
            return (boolean) Db::getDB()->queryFetchColumn("SELECT COUNT(*) FROM `tasks` WHERE `id` = ?", [Filter::sanINT($id)]);
        }

        public function setStatus($id){
            if(!$_SESSION['admin']) return;
            Db::getDB()->queryBool("UPDATE `tasks` SET `status` = '1' WHERE `id` = ?", [Filter::sanINT($id)]);
        }

        public function countTacks(){
            return Db::getDB()->queryFetchColumn( "SELECT COUNT(*) FROM `tasks`");
        }

        public function createTacks($data){
            Db::getDB()->insert('tasks', $data);
        }

        public function seeder($name, $email, $sum){
           for ($i=0; $i <= $sum; $i++) {
              Db::getDB()->insert('tasks', [
                  'email' => $email."@mail.ru",
                  'name' => $name,
                  'text' => $this->random_str(30)
              ]);
           }
        }

        private function random_str($count) {
            $keySpace = ' 01 23456 789ab cd efghijklm nopq rstuv wxyzABCD EFGHIJK LMNOPQ RSTUV WXYZ_';
            $pieces = [];
            $max = mb_strlen($keySpace, '8bit') - 1;
            for ($i = 0; $i < $count; ++$i)
                $pieces []= $keySpace[random_int(0, $max)];
            return implode('', $pieces);
         }

    }