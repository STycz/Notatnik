<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['mail'])){

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes - stwórz pokój</title>
    <link rel="stylesheet" href="create_room_style.css" />
    <!-- Boxicons CSS -->
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="create_room_js.js" defer></script>
  </head>
  <body>
    <nav class="sidebar locked">
      <div class="logo_items flex">
        <span class="logo_name">Notes</span>
        <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
        <i class="bx bx-x" id="sidebar-close"></i>
      </div>

      <div class="menu_container">
        <div class="menu_items">
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Pokoje</span>
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-home-alt"></i>
                <span>Pierwszy pokój</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Narzędzia</span>
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-task"></i>
                <span>Zadania</span>
              </a>
            </li>
            <li class="item">
                <a href="#" class="link flex">
                  <i class="bx bx-pen"></i>
                  <span>Notatki</span>
                </a>
              </li>
              <li class="item">
                <a href="#" class="link flex">
                  <i class="bx bx-money"></i>
                  <span>Budżet</span>
                </a>
              </li>
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Ustawienia</span>
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-cog"></i>
                <span>Ustawienia</span>
              </a>
            </li>
            <li class="item">
              <a href="logout.php" class="link flex">
                <i class="bx bx-log-out"></i>
                <span>Wyloguj</span>
              </a>
            </li>
          </ul>
        </div>

        <div class="sidebar_profile flex">
          <div class="data_text">
            <span class="name">Imie Nazwisko</span>
            <span class="email">imienazwisko@gmail.com</span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar -->
    <div class="room-add">
        <i class="bx bx-plus-circle"></i>
        <div>
            <input class="create-btn" type="submit" value="Stwórz pokój">
        </div>
    </div>
  </body>
</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>