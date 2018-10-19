<?php
    require_once "clsConnection.php";

    class clsUser extends clsConnection {

        // Properties

        private $_table = "tblUsers";
        private $_user = [];

        // Base methods

        public function __construct(){
            clsConnection::__construct();
            $this->_addStatus("Child object [User] created.");
        }
    
        //Extended methods

        public function fetchUser( $usrName ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                if (empty($this->_user)){
                    $sql = "SELECT * FROM `$this->_table` WHERE `usrname` = $usrName";
                    $stmt = null;
                    try {
                        $stmt = $pdo->query($sql);
                    }catch (Exception $e){
                        $stmt = null;
                        $this->_addStatus("User [$usrName] fetch error: SQL Exception!");
                    }
                    if ($stmt != null){
                        while ($row = $stmt->fetch())
                            array_push($this->_table, $row);
                        $this->_addStatus("User [$usrName] fetch success!");
                    }
                }else
                    $this->_addStatus("User [$usrName] fetch error: Content already exists!");
            }else
                $this->_addStatus("User [$usrName] fetch error: No active connection!");
        }

        public function pushUser( $valArr ){
            $this->_addStatus("Creating new user...");
        }
    }
?>