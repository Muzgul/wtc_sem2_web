<video autoplay="true" id="videoElement" poster="">
</video>
<img id='cover'>
<img id="snap" src="">

<br>

<button id="btnCapture">take pic</button>
<button id="btnReset">reset</button>
<button id="btnSave">save</button>

<br>

<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/overlay";
    $dir = opendir($path);
    while (false !== ($entry = readdir($dir))) {

        if ($entry != "." && $entry != "..") {
        ?>
            <img class="overlay" src='<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/assets/overlay/" . $entry; ?>'>
        <?php            
        }
    }
    closedir($dir);
?>