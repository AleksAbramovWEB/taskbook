<?php
/*
 * rules:
 * required - обязательное поле
 * email - проверка мыла регулярным выражением
 * emailDB - роверка мыла на существование в дб
 * pass - валидация паполя
 * identPass - роверка на совпадение паролей
 * strMin??? - минимальное количество символов ??? означает цифры
 * strMax??? - максимальное количество символов ??? означает цифры
 *
 */

    namespace library;




    class Validator
    {
        protected $_data;
        protected $_rules;
        protected $_error = null;
        protected $_stringCount = null;
        protected $_identical1 = null;
        protected $_identical2 = null;



        public function __construct($data, $rules){
            if (!is_array($data) || !is_array($rules)){
                throw new \Exception("пердоваемый аргумет в класс Validator не является массивом", 4);
            }
            $this->_data = $data;
            $this->_rules = $rules;
            $this->validation();
        }

        /**
         * @return null
         * @return array
         */
        public function getError(){
            return $this -> _error;
        }

        /**
         * @return array
         */
        public function getData()
        {
            return $this -> _data;
        }



        public function strlenSet($ruleName) {

            $nameStr = Filter::sanOnlyLetters($ruleName);
            if($nameStr == 'strMin' || $nameStr == 'strMax'){
                $this->_stringCount = Filter::sanINT($ruleName);
                return $nameStr;
            }
            return $ruleName;
        }



        protected function validation(){
            $errorForms = [];
            $fields = array_keys($this->_rules);
            foreach ($fields as $fieldName) {
                $fieldData = $this->_data[$fieldName];
                $rules = $this->_rules[$fieldName];
                foreach ($rules as $ruleName) {
                    $ruleName = $this->strlenSet($ruleName);
                    if(!method_exists($this, $ruleName)){
                        throw new \Exception('несуществующий метод '.$ruleName.' передан в валидатор', 4);
                    }
                    $error = $this->$ruleName($fieldData);
                    if(!is_null($error)){
                        if (empty($errorForms[$fieldName])) {
                            $errorForms[$fieldName] = $error;
                        }
                    }
                }
            }
            if (!empty($errorForms)){
                $this -> _error = $errorForms;
            }

        }

        protected function identPass($fieldData){
            if(!is_null($this->_identical1) && !is_null($this->_identical2)){
                $this->_identical1 = null;
                $this->_identical2 = null;
            }
            if (is_null($this->_identical1)) {
                $this->_identical1 = $fieldData;
                return;
            }
            if (is_null($this->_identical2)) {
                $this->_identical2 = $fieldData;
                if ($this->_identical1 !== $this->_identical2) return "пароли не совпарют!";
            }
        }

        protected function required($fieldData){
            if ($fieldData == "" || strlen($fieldData)==0 || trim($fieldData) == '') {
                return "поле обязательное для заполнения!";
            }
        }

        protected function requiredSelect($fieldData)
        {
            if ($fieldData == "" || strlen($fieldData) == 0 || trim($fieldData) == '' || $fieldData == '0') {
                 return  "не выбрано не одного поля!";

            }
        }

        protected function email($email){
            if (!preg_match("/([a-z0-9_A-Z-]+\.)*[a-z0-9_A-Z-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}/", $email)
            AND mb_strlen($email) <= 50) {
               return "введите коректный email!";

            }
        }


        protected function strMin($fieldData){
            if (mb_strlen($fieldData) < $this->_stringCount) {
                    return "Содержимое должно быть не менее ".$this->_stringCount." символов!";
            }
        }

        protected function strMax($fieldData){
            if (mb_strlen($fieldData) > $this->_stringCount) {
                    return "Содержимое должно быть не более ".$this->_stringCount." символов!";
            }
        }

        protected function pass($fieldData){
            if (!preg_match("/((?=\S*[a-z])|(?=\S*[а-я]))((?=\S*[A-Z])|(?=\S*[А-Я]))(?=\S*[\d])/", $fieldData)) {
                return "Ваш пароль очень простой, используйте цифры, строчные и прописные буквы!";
            }elseif (mb_strlen($fieldData)<6) {
                return "пароль должен содержать не менее 6ти символов!";

            }elseif (mb_strlen($fieldData)>50) {
               return "пароль должен содержать не более 50 символов!";
            }
        }






    }