<?php

    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);

?>

<div id="snap-container">
    <video autoplay="true" id="videoElement" poster="">
    </video>
    <img id='cover' class="draggable">
</div>

<button id="btnCapture">take pic</button>
<button id="btnReset">reset</button>
<button id="btnSave">save</button>
<input type="text" name="img_name" id="img_name">

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
?>

<button id="myBtn">Open Modal</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div id="modal-content">
    <span class="close">&times;</span>
    <img src="" alt="" id="modalImg">
  </div>

</div>