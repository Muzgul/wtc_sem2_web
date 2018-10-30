<?php
    session_start();
    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });

    $success = false;
    $usr = new clsUser();
    $error = [];
    if (isset($_POST['submit'])){
        if ($usr->fetchUser($_POST['usrname'])){
            if ($_POST['submit'] == "Confirm"){
                $num = $_POST['first'] * 1000;
                $num += $_POST['second'] * 100;
                $num += $_POST['third'] * 10;
                $num += $_POST['fourth'];
                if ($usr->verifUser('verif', $num))
                    $success = true;
                else
                    array_push($error, "Entered the correct code.");
            }
            if ($_POST['submit'] == "Login"){
                if ($res = $usr->loginUser($_POST['usrname'], $_POST['passwd']))
                    $success = true;
                else{
                    array_push($error, "Entered the correct password!");
                    array_push($error, "Verified your email address.");
                }
            }
            if ($_POST['submit'] == "Reset"){
                
            }
        }else
            array_push($error, "Valid username");
    }
    if (isset($_GET['login']) && isset($_GET['code'])){
        if ($usr->fetchUser($_GET['login'])){
            if ($usr->verifUser('verif', $_GET['code']))
                $success = true;
        }
    }

    if ($success == true){
        $_SESSION['login'] = $_POST['usrname'];
        ?>
            <h2>Success!</h2>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Home</a>
        <?php
    }else{
        ?>
        <h3>Error! Please ensure you have:</h3>
        <ul>
        <?php
        foreach ($error as $key => $value) {
            ?>
            <li><?php echo $value; ?></li>
            <?php
        }
        ?>
        </ul>
        <?php
    }
?>