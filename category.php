<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";
    if(!empty($_POST["name"])){
        $name = $_POST["name"];
        $sql = "INSERT INTO `category`(`name`) VALUES ('$name')";
        mysqli_query($mysqli, $sql);
        header("location: category.php");
    }

    if(!empty($_GET["drop"])){
        $id = $_GET["drop"];
        $sql = "DELETE FROM `zayavki` WHERE id_category = $id";
        mysqli_query($mysqli, $sql);
        $sql = "DELETE FROM `category` WHERE id_category = $id";
        mysqli_query($mysqli, $sql);
        header("location: category.php");
    }
?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Управление категориями</h2>
    <div class="btn_zay text-center mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Добавить категорию
        </button>
    </div>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="tables">
                <?php
                    $sql1 = "SELECT * FROM category";
                    $result1 = mysqli_query($mysqli, $sql1);
                    if(mysqli_num_rows($result1) > 0){
                        echo '
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Название категории</th>
                                        <th scope="col">Опции</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($result1 as $row){
                                    echo '
                                        <tr>
                                            <td>'.$row["name"].'</td>
                                            <td class="text-center"><a href="category.php?drop='.$row["id_category"].'"><img class="drop" id="'.$row["id_zayavki"].'" style="cursor: pointer;" src="img/drop.png" alt=""></a></td>
                                        </tr>
                                    ';
                                }
                                echo '
                                </tbody>
                            </table>
                        ';
                    }
                    else{
                        echo '<h3 class="text-center mt-4 mb-4">у вас нет категорий</h3>';
                    }
                ?>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить категорию</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
            <form action="" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Название категории</span>
                    <input type="text" class="form-control" name="name">
                </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Добавить</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </form>
      </div>
    </div>
  </div>
</div>