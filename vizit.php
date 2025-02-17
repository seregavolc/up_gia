<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";

    if(!empty($_POST["login"])){
        $login = $_POST["login"];
        $pass1 = $_POST["pass1"];
        $sql = "SELECT * FROM `users` WHERE login = '$login' and pass = '$pass1'";
        $result = mysqli_query($mysqli, $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $_SESSION["id_role"] = $row["id_role"];
            $_SESSION["id_user"] = $row["id_user"];
            if($row["id_role"] == 1){
                header("location: lk.php");
            }
            else if($row["id_role"] == 2){
                header("location: zayavki.php");
            }
            else{
                header("location: index.php");
            }
        }
        else{
            header("location: vizit.php?mess=неверный логин или пароль");
        }
    }
?>

<div class="container">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h2 class="text-center mt-4">Вход</h2>
            <form class="mt-5 mb-5" method="post" action="">
            <span class="text-danger"><?php if(!empty($_GET["mess"])){ echo $_GET["mess"];} ?></span>
            <div class="mb-3">
                <label for="login" class="form-label">логин</label>
                <input type="text" class="form-control" required id="login" name="login">
            </div>
            <div class="mb-3">
                <label for="pass1" class="form-label">Пароль</label>
                <input type="password" class="form-control" required id="pass1" name="pass1">
            </div>
            <button type="submit" id="btn" class="btn btn-primary">Отправить</button>
        </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>