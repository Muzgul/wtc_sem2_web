<?php
    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });
    
    if (count($_POST) > 0){
        $usr = new clsUser();
        $arr = $_POST;
        print_r($arr);
        if ($arr['submit'] == 'Signup' && !$usr->pushUser($arr)){
            ?>
                <h2>User creating error!</h2>
            <?php
        }else{
            $usr->fetchUser($arr['usrname']);
            $usr->sendVerif();
            ?>
                <h2>Please enter code found in confirmation email.</h2>
                <small>Email was sent to <? echo $arr['email']; ?></small>
                <form id="verif" method="POST" action="php/auth.php">
                    <input type="number" name="first" id="first" value='0' min='0' max='9'>
                    <input type="number" name="second" id="second" value='0' min='0' max='9'>
                    <input type="number" name="third" id="third" value='0' min='0' max='9'>
                    <input type="number" name="fourth" id="fourth" value='0' min='0' max='9'>
                    <input type="text" name="usrname" id="usrname" value="<?php echo $arr['usrname']; ?>" hidden>
                    <input type="submit" name="submit" value="Confirm">
                </form>
            <?php
        }
    }
?>