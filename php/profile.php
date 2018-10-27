<?php
    session_start();
    $usr_name = $_SESSION['login'];
    
    spl_autoload_register(function ($class_name) {
        require_once 'sql/' . $class_name . '.php' ;
    });

    $usr = new clsUser();
    $usr->fetchUser($usr_name);
    $usr = $usr->getUser();

    $posts = new clsImage();
    $posts->fetchCollection($usr_name);
    $posts = $posts->getCollection();

    foreach ($usr as $key => $value) {
    ?>
        <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
        <input id="<?php echo $key; ?>" type="text" value="<?php echo $value; ?>">
        <br>
    <?php
    }

    foreach ($posts as $row_num => $row) {
    ?><div class="image"><img src="<?php
        echo $row['url'];
    ?>" alt="<?php 
        echo $row['name'];
    ?>"><h2><br><?php    
        echo $row['name'];
    ?></h2><small><?php
        echo $row['creator'];
    ?> | <?php
        echo date('r', $row['date_created']);
    ?></small></div><?php
    }
?>
