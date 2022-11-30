<?php

$con = mysqli_connect("localhost","root","","ticketsystem");
$con -> set_charset("utf8");
if(!$con){
    die('Connection Failed'. mysqli_connect_error());
}

?>