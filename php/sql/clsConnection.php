<?php
    abstract class clsConnection {
        
        // Properties

        protected $pdo = null;
        protected $status = [];

        // Base methods

        protected function __construct (){
            array_push($this->status, "Object created.");
            $this->pdo = $this->connect();
        }

        public function __toString(){
            $export = "";
            foreach ($this->status as $key => $value) {
                $export .= "[$key] => $value" . PHP_EOL;
            }
            return $export;
        }

        public function __toHTML(){
            $export = "";
            foreach ($this->status as $key => $value) {
                $export .= "[$key] => $value" . "<br/>";
            }
            return $export;
        }

        // Extended methods

        protected function _getPDO(){
            return $this->pdo;
        }

        protected function _addStatus($message){
            array_push($this->status, $message);
        }
        
        public function connect(){
            $host = "localhost";
            $db = "testdb";
            $user = "root";
            $pass = "cullygme";
            $charset = "utf8";

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            try {
                $pdo = new PDO($dsn, $user, $pass, $options);
                array_push($this->status, "PDO connection success!");
            } catch(\PDOException $e){
                $pdo = $e;
                array_push($this->message, $e);
            }
            return $pdo;
        }
    }
?>