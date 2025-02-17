<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="index.php">Сделаем лучше вместе!</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php
          if(!empty($_SESSION["id_user"])){
            if($_SESSION["id_role"] == 1){
              echo '
              <li class="nav-item">
                <a class="nav-link" href="lk.php">Личный кабинет</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="temp/exit.php">Выйти</a>
              </li>
            ';
            }
            if($_SESSION["id_role"] == 2){
              echo '
              <li class="nav-item">
                <a class="nav-link" href="category.php">Управление категориями</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="zayavki.php">Управление заявками</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="temp/exit.php">Выйти</a>
              </li>
            ';
            }
          }
          else{
            echo '
              <li class="nav-item">
                <a class="nav-link" href="registr.php">Регистрация</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="vizit.php">Вход</a>
              </li>
            ';
          }
        ?>
      </ul>
    </div>
  </div>
</nav>