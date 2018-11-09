<?php
    session_start();
    
    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);

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

    if ($usr) {
    ?>
    <div class="usr_usrname">
        <input type="text" name="usrname" id="usrname" value="<?php echo $usr['usrname'];?>">
    </div>
    <div class="usr_form">
        <div class="form_group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $usr['first_name'];?>">
        </div>
        <div class="form_group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo $usr['last_name'];?>">
        </div>
        <div class="form_group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $usr['email'];?>">
        </div>
        <div class="form_group">
            <label for="notif">Notifications</label>
            <input type="checkbox" name="notif" id="notif" <?php if ($usr['notif'] == "1") echo "checked";?>>
        </div>
    </div>
    <?php
    }
    ?><div class="page"><?php
    foreach ($posts as $row_num => $row) {
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
    }?></div>
