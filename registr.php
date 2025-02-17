<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";

    if(!empty($_POST["login"])){
        $login = $_POST["login"];
        $fio = $_POST["fio"];
        $email = $_POST["email"];
        $pass1 = $_POST["pass1"];
        $sql = "INSERT INTO `users`(`id_role`, `fio`, `email`, `pass`, `login`) VALUES (1,'$fio','$email','$pass1','$login')";
        $result = mysqli_query($mysqli, $sql);
        header("location: index.php");
    }
?>

<div class="container">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h2 class="text-center mt-4">Регистрация</h2>
            <form class="mt-5 mb-5" method="post" action="">
            <div class="mb-3">
                <label for="fio" class="form-label">ФИО</label>
                <input type="text" class="form-control" required pattern="^[А-Яа-яЁё\s]+$" id="fio" name="fio">
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">логин</label><span class="text-danger teds"></span>
                <input type="text" class="form-control" required pattern="^[a-zA-Z]+$" id="login" name="login">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Адрес электронной почты</label>
                <input type="email" class="form-control" required id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="pass1" class="form-label">Пароль</label><span class="text-danger ted"></span>
                <input type="password" class="form-control" required id="pass1" name="pass1">
            </div>
            <div class="mb-3">
                <label for="pass2" class="form-label">Повторите пароль</label><span class="text-danger ted"></span>
                <input type="password" class="form-control" required id="pass2" name="pass2">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" required class="form-check-input" id="sogl">
                <label class="form-check-label" for="sogl">Согласие на обработку персональных данных</label>
            </div>
            <button type="submit" id="btn" disabled class="btn btn-primary">Отправить</button>
        </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $("#pass2").change(function(){
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;
            if(pass1 == pass2){
                $("#btn").removeAttr("disabled");
                $(".ted").html(" ");
            }
            else{
                $("#btn").attr("disabled", "disabled");
                $(".ted").html(" Пароли не совпадают");
            }
        })
    })

    $("#login").change(function(){
        var login = $(this).val();
        $.ajax({
            type: 'POST',
            url: "registrs.php",
            data: ({login: login}),
            dataType: 'html',
            success: function(result){
                if(result == "no"){
                    $("#btn").removeAttr("disabled");
                    $(".teds").html(" ");
                }
                else{
                    $("#btn").attr("disabled", "disabled");
                    $(".teds").html(" занят");
                }
            }
        }
        )
    })
</script>