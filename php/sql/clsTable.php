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

        public function pushMisc($valArr){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $sql = "INSERT INTO `tblmisc` (`category`, `image`, `usrname`, `value`) VALUES ";
                $sql .= "('" . $valArr['category'] . "', '" . $valArr['image'] . "' , '" . $valArr['usrname'] . "' , '" . $valArr['value'] . "')";
                $stmt = null;
                try {
                    $stmt = $pdo->query($sql);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("Misc [" . $valArr['category'] . "] push error: SQL Exception!");
                    $this->_addStatus($sql);
                    $this->_addStatus($e);
                }
                if ($stmt != null){
                    $this->_addStatus("Misc [" . $valArr['category'] . "] push success!");
                    return true;
                }
            }else
                $this->_addStatus("Misc [" . $valArr['category'] . "] push error: No active connection!");
            return false;
        }

        public function fetchMisc( $field, $value ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                if (empty($this->_table)){
                    $sql = "SELECT * FROM `tblmisc` WHERE `$field` = '$value'";
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

        public function getTable(){
            return $this->_table;
        }
    }
?>