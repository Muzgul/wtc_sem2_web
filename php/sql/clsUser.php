<?php
    require_once "clsConnection.php";

    class clsUser extends clsConnection {

        // Properties

        private $_table = "tblusers";
        private $_hash = "sha256";
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
                    $sql = "SELECT * FROM `$this->_table` WHERE `usrname` = '$usrName'";
                    $stmt = null;
                    try {
                        $stmt = $pdo->query($sql);
                    }catch (Exception $e){
                        $stmt = null;
                        $this->_addStatus("User [$usrName] fetch error: SQL Exception!");
                    }
                    if ($stmt != null){
                        while ($row = $stmt->fetch())
                            $this->_user = $row;
                        $this->_addStatus("User [$usrName] fetch success!");
                        return true;
                    }
                }else
                    $this->_addStatus("User [$usrName] fetch error: Content already exists!");
            }else
                $this->_addStatus("User [$usrName] fetch error: No active connection!");
            return false;
        }

        public function pushUser( $valArr ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                $sql = "INSERT INTO `$this->_table` (`usrname`, `passwd`, `first_name`, `last_name`, `email`, `verif`, `notif`) VALUES ";
                $sql .= "('" . $valArr['usrname'] . "' , '" . hash($this->_hash, $valArr['passwd']) . "' , '" . $valArr['first_name']. "' , '" .$valArr['last_name']. "' , '" .$valArr['email']. "' , '1', '1')";
                $stmt = null;
                try {
                    $stmt = $pdo->query($sql);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("User [" . $valArr['usrname'] . "] push error: SQL Exception!");
                    $this->_addStatus($sql);
                    $this->_addStatus($e);
                }
                if ($stmt != null){
                    $this->_addStatus("User [" . $valArr['usrname'] . "] push success!");
                    $this->fetchUser($valArr['usrname']);
                    return true;
                }
            }else
                $this->_addStatus("User [" . $valArr['usrname'] . "] push error: No active connection!");
            return false;
        }

        public function updateUser( $usrname, $field, $value ){
            $pdo = $this->_getPDO();
            if ($pdo != null){
                if ($field == "passwd")
                    $value = hash($this->_hash, $value);
                $sql = "UPDATE `$this->_table` SET `$field` = '$value' WHERE `usrname` = '$usrname'";
                try {
                    $stmt = $pdo->query($sql);
                }catch (Exception $e){
                    $stmt = null;
                    $this->_addStatus("User [$usrName] update error: SQL Exception!");
                    return false;
                }
                return true;
            }
        }

        public function verifUser($field, $value){
            $usr = $this->_user;
            if (count($usr) > 0){
                if ($field == 'passwd')
                    $value = hash($this->_hash, $value);
                if ($usr[$field] == $value){
                    if ($field == 'verif')
                        $this->updateUser($usr['usrname'], 'verif', 0);
                    return true;                    
                }
            }
            return false;
        }

        public function loginUser($usrname, $passwd){
            $usr = $this->_user;
            if (count($usr) > 0){
                if ($usrname == $usr['usrname']){
                    $passwd = hash($this->_hash, $passwd);
                    if ($passwd == $usr['passwd'] && $usr['verif'] == 0)
                        return true;
                }
            }
            return false;
        }

        public function sendVerif(){
            $usr = $this->_user;
            if (count($usr) > 0){
                $num = rand(1000, 9999);
                $this->updateUser($usr['usrname'], 'verif', $num);
                $from = "mmacdona@student.wethinkcode.co.za";
                $to = $usr['email'];
                $headers = "From: ".$from."\r\n";
                $headers .= "Reply-To: ".$from."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    
                $gpg_path = '/usr/local/bin/gpg';
                $home_dir = $_SERVER['DOCUMENT_ROOT'];
                $user_env = 'web';
                
                $cmd = "HOME=$home_dir USER=$user_env $gpg_path" .
                    "--quiet --no-secmem-warning --encrypt --sign --armor " .
                    "--recipient $to --local-user $from";
        
                $message_body = "
                <div>
                <h2>Welcome to Camagru " . $usr['usrname'] . "!</h2>
                <h3>$num</h3>
                <small>Verification code or follow <a href='http://" . $_SERVER['HTTP_HOST'] . "/php/auth.php?login=" . $usr['usrname'] . "&code=$num'>this link</a> to confirm.</small>
                <p>That's all folks.</p>
                <i>The Camagru Team</i>
                </div>";
                $cmd = $message_body . `$cmd`;
                mail($to,'Message from Camagru', $cmd,$headers);
                return true;
            }
            return false;
        }

        public function sendPassReset(){
            $usr = $this->_user;
            if (count($usr) > 0){
                $from = "mmacdona@student.wethinkcode.co.za";
                $to = $usr['email'];
                $headers = "From: ".$from."\r\n";
                $headers .= "Reply-To: ".$from."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    
                $gpg_path = '/usr/local/bin/gpg';
                $home_dir = $_SERVER['DOCUMENT_ROOT'];
                $user_env = 'web';
                
                $cmd = "HOME=$home_dir USER=$user_env $gpg_path" .
                    "--quiet --no-secmem-warning --encrypt --sign --armor " .
                    "--recipient $to --local-user $from";
        
                $message_body = '
                <div>
                    <p>To reset your password please follow this link: </p>
                    <a href="http://' . $_SERVER['HTTP_HOST'] . '/php/passReset.php?login=' . $usr['usrname'] . '">Reset Password</a>
                </div>';
                $cmd = $message_body . `$cmd`;
                mail($to,'Message from Camagru', $cmd,$headers);
                return true;
            }
            return false;
        }

        public function sendNotif( $valArr ){
            $usr = $this->_user;
            if (count($usr) > 0 && $usr['notif'] == 1){
                $from = "mmacdona@student.wethinkcode.co.za";
                $to = $usr['email'];
                $headers = "From: ".$from."\r\n";
                $headers .= "Reply-To: ".$from."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    
                $gpg_path = '/usr/local/bin/gpg';
                $home_dir = $_SERVER['DOCUMENT_ROOT'];
                $user_env = 'web';
                
                $cmd = "HOME=$home_dir USER=$user_env $gpg_path" .
                    "--quiet --no-secmem-warning --encrypt --sign --armor " .
                    "--recipient $to --local-user $from";
        
                $message_body = '
                <div>
                    <h2>Notification</h2>
                    <p>You comment has received a ' . $valArr['category'] . ' from ' . $valArr['usrname'] . '.</p>
                    <p>' . $valArr['value'] . '</p>
                    <small>To unsibscribe please logon and change your preferences.</small>
                </div>';
                $cmd = $message_body . `$cmd`;
                mail($to,'Message from Camagru', $cmd,$headers);
                return true;
            }
            return false;
        }

        public function getUser(){
            return $this->_user;
        }
    }
?>