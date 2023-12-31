<?php
session_start();
include "config/config.php";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
  header("Location: login.php"); // Redirect to the login page
  exit();
}
// Fetch rooms from the database
$sql = "SELECT * FROM room";
$statement = $pdo->prepare($sql);
$statement->execute();
$rooms = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes - Admin - Rooms</title>
    <link rel="stylesheet" href="create_room_style.css" />
    <!-- Boxicons CSS -->
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  </head>
  <body>
    <nav class="sidebar hoverable">
      <div class="logo_items flex">
        <span class="logo_name">Notes</span>
        <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
        <i class="bx bx-x" id="sidebar-close"></i>
      </div>

      <div class="menu_container">
        <div class="menu_items">

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Zarządzaj</span>
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="admin_panel_users.php" class="link flex">
                <i class="bx bx-universal-access"></i>
                <span>Użytkownicy</span>
              </a>
            </li>
            <li class="item">
                <a href="admin_panel_admins.php" class="link flex">
                  <i class="bx bx-user-pin"></i>
                  <span>Admini</span>
                </a>
              </li>
              <li class="item">
                <a href="admin_panel_rooms.php" class="link flex">
                  <i class="bx bx-task"></i>
                  <span>Pokoje</span>
                </a>
              </li>
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
            <span class="admin">Admin</span><br>
            <span class="name"><?php echo $_SESSION['username'] ?> <br></span>
            <span class="email"><?php echo $_SESSION['mail'] ?></span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar -->
    <div class="tasks-section">
        <span class="title">Pokoje</span>
        <span class="line"></span>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th width="2%">Nr</th>
                  <th width="10%">Nazwa</th>
                  <th width="6%">Imie</th>
                  <th width="8%">Nazwisko</th>
                  <th width="8%">Email</th>
                  <th width="8%">login</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content">
            <table id="table" cellpadding="0" cellspacing="0" border="0">
              <tbody>
              <?php
              // Iterate over the rooms and generate table rows
              foreach ($rooms as $index => $room) {
                $roomId = $room['room_id'];
                $roomName = $room['room_name'];
                $userId = $room['user_id'];

                // Fetch user details for the associated user_id
                $userSql = "SELECT * FROM user WHERE user_id = :userId";
                $userStatement = $pdo->prepare($userSql);
                $userStatement->bindParam(':userId', $userId, PDO::PARAM_INT);
                $userStatement->execute();
                $user = $userStatement->fetch(PDO::FETCH_ASSOC);

                $userName = $user['name'];
                $userSurname = $user['surname'];
                $userMail = $user['mail'];
                $userUsername = $user['username'];
              ?>
                <tr>
                  <td width="2%"><?php echo $roomId; ?></td>
                  <td width="10%"><?php echo $roomName; ?></td>
                  <td width="6%"><?php echo $userName; ?></td>
                  <td width="8%"><?php echo $userSurname; ?></td>
                  <td width="8%"><?php echo $userMail; ?></td>
                  <td width="8%"><?php echo $userUsername; ?></td>
                </tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </section>
        <div class="btn-section">
            <div>
                <input type="submit" value="Edytuj pokój" onclick="popupEdit();">
            </div>
            <div>
                <input type="submit" value="Usuń pokój" id="delete-room-btn">
            </div>
        </div>
    </div>
    <div id="popupEdit">
      <div class="popup_container">
        <div class="text">
           Edytuj pokój
        </div>
        <form action="#" id="edit-room-form">
          <div class="form-row">
            <div class="input-data">
              <input type="text" id="edit-room-name" required>
              <div class="underline"></div>
              <label for="">Nazwa</label>
            </div>
          </div>
          <div class="form-row">
            <div class="input-data textarea">
              <div class="form-row submit-btn">
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="button" value="Akceptuj zmiany" onclick="updateRoom()">
                </div>
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="button" value="Anuluj" onclick="popupEdit()">
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>
    </div>
  
    <script src="create_room_js.js" defer></script>
    <script>
      // start select row function 
      function selectedRow() {
        var index,
          table = document.getElementById("table");
        var editRoomName = document.getElementById("edit-room-name");

        for (var i = 0; i < table.rows.length; i++) {
          table.rows[i].onclick = function () {
            if (typeof index !== "undefined") {
              table.rows[index].classList.toggle("selected");
            }
            index = this.rowIndex;
            this.classList.toggle("selected");

            // Populate form with selected row data
            editRoomName.value = this.cells[1].textContent;
          };
        }
      }
      selectedRow();

      function updateRoom() {
        var selectedRow = document.querySelector(".selected");
        if (selectedRow) {
          var roomId = selectedRow.cells[0].textContent;
          var editRoomName = document.getElementById("edit-room-name").value; // Retrieve the value from the form input
          var formData = new FormData();
          formData.append("room_id", roomId);
          formData.append("room_name", editRoomName); // Include the room name in the formData

          var xhr = new XMLHttpRequest();
          xhr.open("POST", "update_room.php", true);
          xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Handle the response here, if needed
              console.log(xhr.responseText);

              // Refresh the page or update the modified row
              window.location.reload();
            }
          };
          xhr.send(formData);
        }
      }
      
      document.getElementById("delete-room-btn").addEventListener("click", function() {
        var selectedRow = document.querySelector(".selected");
        if (selectedRow) {
          var roomId = selectedRow.cells[0].textContent;

          // Make an AJAX request to delete the task from the database
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "delete_room.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Handle the response here, if needed
              console.log(xhr.responseText);

              // Remove the selected row from the table
              selectedRow.remove();
            }
          };
          xhr.send("delete_room=" + encodeURIComponent(roomId));
        }
      });
    // end select row function 
    // popup Edit button 
    function popupEdit(){
      var popup = document.getElementById("popupEdit");
      popup.classList.toggle("active");
    }
    </script>
  </body>
</html>