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
?>

<div id="myModal" class="modal">
    <div id="modal-content">
    <span class="close">&times;</span>
    <img src="" alt="" id="modalImg">
    </div>
</div>

<div id="snap-container">
    <video autoplay="true" id="videoElement" poster="">
    </video>
    <img id='cover' class="draggable">
</div>

<button id="btnCapture">take pic</button>
<button id="btnSave">save</button>
<input type="text" name="img_name" id="img_name">
<button id="btnReset">reset</button>

<br>

<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/overlay";
    $dir = opendir($path);
    while (false !== ($entry = readdir($dir))) {

        if ($entry != "." && $entry != "..") {
        ?>
            <img class="overlay" id="<?php echo $entry; ?>" src='<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/assets/overlay/" . $entry; ?>'>
        <?php            
        }
    }
    closedir($dir);

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