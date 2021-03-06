<?php
    require_once "clsConnection.php";

    class clsImage extends clsConnection {
        // Properties

        private $_table = "tblimage";
        private $_collection = [];
        private $_image = [];

        // Base methods

        public function __construct(){
            clsConnection::__construct();
            $this->_addStatus("Child object [Image] created.");
        }

        // Additional Functions

        public function fetchImage( $id ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                // $sql = "SELECT * FROM `$this->_table` WHERE `id` = '$id'";
                $sql = "SELECT * FROM `$this->_table` WHERE `id` = :id";
                $stmt = null;
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id' => $id]);
                    // $stmt = $pdo->query($sql);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("Image [$name] fetch error: SQL Exception!");
                }
                if ($stmt != null){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        $this->_image = $row;
                    $this->_addStatus("Image [$name] fetch success!");
                    return true;
                }else
                    $this->_addStatus($stmt);
            }else
                $this->_addStatus("Image [$name] fetch error: No active connection!");
            return false;
        }

        public function fetchCollection( $usrName ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                if (empty($this->_collection)){
                    // $sql = "SELECT * FROM `$this->_table` WHERE `creator` = '$usrName' ORDER BY `date_created` DESC";
                    $sql = $sql = "SELECT * FROM `$this->_table` WHERE `creator` = :usrname ORDER BY `date_created` DESC";
                    $stmt = null;
                    try {
                        // $stmt = $pdo->query($sql);
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['usrname' => $usrName]);
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

        public function pushImage($usrname, $name, $url){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $root = "http://" . $_SERVER['HTTP_HOST'] . "/assets/images/";
                $sql = "INSERT INTO `$this->_table` (`id`, `name`, `creator`, `date_created`, `url`) VALUES ";
                // $sql .= "('" . $url . "', '" . $name . "' , '" . $usrname . "' , '" . time() . "' , '" . $root . $url . "')";
                $sql .= "(:id, :name, :usrname, :date, :url)";
                $stmt = null;
                try {
                    // $stmt = $pdo->query($sql);
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id' => $url, 'name' => $name, 'usrname' => $usrname, 'date' => time(), 'url' => $root . $url]);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("Image [" . $name . "] push error: SQL Exception!");
                    $this->_addStatus($sql);
                    $this->_addStatus($e);
                }
                if ($stmt != null){
                    $this->_addStatus("Image [" . $name . "] push success!");
                    $this->fetchImage($url);
                    return true;
                }
            }else
                $this->_addStatus("Image [" . $name . "] push error: No active connection!");
            return false;
        }

        public function deleteImage( $id ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $root = "http://" . $_SERVER['HTTP_HOST'] . "/assets/images/";
                $sql = "DELETE FROM `$this->_table` WHERE `id` = :id";
                $stmt = null;
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id' => $id]);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("Image [" . $name . "] push error: SQL Exception!");
                    $this->_addStatus($sql);
                    $this->_addStatus($e);
                }
                if ($stmt != null){
                    unlink($_SERVER['DOCUMENT_ROOT'] . "/assets/images/" . $id);
                    $this->_addStatus("Image [" . $name . "] push success!");
                    $this->fetchImage($url);
                    return true;
                }
            }else
                $this->_addStatus("Image [" . $name . "] push error: No active connection!");
            return false;
        }

        public function getCollection(){
            return $this->_collection;
        }

        public function getimage(){
            return $this->_image;
        }
    }
?>