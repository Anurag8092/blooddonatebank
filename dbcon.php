<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "blooddonatedb";

$con = mysqli_connect($server, $user, $password, $db);

if(!$con){
    ?>
    <script>
        alert("not connected");
    </script>
    <?php
}
?>