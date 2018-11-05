<?php
    session_start();

    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);

    if (isset($_GET['login']))
        $_SESSION['login'] = $_GET['login'];
    if (isset($_SESSION['login']))
        echo $_SESSION['login'];
?>