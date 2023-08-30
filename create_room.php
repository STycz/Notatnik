<?php
session_start();
include "config/config.php";


if (isset($_SESSION['user_id']) && isset($_SESSION['mail'])){
  $pdo2 = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

  // Prepare the SQL statement to check if the user has a room
  $sql5 = "SELECT COUNT(*) as room_count FROM room WHERE user_id = :userId";
  
  // Bind the parameter
  $statement = $pdo2->prepare($sql5);
  $statement->bindParam(':userId', $_SESSION['user_id']);
  
  // Execute the SQL statement
  $statement->execute();
  
  // Fetch the result
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  $hasRoom = ($result['room_count'] > 0);
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
          <?php include "rooms.php"; ?>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Narzędzia</span>
              <span class="line"></span>
            </div>
            <?php 
            if ($hasRoom) { ?> 
            <li class="item">
              <a href="tasks.php" class="link flex">
                <i class="bx bx-task"></i>
                <span>Zadania</span>
              </a>
            </li>
            <li class="item">
                <a href="notes_room.php" class="link flex">
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
              <?php } ?>
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Ustawienia</span>
              <span class="line"></span>
            </div>
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
            <span class="name"><?php echo $_SESSION['username'] ?> <br> </span>
            <span class="email"><?php echo $_SESSION['mail'] ?></span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar -->
    <?php 
    if (!$hasRoom) { ?> 
    <div class="room-add">
        <i class="bx bx-plus-circle"></i>
        <div>
            <input class="create-btn" type="submit" value="Stwórz pokój" onclick="popupCreateRoom();">
        </div>
    </div>
    <div id="popupEdit">
      <div class="popup_container">
        <div class="text">
           Nazwa pokoju
        </div>
        <form action="add_room.php" method="post">
             <div class="form-row">
              <div class="input-data">
                  <input type="text" name="nazwa_pokoju" required>
                  <div class="underline"></div>
                  <label for="">Nazwa</label>
               </div>
             </div>
           <div class="form-row">
           <div class="input-data textarea">
            <div class="form-row submit-btn">
                <div class="input-data">
                   <div class="inner"></div>
                   <input type="submit" value="Stwórz pokój">
                </div>
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="Anuluj" onclick="popupCreateRoom();">
               </div>
             </div>
            </div>
        </form>
        </div>
    </div>
    <script>
    function popupCreateRoom(){
      var popup = document.getElementById("popupEdit");
      popup.classList.toggle("active");
    }

    </script>
    
    <?php } ?>
    
  </body>
</html>

<?php
}else{
    header("Location: index.php");
    exit();
}
?>