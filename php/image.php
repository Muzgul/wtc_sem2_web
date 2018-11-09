<?php
    session_start();

    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);

    $usr_name = $_SESSION['login'];

    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });

    $img_id = $_GET['image'];
    $img = new clsImage();
    $img->fetchImage($img_id);
    echo $img->__toHTML();
    $img = $img->getImage();
    $usr = new clsUser();
    $usr->fetchUser($img['creator']);
    $tbl = new clsTable();
    $tbl->fetchMisc('image', $img_id);
    echo $tbl->__toHTML();
    $tbl = $tbl->getTable();
    $comments = [];
    $likes = [];
    
    foreach ($tbl as $key => $value) {
        if ($value['category'] == "comment")
            array_push($comments, $value);
        else
            array_push($likes, $value);
    }
?>

<div id="view_img">
    <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['id']; ?>" id="main_image">
    <h2><?php echo $img['name']; ?></h2>
    <small><?php echo date('r', $row['date_created']); ?></small><span id="image_creator"><?php echo $img['creator']; ?></span>
    <input type="text" id="comment_value">
    <button id="post_comment">Comment</button>
    <button id="post_like">Like</button>
    <div id="likes_tooltip">
        <span id="likes_count"><?php echo count($likes); ?></span>
        <span id="likes_tooltip_text">
            <?php
                foreach ($likes as $key => $value) {
                    if ($key != 0)
                        echo ", ";
                    echo $value['usrname'];
                }
            ?>
        </span>
    </div>
    <?php 
        if ($img['creator'] == $usr_name){
            ?>
            <button id="delete_img">Delete</button>
            <?php
        }
    ?>
</div>
<ul id="image_comments">
    <?php
        foreach ($comments as $key => $row) {
            ?>
                <li><?php echo $row['value'] . " - " . $row['usrname'] . "(" . date('r', $row['date_created']) . ")"; ?></li>
            <?php
        }
    ?>
</ul>