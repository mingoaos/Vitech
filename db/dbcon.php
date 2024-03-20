<?php

    $con = mysqli_connect("localhost","root","","pap");

    if(!$con){
        die('Connection failed'. mysqli_connect_error());
    }

?>