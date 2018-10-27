<?php
    require_once "clsConnection.php";

    class clsImage extends clsConnection {
        // Properties

        private $_table = "tblimage";
        private $_collection = [];

        // Base methods

        public function __construct(){
            clsConnection::__construct();
            $this->_addStatus("Child object [Image] created.");
        }

        // Additional Functions

        public function fetchCollection( $usrName ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                if (empty($this->_collection)){
                    $sql = "SELECT * FROM `$this->_table` WHERE `creator` = '$usrName'";
                    $stmt = null;
                    try {
                        $stmt = $pdo->query($sql);
                    }catch (Exception $e){
                        $stmt = null;
                        $this->_addStatus("Image [$usrName] fetch error: SQL Exception!");
                    }
                    if ($stmt != null){
                        while ($row = $stmt->fetch())
                            array_push($this->_collection, $row);
                        $this->_addStatus("Image [$usrName] fetch success!");
                    }
                }else
                    $this->_addStatus("Image [$usrName] fetch error: Content already exists!");
            }else
                $this->_addStatus("Image [$usrName] fetch error: No active connection!");
        }

        public function getCollection(){
            return $this->_collection;
        }
    }
?>