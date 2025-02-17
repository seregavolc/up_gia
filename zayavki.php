<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";

    if(!empty($_POST["opis"])){
        $id = $_POST["idz"];
        $opis = $_POST["opis"];
        $datae = date("Y-m-d H:i:s");
        $sql = "UPDATE `zayavki` SET `datae`='$datae',`status`='отклонена',`otkaz`='$opis' WHERE id_zayavki = $id";
        mysqli_query($mysqli, $sql);
        header("location: zayavki.php");
    }

    if(!empty($_FILES["fotop"])){
        $id = $_POST["idz"];
        $datae = date("Y-m-d H:i:s");
        if(($_FILES['fotop']["type"] != "image/jpeg") && ($_FILES['fotop']["type"] != "image/jpg") && ($_FILES['fotop']["type"] != "image/png") && ($_FILES['fotop']["type"] != "image/bmp")){
            header("location: zayavki.php?mess=ошибка: файл не подходит по формату");
            exit;
        }
        if(($_FILES['fotop']["size"] > 10 * 1024 * 1024)){
            header("location: zayavki.php?mess=ошибка: файл не должен весить больше 10 мб");
            exit;
        }

        $uploaddir = 'img/';
        $uploadfile = $uploaddir . basename($_FILES['fotop']['size']* rand(1, 99) .".png");
        if (move_uploaded_file($_FILES['fotop']['tmp_name'], $uploadfile)) {
            $sql = "UPDATE `zayavki` SET `datae`='$datae',`status`='решена', `foto_posle`='$uploadfile' WHERE id_zayavki = $id";
            $result = mysqli_query($mysqli, $sql);
            if($result){
                header("location: zayavki.php");
            }
            else{
               header("location: zayavki.php?mess=ошибка: проблемы с отправкой заявки");
            }
        } else {
            header("location: zayavki.php?mess=ошибка: проблемы с загрузкой файла");
        }
    }
?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Управление заявками</h2>
    <div class="tables">
        <?php
            $sql1 = "SELECT * FROM zayavki, category where category.id_category = zayavki.id_category order by id_zayavki desc";
            $result1 = mysqli_query($mysqli, $sql1);
            if(mysqli_num_rows($result1) > 0){
                echo '
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Временная метка</th>
                                <th scope="col">Название заявки</th>
                                <th scope="col">Описание</th>
                                <th scope="col">Категория</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Опции</th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach($result1 as $row){
                            echo '
                                <tr>
                                    <td>'.$row["datas"].'</td>
                                    <td>'.$row["name_zayavki"].'</td>
                                    <td>'.$row["opis"].'</td>
                                    <td>'.$row["name"].'</td>
                                    <td>'.$row["status"].'</td>';
                                    if($row["status"] == "новая"){
                                        echo '<td>
                                            <img class="drop me-4" id="'.$row["id_zayavki"].'" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#yesmodal" src="img/yes.png" alt="">
                                            <img class="drop me-4 ster" id="'.$row["foto"].'" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imgm" src="img/lup.png" alt="">
                                            <img class="drop" id="'.$row["id_zayavki"].'" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" src="img/drop.png" alt="">
                                        </td>';
                                    }
                                    else{
                                        echo '<td></td>';
                                    }
                             echo '</tr>
                            ';
                        }
                         echo '
                        </tbody>
                    </table>
                ';
            }
            else{
                echo '<h3 class="text-center mt-4 mb-4">у вас нет заявок</h3>';
            }
        ?>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Причина отказа</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <div class="mb-3">
                <input type="hidden" class="idz" name="idz" >
                <textarea required class="form-control" id="opis" name="opis" rows="3"></textarea>
            </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-danger">Удалить</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="imgm" tabindex="-1" aria-labelledby="imgm" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imgsm" src="" alt="" style="height: 800px; width: 1200px;">
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="yesmodal" tabindex="-1" aria-labelledby="yesmodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Заявка решена</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" class="idz" name="idz" >
                <input required class="form-control" type="file" id="fotop" name="fotop">
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Завершить</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $(".drop").click(function(){
            $(".idz").val($(this).attr("id"));
        })

        $(".ster").click(function(){
            $("#imgsm").attr("src", $(this).attr("id"));
        })
    })
</script>