<?php
    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);
?>

<p>header</p>