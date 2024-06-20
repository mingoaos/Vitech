<?php
    $con = mysqli_connect("localhost","root","","vitech");

    if(!$con){
        die('Connection failed'. mysqli_connect_error());
    }

    mysqli_set_charset($con,"utf8");
?>