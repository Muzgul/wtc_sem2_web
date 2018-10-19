<?php
    require_once "clsConnection.php";

    class clsDatabase extends clsConnection {
        // Properties

        // Base methods

        public function __construct(){
            clsConnection::__construct();
            $this->_addStatus("Child object [Database] created.");
        }

        // Extended methods

        public function createTables(){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $root = $_SERVER['DOCUMENT_ROOT'];
                $content = file_get_contents($root . "/setup/tables.csv");
                $tables = preg_split('/\n/', $content);
                foreach ($tables as $num => $table) {
                    $pos = strpos($table, ',');
                    $name = trim(substr($table, 0, $pos));
                    $cols = trim(substr($table, $pos + 1));
                    $sql = "CREATE TABLE " . $name . " ( " . $cols . " );";
                    $this->_addStatus($sql);
                    $stmt = null;
                    try {
                        $stmt = $pdo->query($sql);
                    }catch (Exception $e){
                        $stmt = null;
                        $this->_addStatus("Table [$name] push error: SQL Exception!");
                    }
                }

            }else
                $this->_addStatus("PDO Error!");
        }

        public function dropTables( $tblName = null ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $root = $_SERVER['DOCUMENT_ROOT'];
                $content = file_get_contents($root . "/setup/tables.csv");
                $tables = preg_split('/\n/', $content);
                foreach ($tables as $num => $table) {
                    $pos = strpos($table, ',');
                    $name = trim(substr($table, 0, $pos));
                    if ($tblName == null || $tblName == $name){
                        $sql = "DROP TABLE " . $name;
                        $this->_addStatus($sql);
                        $stmt = null;
                        try {
                            $stmt = $pdo->query($sql);
                        }catch (Exception $e){
                            $stmt = null;
                            $this->_addStatus("Table [$name] drop error: SQL Exception!");
                        }
                    }
                }

            }else
                $this->_addStatus("PDO Error!");
        }
    }
?>