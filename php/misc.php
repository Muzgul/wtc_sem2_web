<?php
    session_start();

    if (!isset($_SERVER['HTTP_REFERER']))
        header('Location: http://' . $_SERVER['HTTP_HOST']);

    $usr_name = $_SESSION['login'];

    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });

    if (isset($_POST['method']) && $_POST['method'] == "delete"){
        $img = new clsImage();
        $img->deleteImage($_POST['image']);
    }else{
        $arr = $_POST;
        $arr['usrname'] = $usr_name;
        $tbl = new clsTable();
        $tbl->pushMisc($arr);
        echo $tbl->__toHTML();
    }
?>