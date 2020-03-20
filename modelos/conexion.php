<?php

class Conexion {

    static public function conectar() {

        /**
         * @param string mysql:host=xxxxxx;dbname=xxxx
         * 
         * @param string UserName
         * 
         * @param string Password
         * 
         * */
        $link = new PDO("mysql:host=localhost;dbname=curso-php", "root", "");

        $link->exec("set names utf8");

        return $link;
    }

}