<?php
    include "temp/bd.php";
    $login = $_POST["login"];
    $sql = "SELECT * FROM `users` WHERE login = '$login'";
    $result = mysqli_query($mysqli, $sql);
    $result = mysqli_fetch_array($result);
    if ($result["login"]) {
        echo $result["login"];
    }
    else {
        echo "no";
    }
?>