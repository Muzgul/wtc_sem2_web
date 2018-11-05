<?php
    session_start();

    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);

    spl_autoload_register(function ($class_name) {
        require_once 'sql/' . $class_name . '.php' ;
    });

    print_r($_POST);
    if (isset($_POST['method'])){
        if ($_POST['method'] == "update"){
            $usr = new clsUser();
            $usr->updateUser($_SESSION['login'], $_POST['field'], $_POST['value']);
            echo $usr->__toHTML();
        }else
            echo "its not post";
    }else
        echo "no method";
?>