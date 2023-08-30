<?php
// Start the session
session_start();
include "config/config.php";
// Create a new PDO instance
$pdo4 = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (!isset($_SESSION['username'])) {
  header("Location: login.php"); // Redirect to the login page
  exit();
}

// Prepare the SQL statement to fetch notes for the current user's room
$sql7 = "SELECT * FROM notes WHERE room_id IN (SELECT room_id FROM room WHERE user_id = :userId)";

// Bind the parameter
$statement = $pdo4->prepare($sql7);
$statement->bindParam(':userId', $_SESSION['user_id']);

// Execute the SQL statement
$statement->execute();

// Fetch all the rows as an associative array
$notes = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the form was submitted from the edit popup
  if (isset($_POST['edit_note'])) {
    $noteId = $_POST['notes_id'];
    $title = $_POST['title'];
    $note = $_POST['note'];

    // Prepare the SQL statement to update the note
    $sqlUpdate = "UPDATE notes SET title = :title, note = :note WHERE notes_id = :noteId";

    // Bind the parameters
    $statementUpdate = $pdo4->prepare($sqlUpdate);
    $statementUpdate->bindParam(':title', $title);
    $statementUpdate->bindParam(':note', $note);
    $statementUpdate->bindParam(':noteId', $noteId);

    // Execute the SQL statement
    $statementUpdate->execute();

    // Redirect to the same page after updating the note
    header("Location: notes_room.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes - Notatki</title>
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
         <?php include "rooms.php"; ?>
          <ul class="menu_item">
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Narzędzia</span>
              <span class="line"></span>
            </div>
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
                <a href="budget.php" class="link flex">
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
    <div class="tasks-section">
        <span class="title">Notatki</span>
        <span class="line"></span>
        <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th width="8%">Nr</th>
                    <th width="8%">Nazwa</th>
                    <th width="40%">Notatka</th>
                </tr>
            </thead>
        </table>
        </div>
        <div class="tbl-content">
            <table id="table" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php
                    $rowNumber = 1;
                    foreach ($notes as $note) {
                    ?>
                        <tr>
                            <td width="8%"><?php echo $note['notes_id']; ?></td>
                            <td width="8%"><?php echo $note['title']; ?></td>
                            <td width="40%"><?php echo $note['note']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="btn-section">
            <div>
                <input type="submit" value="Dodaj Notatke" onclick="popupAdd();">
            </div>
            <div>
                <input type="submit" value="Edytuj Notatkę" onclick="popupEdit();">
            </div>
            <div>
            <input type="submit" value="Usuń notatkę" id="delete-note-btn">
            </div> 
        </div>
        <div id="popupAdd">
            <div class="popup_container">
              <div class="text">
                 Dodaj notatkę
              </div>
              <form action="add_note.php" method="POST">
                <div class="form-row">
                    <div class="input-data">
                        <input type="text" name="title">
                        <div class="underline"></div>
                        <label for="">Nazwa</label>
                    </div>
                </div>
                <div class="form-row">
                    <textarea name="note">Some text...</textarea>
                </div>
                <div class="form-row">
                    <div class="input-data textarea">
                        <div class="form-row submit-btn">
                            <div class="input-data">
                                <div class="inner"></div>
                                <input type="submit" value="Dodaj notatkę">
                            </div>
                            <div class="input-data">
                                <div class="inner"></div>
                                <input type="submit" value="Anuluj" onclick="popupAdd();">
                            </div>
                        </div>
                    </div>
                </div>
              </form>
              </div>
          </div>
          <div id="popupEdit">
    <div class="popup_container">
      <div class="text">
        Edytuj notatkę
      </div>
      <form action="notes_room.php" method="POST">
        <div class="form-row">
          <div class="input-data">
            <input type="hidden" name="notes_id" id="notes_id"> <!-- Add hidden input field for notes_id -->
            <input type="text" name="title" id="edit_title">
            <div class="underline"></div>
            <label for="">Nazwa</label>
          </div>
        </div>
        <div class="form-row">
          <textarea name="note" id="edit_note"></textarea>
        </div>
        <div class="form-row">
          <div class="input-data textarea">
            <div class="form-row submit-btn">
              <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Akceptuj zmiany" name="edit_note">
              </div>
              <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Anuluj" onclick="popupEdit();">
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  
    <script src="create_room_js.js" defer></script>
    <script>
      document.getElementById("delete-note-btn").addEventListener("click", function() {
  var selectedRow = document.querySelector(".selected");
  if (selectedRow) {
    var noteId = selectedRow.cells[0].textContent;

    // Make an AJAX request to delete the task from the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_note.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle the response here, if needed
        console.log(xhr.responseText);

        // Remove the selected row from the table
        selectedRow.remove();
      }
    };
    xhr.send("delete_note=" + encodeURIComponent(noteId));
  }
});
    // start select row function 
    function fillForm(noteId, title, note) {
      document.getElementById("notes_id").value = noteId;
      document.getElementById("edit_title").value = title;
      document.getElementById("edit_note").value = note;
    }

    // Attach click event to each row to fill the form
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

          // Get the data from the selected row
          var noteId = this.cells[0].innerText;
          var title = this.cells[1].innerText;
          var note = this.cells[2].innerText;

          // Fill the form with the data
          fillForm(noteId, title, note);
        };
      }
    }
            selectedRow();
         // popup Edit button 
    function popupEdit(){
      var popup = document.getElementById("popupEdit");
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