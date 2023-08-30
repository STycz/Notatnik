<?php
session_start();
include "config/config.php";
                      
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
  header("Location: login.php"); // Redirect to the login page
  exit();
}
// Fetch users from the database
$sql = "SELECT * FROM user";
$statement = $pdo->prepare($sql);
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes - Admin - Users</title>
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
            <span class="admin">Admin</span><br>
            <span class="name"><?php echo $_SESSION['username'] ?> <br></span>
            <span class="email"><?php echo $_SESSION['mail'] ?></span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar -->
    <div class="tasks-section">
        <span class="title">Użytkownicy</span>
        <span class="line"></span>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th width="2%">ID</th>
                  <th width="5%">Imie</th>
                  <th width="6%">Nazwisko</th>
                  <th width="8%">Nazwa użytkownika</th>
                  <th width="8%">Email</th>
                  <th width="8%">Hasło</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content">
            <table id="table" cellpadding="0" cellspacing="0" border="0">
              <tbody>
              <?php
              
                // Iterate over the users and generate table rows
                foreach ($users as $index => $user) {
                  $userId = $user['user_id'];
                  $name = $user['name'];
                  $surname = $user['surname'];
                  $username = $user['username'];
                  $mail = $user['mail'];
                  $password = $user['password'];
              ?>
              <tr>
                <td width="2%"><?php echo $userId; ?></td>
                <td width="5%"><?php echo $name; ?></td>
                <td width="6%"><?php echo $surname; ?></td>
                <td width="8%"><?php echo $username; ?></td>
                <td width="8%"><?php echo $mail; ?></td>
                <td width="8%"><?php echo $password; ?></td>
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
                <input type="submit" value="Dodaj użytkownika" onclick="popupAdd();">
            </div>
            <div>
                <input type="submit" value="Edytuj użytkownika" onclick="popupEdit();">
            </div>
            <div>
                <input type="submit" value="Usuń użytkownika" id="delete-user-btn">
            </div>
        </div>
    </div>
    <div id="popupAdd">
      <div class="popup_container">
        <div class="text">
           Dodaj użytkownika
        </div>
        <form action="add_user_check.php" method="post">
            <div class="form-row">
                <div class="input-data">
                   <input type="text" name="name" required>
                   <div class="underline"></div>
                   <label for="">Imię</label>
                </div>
                <div class="input-data">
                   <input type="text" name="nazwisko" required>
                   <div class="underline"></div>
                   <label for="">Nazwisko</label>
                </div>
             </div>
             <div class="form-row">
                <div class="input-data">
                  <input type="text" name="uname" required>
                   <div class="underline"></div>
                   <label for="">Adres Email</label>
                </div>
                <div class="input-data">
                   <input type="text" name="username" required>
                   <div class="underline"></div>
                   <label for="">Nazwa użytkownika</label>
                </div>
             </div>
             <div class="form-row">
              <div class="input-data">
                 <input type="password" name="password" required>
                 <div class="underline"></div>
                 <label for="">Hasło</label>
               </div>
             </div>
           <div class="form-row">
           <div class="input-data textarea">
            <div class="form-row submit-btn">
                <div class="input-data">
                   <div class="inner"></div>
                   <input type="submit" value="Dodaj">
                </div>
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="Anuluj" onclick="popupAdd();">
               </div>
             </div>
            </div>
        </form>
        </div>
    </div>
    <div id="popupEdit">
      <div class="popup_container">
        <div class="text">
          Edytuj użytkownika
        </div>
        <form action="update_user.php" method="POST" id="editForm">
  <div class="form-row">
    <div class="input-data">
      <input type="text" name="name" id="editName" required>
      <div class="underline"></div>
      <label for="">Imię</label>
    </div>
    <div class="input-data">
      <input type="text" name="surname" id="editSurname" required>
      <div class="underline"></div>
      <label for="">Nazwisko</label>
    </div>
  </div>
  <div class="form-row">
    <div class="input-data">
      <input type="text" name="mail" id="editMail" required>
      <div class="underline"></div>
      <label for="">Adres Email</label>
    </div>
    <div class="input-data">
      <input type="text" name="username" id="editUsername" required>
      <div class="underline"></div>
      <label for="">Nazwa użytkownika</label>
    </div>
  </div>
  <div class="form-row">
    <div class="input-data">
      <input type="password" name="password" id="editPassword" required>
      <div class="underline"></div>
      <label for="">Hasło</label>
    </div>
  </div>
  <div class="form-row">
    <div class="input-data textarea">
      <div class="form-row submit-btn">
        <div class="input-data">
          <div class="inner"></div>
          <input type="submit" value="Akceptuj zmiany">
        </div>
        <div class="input-data">
          <div class="inner"></div>
          <input type="button" value="Anuluj" onclick="popupEdit();">
        </div>
      </div>
    </div>
  </div>
  <!-- Hidden input field to store the user ID -->
  <input type="hidden" name="user_id" id="editUserId" value="">
</form>
      </div>
    </div>
  
    <script src="create_room_js.js" defer></script>
    <script>
      // start select row function 
      function selectedRow() {
        var index,
          table = document.getElementById("table");

        for (var i = 0; i < table.rows.length; i++) {
          table.rows[i].onclick = function () {
            // remove the background from the previous selected row
            if (typeof index !== "undefined") {
              table.rows[index].classList.toggle("selected");
            }
            // get the selected row index
            index = this.rowIndex;
            // add class selected to the row
            this.classList.toggle("selected");

            // Populate the form fields with data from the selected row
            var userId = this.cells[0].textContent;
            var name = this.cells[1].textContent;
            var surname = this.cells[2].textContent;
            var mail = this.cells[4].textContent;
            var username = this.cells[3].textContent;
            var password = this.cells[5].textContent;

            document.getElementById("edit-user-form").setAttribute("data-user-id", userId);
            document.getElementById("name-input").value = name;
            document.getElementById("surname-input").value = surname;
            document.getElementById("mail-input").value = mail;
            document.getElementById("username-input").value = username;
            document.getElementById("password-input").value = password;
          };
        }
      }
            
      selectedRow();

      

      document.getElementById("delete-user-btn").addEventListener("click", function() {
        var selectedRow = document.querySelector(".selected");
        if (selectedRow) {
          var userId = selectedRow.cells[0].textContent;

          // Make an AJAX request to delete the task from the database
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "delete_user.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Handle the response here, if needed
              console.log(xhr.responseText);

              // Remove the selected row from the table
              selectedRow.remove();
            }
          };
          xhr.send("delete_user=" + encodeURIComponent(userId));
        }
      });
    // end select row function 
    // popup Edit button 
    function popupEdit() {
      var popup = document.getElementById("popupEdit");
      popup.classList.toggle("active");

      // Fill the form with data from the selected row
      var selectedRow = document.querySelector(".selected");
      if (selectedRow) {
        var userId = selectedRow.cells[0].textContent;
        var name = selectedRow.cells[1].textContent;
        var surname = selectedRow.cells[2].textContent;
        var username = selectedRow.cells[3].textContent;
        var mail = selectedRow.cells[4].textContent;
        var password = selectedRow.cells[5].textContent;

        // Set the form input values
        document.getElementById("editUserId").value = userId;
        document.getElementById("editName").value = name;
        document.getElementById("editSurname").value = surname;
        document.getElementById("editMail").value = mail;
        document.getElementById("editUsername").value = username;
        document.getElementById("editPassword").value = password;
      }
    }
   // popup Add button 
   function popupAdd(){
      var popupadd = document.getElementById("popupAdd");
      popupadd.classList.toggle("active");
    }
    </script>
  </body>
</html>