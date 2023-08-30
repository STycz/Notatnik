<?php
// Start the session
session_start();
include "config/config.php";

// Create a new PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (!isset($_SESSION['username'])) {
  header("Location: login.php"); // Redirect to the login page
  exit();
}

// Prepare the SQL statement to fetch budget rows for the current user's room
$sql = "SELECT * FROM budget WHERE room_id IN (SELECT room_id FROM room WHERE user_id = :userId)";

// Bind the parameter
$statement = $pdo->prepare($sql);
$statement->bindParam(':userId', $_SESSION['user_id']);

// Execute the SQL statement
$statement->execute();

// Fetch all the rows as an associative array
$budgetRows = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the form was submitted from the edit popup
  if (isset($_POST['edit_budget'])) {
    $budgetId = $_POST['budget_id'];
    $name = $_POST['name'];
    $value = $_POST['value'];
    $date = $_POST['date'];

    // Prepare the SQL statement to update the budget
    $sqlUpdate = "UPDATE budget SET name = :name, value = :value, date = :date WHERE budget_id = :budgetId";

    // Bind the parameters
    $statementUpdate = $pdo->prepare($sqlUpdate);
    $statementUpdate->bindParam(':name', $name);
    $statementUpdate->bindParam(':value', $value);
    $statementUpdate->bindParam(':date', $date);
    $statementUpdate->bindParam(':budgetId', $budgetId);

    // Execute the SQL statement
    $statementUpdate->execute();

    
    // Redirect to the same page after updating the budget
    header("Location: budget_php.php");
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
    <title>Notes - Budżet</title>
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
        <span class="title">Budżet</span>
        <span class="line"></span>
        <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th width="4%">ID</th>
                <th width="8%">Nazwa</th>
                <th width="8%">Data</th>
                <th width="40%">Kwota</th>
            </tr>
        </thead>
    </table>
    </div>
    <div class="tbl-content">
        <table id="table" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <?php
                $rowNumber = 1;
                foreach ($budgetRows as $row) {
                ?>
                    <tr>
                      <td width="4%"><?php echo $row['budget_id']; ?></td>
                      <td width="8%"><?php echo $row['name']; ?></td>
                      <td width="8%"><?php echo $row['date']; ?></td>
                      <td width="40%"><?php echo $row['value']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </section>
        <div id="budget_sum">
            Saldo
        </div>
        <div class="btn-section">
            <div>
                <input type="submit" value="Dodaj Kwotę" onclick="popupAdd();">
            </div>
            <div>
                <input type="submit" value="Edytuj Kwotę" onclick="popupEdit();">
            </div>
            <div>
                <input type="submit" value="Usuń kwotę" id="delete-budget-btn">
            </div>
        </div>
        <div id="popupAdd">
            <div class="popup_container">
              <div class="text">
                 Dodaj Kwotę
              </div>
              <form action="add_budget.php" method="POST">
                <div class="form-row">
                    <div class="input-data">
                        <input type="text" name="name">
                        <div class="underline"></div>
                        <label for="">Nazwa</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-data">
                        <input type="text" name="date">
                        <div class="underline"></div>
                        <label for="">Data</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-data">
                        <input type="number" name="value">
                        <div class="underline"></div>
                        <label for="">Kwota</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-data textarea">
                        <div class="form-row submit-btn">
                            <div class="input-data">
                                <div class="inner"></div>
                                <input type="submit" value="Dodaj Kwotę">
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
                 Edytuj kwotę
              </div>
              <form action="budget.php" method="POST">
                <div class="form-row">
                    <div class="input-data">
                       <input type="hidden" name="budget_id" id="budget_id">
                       <input type="text" name="name" id="edit_name">
                       <div class="underline"></div>
                       <label for="">Nazwa</label>
                    </div>
                 </div>
                 <div class="form-row">
                    <div class="input-data">
                       <input type="text" name="date" id="edit_date">
                       <div class="underline"></div>
                       <label for="">Data</label>
                    </div>
                 </div>
                 <div class="form-row">
                    <div class="input-data">
                       <input type="number" name="value" id="edit_value">
                       <div class="underline"></div>
                       <label for="">Kwota</label>
                    </div>
                 </div>
                 <div class="form-row">
                 <div class="input-data textarea">
                  <div class="form-row submit-btn">
                      <div class="input-data">
                         <div class="inner"></div>
                         <input type="submit" value="Akceptuj zmiany" name="edit_budget">
                      </div>
                      <div class="input-data">
                        <div class="inner"></div>
                        <input type="submit" value="Anuluj" onclick="popupEdit();">
                     </div>
                   </div>
                  </div>
              </form>
              </div>
          </div>
    </div>
  
    <script src="create_room_js.js" defer></script>
    <script>
    document.getElementById("delete-budget-btn").addEventListener("click", function() {
  var selectedRow = document.querySelector(".selected");
  if (selectedRow) {
    var budgetId = selectedRow.cells[0].textContent;

    // Make an AJAX request to delete the task from the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_budget.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle the response here, if needed
        console.log(xhr.responseText);

        // Remove the selected row from the table
        selectedRow.remove();
      }
    };
    xhr.send("delete_budget=" + encodeURIComponent(budgetId));
  }
});
    // start select row function 
    function fillForm(budgetId, name, date, value) {
      document.getElementById("budget_id").value = budgetId;
      document.getElementById("edit_name").value = name;
      document.getElementById("edit_date").value = date;
      document.getElementById("edit_value").value = value;
    }
    
    function selectedRow() {
      var index,
        table = document.getElementById("table");

      for (var i = 0; i < table.rows.length; i++) {
        table.rows[i].onclick = function () {
          // remove the background from the previously selected row
          if (typeof index !== "undefined") {
            table.rows[index].classList.toggle("selected");
          }
          // get the selected row index
          index = this.rowIndex;
          // add class selected to the row
          this.classList.toggle("selected");

          var budgetId = this.cells[0].innerText;
          var name = this.cells[1].innerText;
          var date = this.cells[2].innerText;
          var value = this.cells[3].innerText;

          // Fill the form with the data
          fillForm(budgetId, name, date, value);
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
    // sum table

    var tableSum = document.getElementById("table"), sumVal = 0;
    for (let i = 0; i < table.rows.length; i++) {
        sumVal = sumVal + parseFloat(table.rows[i].cells[3].innerHTML);
        
    }
    document.getElementById("budget_sum").innerHTML = "Saldo: " + sumVal + "zł";
    console.log(sumVal);
    </script>
  </body>
</html>