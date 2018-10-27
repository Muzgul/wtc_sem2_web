<?php
    spl_autoload_register(function ($class_name) {
        require_once 'sql/' . $class_name . '.php' ;
    });

    $tbl = new clsTable();
    $tbl->fetchTable('tblimage');
    $tbl = $tbl->getTable();

    foreach ($tbl as $row_num => $row) {
    ?><div class="image"><img src="<?php
        echo $row['url'];
    ?>" alt="<?php 
        echo $row['name'];
    ?>"><h2><?php    
        echo $row['name'];
    ?></h2><small><?php
        echo $row['creator'];
    ?> | <?php
        echo date('r', $row['date_created']);
    ?></small></div><?php
    }
?>
