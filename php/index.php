<?php
    if (!isset($_SERVER['HTTP_REFERER']))
        header('Location: http://' . $_SERVER['HTTP_HOST']);

    spl_autoload_register(function ($class_name) {
        require_once 'sql/' . $class_name . '.php' ;
    });

    $tbl = new clsTable();
    $tbl->fetchTable('tblimage');
    $tbl = $tbl->getTable();

    $items = 0;
    $per_page = 9;
    foreach ($tbl as $row_num => $row) {
        if ($items == 0){
            ?>
                <div class="page">
            <?php
        }
    ?><div class="image"><img id="<?php
        echo $row['id'];    
    ?>" src="<?php
        echo $row['url'];
    ?>" alt="<?php 
        echo $row['name'];
    ?>"><div class="img_details"><h2><?php    
        echo $row['name'];
    ?></h2><small><?php
        echo $row['creator'];
    ?> | <?php
        echo date('r', $row['date_created']);
    ?></small></div></div><?php
        if ($items == $per_page - 1){
            $items = 0;
            ?></div><?php
        }else
            $items++;
    }
    if ($items != 0){
        ?></div><?php
    }
    
    ?>
        <img id="page_prev" src="https://img.icons8.com/ios/100/000000/back-filled.png">
        <img id="page_next" src="https://img.icons8.com/ios/100/000000/back-filled.png">
    <?php
?>
