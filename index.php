<?php
    include "temp/header.php";
    include "temp/nav.php";
    include "temp/bd.php";
    $sql = "SELECT COUNT(id_zayavki) as sum FROM `zayavki` WHERE status = 'решена'";
    $res = mysqli_query($mysqli, $sql);
    $res = mysqli_fetch_array($res);
?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Количество решенных заявок: <?php if(!empty($res['sum'])){ echo $res['sum'];} else{ echo '0';} ?></h2>

    <div class="row row-cols-1 row-cols-md-2 g-4 mt-3">
        <?php
            $sql = "SELECT * FROM zayavki, category WHERE zayavki.id_category = category.id_category and status = 'решена' order by id_zayavki desc LIMIT 4";
            $res = mysqli_query($mysqli, $sql);

            foreach($res as $row){
                echo '
                    <div class="col">
                        <div class="card">
                            <img src="'.$row["foto_posle"].'" class="card-img-top imsc" alt="...">
                            <div class="card-body">
                                <input type="hidden" value="'.$row["foto"].'" class="fotos">
                                <input type="hidden" value="'.$row["foto_posle"].'" class="fotoe">
                                <h5 class="card-title">'.$row["datae"].'</h5>
                                <h6 class="card-title">'.$row["name_zayavki"].'</h6>
                                <h6 class="card-title">'.$row["name"].'</h6>
                                <p class="card-text">'.$row["opis"].'</p>
                            </div>
                        </div>
                    </div>
                ';
            }
        ?>
    </div>  
</div>


<script>
    $(document).ready(function(){
        $(".card").mousemove(function(){
            $(this).children('.imsc').attr("src", $(this).children(".card-body").children(".fotos").val());
        })

        $(".card").mouseout(function(){
            $(this).children('.imsc').attr("src", $(this).children(".card-body").children(".fotoe").val());
        })

        $(".imsc").click(function(){
            if($(this).attr("src") == $(this).parent(".card").children(".card-body").children(".fotoe").val()){
                $(this).attr("src", $(this).parent(".card").children(".card-body").children(".fotos").val());
            }
            else{
                $(this).attr("src", $(this).parent(".card").children(".card-body").children(".fotoe").val());
            }
        })
    })
</script>