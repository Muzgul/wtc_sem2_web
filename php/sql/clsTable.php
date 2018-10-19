<?php
    require_once "clsConnection.php";

    class clsTable extends clsConnection {
        
        // Properties
        
        private $_table = [];

        // Base methods

        public function __construct(){
            clsConnection::__construct();
            $this->_addStatus("Child object [Table] created.");
        }

        // Extended methods

        public function fetchTable( $tblName ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                if (empty($this->_table)){
                    $sql = "SELECT * FROM `$tblName`";
                    $stmt = null;
                    try {
                        $stmt = $pdo->query($sql);
                    }catch (Exception $e){
                        $stmt = null;
                        $this->_addStatus("Table [$tblName] fetch error: SQL Exception!");
                    }
                    if ($stmt != null){
                        while ($row = $stmt->fetch())
                            array_push($this->_table, $row);
                        $this->_addStatus("Table [$tblName] fetch success!");
                    }
                }else
                    $this->_addStatus("Table [$tblName] fetch error: Content already exists!");
            }else
                $this->_addStatus("Table [$tblName] fetch error: No active connection!");
        }


    }
?>