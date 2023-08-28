<?php
session_start();
include "db_conn.php";

$pdo = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
  header("Location: login.php"); // Redirect to the login page
  exit();
}
// Fetch admins from the database
$sql = "SELECT * FROM user WHERE isadmin = 1";
$statement = $pdo->prepare($sql);
$statement->execute();
$admins = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes - Admin - Admins</title>
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
        <span class="title">Admini</span>
        <span class="line"></span>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th width="2%">Nr</th>
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
              <?php foreach ($admins as $index => $admin) {
                $adminId = $admin['user_id'];
                $name = $admin['name'];
                $surname = $admin['surname'];
                $username = $admin['username'];
                $mail = $admin['mail'];
                $password = $admin['password'];
              ?>
              <tr>
                <td width="2%"><?php echo $adminId; ?></td>
                <td width="5%"><?php echo $name; ?></td>
                <td width="6%"><?php echo $surname; ?></td>
                <td width="8%"><?php echo $username; ?></td>
                <td width="8%"><?php echo $mail; ?></td>
                <td width="8%"><?php echo $password; ?></td>
              </tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </section>
        <div class="btn-section">
            <div>
                <input type="submit" value="Dodaj admina" onclick="popupAdd();">
            </div>
            <div>
                <input type="submit" value="Edytuj admina" onclick="popupEdit();">
            </div>
            <div>
                <input type="submit" value="Usuń admina" id="delete-admin-btn">
            </div>
        </div>
    </div>
    <div id="popupAdd">
      <div class="popup_container">
        <div class="text">
           Dodaj admina
        </div>
        <form action="add_admin_check.php" method="post">
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
          Edytuj admina
        </div>
        <form action="update_admin.php" method="post">
          <div class="form-row">
            <div class="input-data">
              <input type="text" name="name" id="edit-name" required>
              <div class="underline"></div>
              <label for="">Imię</label>
            </div>
            <div class="input-data">
              <input type="text" name="nazwisko" id="edit-nazwisko" required>
              <div class="underline"></div>
              <label for="">Nazwisko</label>
            </div>
          </div>
          <div class="form-row">
            <div class="input-data">
              <input type="text" name="uname" id="edit-uname" required>
              <div class="underline"></div>
              <label for="">Adres Email</label>
            </div>
            <div class="input-data">
              <input type="text" name="username" id="edit-username" required>
              <div class="underline"></div>
              <label for="">Nazwa użytkownika</label>
            </div>
          </div>
          <div class="form-row">
            <div class="input-data">
              <input type="password" name="password" id="edit-password" required>
              <div class="underline"></div>
              <label for="">Hasło</label>
            </div>
          </div>
          <div class="form-row">
            <div class="input-data textarea">
              <div class="form-row submit-btn">
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="Akceptuj zmiany" onclick="updateAdmin(<?php echo $adminId; ?>)">
                  <input type="hidden" name="admin_id" value="<?php echo $adminId; ?>">
                </div>
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="button" value="Anuluj" onclick="popupEdit();">
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

        for (var i = 0; i < table.rows.length; i++) {
          table.rows[i].onclick = function () {
            if (typeof index !== "undefined") {
              table.rows[index].classList.toggle("selected");
            }
            index = this.rowIndex;
            this.classList.toggle("selected");

            // Populate form with selected row data
            document.getElementById("edit-name").value = this.cells[1].textContent;
            document.getElementById("edit-nazwisko").value = this.cells[2].textContent;
            document.getElementById("edit-uname").value = this.cells[4].textContent;
            document.getElementById("edit-username").value = this.cells[3].textContent;
            document.getElementById("edit-password").value = this.cells[5].textContent;
          };
        }
      }
      selectedRow();

      function updateAdmin(adminId) {
        var form = document.getElementById("admin-form");
        var formData = new FormData(form);
        
        // Remove the line below as it's unnecessary
        // formData.append("admin_id", adminId);
        
        // Append the adminId to the form action URL
        var actionUrl = "update_admin.php?admin_id=" + adminId;
        
        var xhr = new XMLHttpRequest();
        xhr.open("POST", actionUrl, true);
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

      document.getElementById("delete-admin-btn").addEventListener("click", function() {
        var selectedRow = document.querySelector(".selected");
        if (selectedRow) {
          var userId = selectedRow.cells[0].textContent;

          // Make an AJAX request to delete the task from the database
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "delete_admin.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Handle the response here, if needed
              console.log(xhr.responseText);

              // Remove the selected row from the table
              selectedRow.remove();
            }
          };
          xhr.send("delete_admin=" + encodeURIComponent(userId));
        }
      });
    // end select row function 
    // popup Edit button 
    function popupEdit() {
      var popup = document.getElementById("popupEdit");
      var selectedRow = document.querySelector(".selected");
      if (selectedRow) {
        var adminId = selectedRow.cells[0].textContent;
        popup.querySelector("form").action = "update_admin.php?admin_id=" + adminId;
      }
      popup.classList.toggle("active");
    }
   // popup Add button 
   function popupAdd(){
      var popupadd = document.getElementById("popupAdd");
      popupadd.classList.toggle("active");
    }
    </script>
  </body>
</html>