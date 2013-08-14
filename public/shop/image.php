<?php
if (isset($_GET['img'])) {

    $img = stripslashes($_GET['img']);


    if (is_file($_SERVER['DOCUMENT_ROOT'] . '/shop/images/cache/' . $img)) {
        // read contents
        //$size = filesize($_SERVER['DOCUMENT_ROOT'] . '/shop/images/cache/' . $img);

        // no-cache headers - complete set
        // these copied from [php.net/header][1], tested myself - works
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Some time in the past
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // image related headers
        //header('Accept-Ranges: bytes');
        //header('Content-Length: ' . $size); // How many bytes we're going to send
        header('Content-Type: image/jpeg'); // or image/png etc
        // actual image

        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/shop/images/cache/' . $img);

        echo base64_decode($data);
        unset($data);
        
        //imagejpeg($img);
        //imagedestroy($img);
    }
}
?>
