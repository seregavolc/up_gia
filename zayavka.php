<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";

    $sql = "SELECT * FROM `category`";
    $result = mysqli_query($mysqli, $sql);

    if(!empty($_POST["name"])){
        $name = $_POST["name"];
        $id_user = $_SESSION["id_user"];
        $opis = $_POST["opis"];
        $category = $_POST["category"];
        $datas = date("Y-m-d H:i:s");
        if(($_FILES['foto']["type"] != "image/jpeg") && ($_FILES['foto']["type"] != "image/jpg") && ($_FILES['foto']["type"] != "image/png") && ($_FILES['foto']["type"] != "image/bmp")){
            header("location: zayavka.php?mess=ошибка: файл не подходит по формату");
            exit;
        }
        if(($_FILES['foto']["size"] > 10 * 1024 * 1024)){
            header("location: zayavka.php?mess=ошибка: файл не должен весить больше 10 мб");
            exit;
        }

        $uploaddir = 'img/';
        $uploadfile = $uploaddir . basename($_FILES['foto']['size']* rand(1, 99) .".png");
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadfile)) {
            $sql = "INSERT INTO `zayavki`(`id_user`, `name_zayavki`, `opis`, `id_category`, `datas`,`foto`, `status`)
            VALUES ($id_user,'$name','$opis',$category, '$datas', '$uploadfile', 'новая')";
            $result = mysqli_query($mysqli, $sql);
            if($result){
                header("location: lk.php");
            }
            else{
               header("location: zayavka.php?mess=ошибка: проблемы с отправкой заявки");
            }
        } else {
            header("location: zayavka.php?mess=ошибка: проблемы с загрузкой файла");
        }
    }
?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Новая заявка</h2>
    <div class="text text-center mb-4">
    <span class=" text-danger"> <?php if(!empty($_GET["mess"])){ echo $_GET["mess"];} ?></span>
    </div>
    <form class="g-3" method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" required class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="opis" class="form-label">Описание</label>
                <textarea required class="form-control" id="opis" name="opis" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Категория</label>
                <select required id="category" class="form-select" name="category">
                    <?php
                        if(isset($result)){
                            foreach($result as $row){
                                echo '<option value="'.$row["id_category"].'">'.$row["name"].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Фото, демонстрирующее проблему </label>
                <input required class="form-control" type="file" id="foto" name="foto">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
    </form>
</div>

      