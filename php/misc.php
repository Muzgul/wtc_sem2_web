<?php
    session_start();

    $usr_name = $_SESSION['login'];

    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });

    $arr = $_POST;
    $arr['usrname'] = $usr_name;
    print_r($arr);
    $tbl = new clsTable();
    $tbl->pushMisc($arr);
?>