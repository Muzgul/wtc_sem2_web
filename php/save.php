<?php
    session_start();
    
    if (!isset($_SERVER['HTTP_REFERER']))
    header('Location: http://' . $_SERVER['HTTP_HOST']);

    $usr_name = $_SESSION['login'];
    
    spl_autoload_register(function ($class_name) {
        require_once './sql/' . $class_name . '.php' ;
    });

    if (isset($_POST['submit']) && $_POST['submit'] == "create"){
        $base = imagecreatefrompng("temp.png");
        $overlay = imagecreatefrompng($_POST['image']);
        list($dw, $dh) = getimagesize("temp.png");
        list($sw, $sh) = getimagesize($_POST['image']);
        $offx = $_POST['offx'];
        $offy = $_POST['offy'];
        $res = imagecopyresized($base, $overlay, $offx, $offy, 0, 0, $sw, $sh, $sw, $sh);
        if ($res){
            $url = uniqid() . ".png";
            $name = $_POST['name'];
            if ($name == "" || $name == null)
                $name = $url;
            imagepng($base, "../assets/images/" . $url);
            $img = new clsImage();
            $img->pushImage($usr_name, $name, $url);
            echo json_encode($img->getImage());
        }
        imagedestroy($base);
        imagedestroy($overlay);
        unlink("temp.png");
    }else{
        $imageData=file_get_contents("php://input");
        $filteredData=substr($imageData, strpos($imageData, ",")+1);
        $unencodedData=base64_decode($filteredData);
        $fp = fopen( 'temp.png', 'wb' );
        fwrite( $fp, $unencodedData);
        fclose( $fp );
    }
?>