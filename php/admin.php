<?php
    // include './sql/' . "clsTable" . '.php';
    // include './sql/' . "clsUser" . '.php';

    spl_autoload_register(function ($class_name) {
        require_once 'sql/' . $class_name . '.php' ;
        echo $class_name . ' included! <br/>';
    });
    $db = new clsDatabase();
    $db->createTables();
    echo $db->__toHTML();
?>