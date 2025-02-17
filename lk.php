<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";

    if(!empty($_GET["drop"])){
        $id = $_GET["drop"];
        $sql = "SELECT * FROM zayavki where id_zayavki = $id";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($result);
        $file = $row["foto"];
        unlink($file);
        $sql = "DELETE FROM `zayavki` WHERE id_zayavki = $id";
        mysqli_query($mysqli, $sql);
        header("location: lk.php");
    }
?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Личный кабинет</h2>
    <div class="btn_zay text-center">
        <a class="btn btn-primary mb-4 " href="zayavka.php" role="button">Оставить заявку</a>
    </div>
    <div class="filtr mt-4 mb-4">
        <form action="" method="post">
            <div class="row">
                <h4 class="text-center">Фильтр по статусу заявки</h4>
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <select class="form-select" name="filtr" id="inputGroupSelect04" aria-label="Пример элемента выбора с помощью надстройки кнопки">
                            <option selected>Выберите...</option>
                            <option value="новая">новая</option>
                            <option value="отклонена">отклонена</option>
                            <option value="решена">решена</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">применить</button>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </form>
    </div>
    <div class="tables">
        <?php
            $user = $_SESSION["id_user"];
            if(!empty($_POST["filtr"])){
                $status = $_POST["filtr"];
                $sql1 = "SELECT * FROM zayavki, category where category.id_category = zayavki.id_category and id_user = $user and status = '$status' order by id_zayavki desc";
                $result1 = mysqli_query($mysqli, $sql1);
            }
            else{
                $sql1 = "SELECT * FROM zayavki, category where category.id_category = zayavki.id_category and id_user = $user order by id_zayavki desc";
                $result1 = mysqli_query($mysqli, $sql1);
            }
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
                                <th scope="col"></th>
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
                                        echo '<td><img class="drop" id="'.$row["id_zayavki"].'" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" src="img/drop.png" alt=""></td>';
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Удалить заявку</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <p>Вы действительно хотите удалить заявку?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        <a type="button" id="btb" class="btn btn-danger" href="lk.php?drop=">Удалить</a>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $(".drop").click(function(){
            var text = "lk.php?drop=" + $(this).attr("id");
            $("#btb").attr("href", text);

        })
    })
</script>