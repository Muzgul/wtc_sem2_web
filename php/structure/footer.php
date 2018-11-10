<?php
    session_start();
    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);
?>

<div id="footer_nav">
    <img id="profile" src="https://img.icons8.com/bubbles/50/000000/gender-neutral-user.png">
    <img id="cam" src="https://img.icons8.com/dusk/50/000000/instant-camera.png">
    <img id="feed" src="https://img.icons8.com/office/50/000000/medium-icons.png">
</div>

<img id="out" src="https://img.icons8.com/cotton/50/000000/shutdown.png"
    <?php
        if (!(isset($_SESSION['login']) && $_SESSION['login'] != "" && $_SESSION['login'] != null)){
            echo 'style="display: none;"';
        }
    ?>
>