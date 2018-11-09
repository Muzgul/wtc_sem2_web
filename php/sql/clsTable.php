<?php
    require_once "clsConnection.php";
    require_once "clsUser.php";

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
                    $sql = "SELECT * FROM `$tblName` ORDER BY `date_created`";
                    $stmt = null;
                    $this->_addStatus($sql);
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
                $date = time();
                $sql = "INSERT INTO `tblmisc` (`category`, `image`, `usrname`, `value`, `date_created`) VALUES ";
                // $sql .= "('" . $valArr['category'] . "', '" . $valArr['image'] . "' , '" . $valArr['usrname'] . "' , '" . $valArr['value'] . "' , '" . $date . "')";
                $sql .= "(:category, :image , :usrname , :value , :date)";
                $stmt = null;
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['category' => $valArr['category'], 'image' => $valArr['image'], 'usrname' => $valArr['usrname'], 'value' => $valArr['value'], 'date' => $date]);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("Misc [" . $valArr['category'] . "] push error: SQL Exception!");
                    $this->_addStatus($sql);
                    $this->_addStatus($e);
                }
                if ($stmt != null){
                    $this->_addStatus("Misc [" . $valArr['category'] . "] push success!");
                    $usr = new clsUser();
                    $usr->fetchUser($valArr['creator']);
                    $usr->sendNotif( $valArr );
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
                    $sql = "SELECT * FROM `tblmisc` WHERE `$field` = :value ORDER BY `date_created` DESC";
                    $stmt = null;
                    try {
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['value' => $value]);
                    }catch (Exception $e){
                        $stmt = null;
                        $this->_addStatus("Table [$tblName] fetch error: SQL Exception!");
                        $this->_addStatus($e);
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

        public function updateUsername( $old, $new ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $sql = "UPDATE `tblmisc` SET `usrname` = :new WHERE `usrname` = :old";
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['new' => $new, 'old' => $old]);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("User [$old] update error in tblmisc: SQL Exception!");
                    return false;
                }
                $sql = "UPDATE `tblimage` SET `creator` = :new WHERE `creator` = :old";
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['new' => $new, 'old' => $old]);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("User [$old] update error in tblimage: SQL Exception!");
                    return false;
                }
                return true;
            }
        }

        public function getTable(){
            return $this->_table;
        }
    }
?>