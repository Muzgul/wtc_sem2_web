<button id="profile">Profile</button>
<button id="feed">Feed</button>
<button id="cam">Cam</button>
    <?php session_start(); ?>
        <button id="out"
    <?php
    if (!(isset($_SESSION['login']) && $_SESSION['login'] != "" && $_SESSION['login'] != null)){
        echo 'style="display: none;"';
    }
    ?>
    >Logout</button>