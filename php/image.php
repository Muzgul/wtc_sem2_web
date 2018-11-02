<?php
    session_start();
    $usr_name = $_SESSION['login'];

    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });

    $img_id = $_GET['image'];
    $img = new clsImage();
    $img->fetchImage($img_id);
    $img = $img->getImage();
    $usr = new clsUser();
    $usr->fetchUser($img['creator']);
    $tbl = new clsTable();
    $tbl->fetchMisc('image', $img_id);
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
        <?php echo count($likes); ?>
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
</div>
<ul id="image_comments">
    <?php
        foreach ($comments as $key => $row) {
            ?>
                <li><?php echo $row['value'] . " - " . $row['usrname']; ?></li>
            <?php
        }
    ?>
</ul>