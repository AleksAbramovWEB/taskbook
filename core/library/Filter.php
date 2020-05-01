<?php


    namespace library;


    class Filter
    {
        public static function sanSTR($string){
            $string = filter_var(trim($string),FILTER_SANITIZE_STRING);
            $string = strip_tags($string);
            $string = nl2br($string);
            return $string;
        }

        public static function sanOnlyLetters($string) {
            return preg_replace("/[^\p{L}]/u","", $string);
        }


        public static  function sanINT($int){
            return (int)filter_var(($int), FILTER_SANITIZE_NUMBER_INT);
        }

        public static function br_on_rn($string){
            return str_replace(["<br />", "<br/>"],"\r\n", $string);
        }



    }