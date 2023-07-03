<?php
session_start();
include "db_conn.php";

$pdo3 = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

// Check if the "Usuń zadanie" button is clicked
if (isset($_POST['delete_task'])) {
  $taskId = $_POST['delete_task'];

  $sql = "DELETE FROM task WHERE task_id = :taskId";
  $statement = $pdo3->prepare($sql);
  $statement->bindParam(':taskId', $taskId);
  $statement->execute();
}

$sql6 = "SELECT * FROM task WHERE room_id IN (SELECT room_id FROM room WHERE user_id = :userId)";
$statement = $pdo3->prepare($sql6);
$statement->bindParam(':userId', $_SESSION['user_id']);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notes - zadania</title>
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
    <span class="title">Zadania</span>
    <span class="line"></span>
    <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th width="2%">Nr</th>
                    <th width="5%">Task ID</th> <!-- New column for task_id -->
                    <th width="8%">Nazwa</th>
                    <th width="30%">Notatka</th>
                    <th width="5%">Deadline</th>
                    <th width="5%">Priorytet</th>
                    <th width="5%">Zrobione</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="tbl-content">
        <table id="table" cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <?php
            $rowNumber = 1;
            foreach ($tasks as $task) {
                $isChecked = ($task['isdone'] == 1) ? 'checked' : '';
                ?>
                <tr>
                    <td width="2%"><?php echo $rowNumber++; ?></td>
                    <td width="5%"><?php echo $task['task_id']; ?></td> <!-- Display task_id column -->
                    <td width="8%"><?php echo $task['name']; ?></td>
                    <td width="30%"><?php echo $task['note']; ?></td>
                    <td width="5%"><?php echo $task['deadline']; ?></td>
                    <td width="5%"><?php echo $task['priority']; ?></td>
                    <td width="5%">
                        <input type="checkbox" <?php echo $isChecked; ?> disabled>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
        <div class="btn-section">
            <div>
                <input type="submit" value="Dodaj zadanie" onclick="popupAdd();">
            </div>
            <div>
                <input type="submit" value="Edytuj zadanie" onclick="popupEdit();">
            </div>
            <div>
            <button type="button" id="delete-task-btn">Usuń zadanie</button>
            </div>
        </div>
    </div>
    <div id="popupAdd">
      <div class="popup_container">
        <div class="text">
           Dodaj zadanie
        </div>
        <form action="add_task.php" method="POST">
           <div class="form-row">
              <div class="input-data">
                 <input type="text" name="nazwa">
                 <div class="underline"></div>
                 <label for="">Nazwa</label>
              </div>
           </div>
           <div class="form-row">
              <div class="input-data">
                 <input type="text" name="deadline">
                 <div class="underline"></div>
                 <label for="">Deadline</label>
              </div>
              <div class="input-data">
                 <div class="underline"></div>
                 <label for="">Priorytet</label>
                 <select id="priority" name="priority">
                  <option value=1 >1</option>
                  <option value=2 >2</option>
                  <option value=3 >3</option>
                  <option value=4 >4</option>
                  <option value=5 >5</option>
                </select>
              </div>
           </div>
           <div class="form-row">
            <textarea name="notatka"></textarea>
           </div>
           <div class="form-row submit-btn">
           <div class="input-data textarea">
            <div class="form-row submit-btn">
                <div class="input-data">
                   <div class="inner"></div>
                   <input type="submit" value="Dodaj zadanie">
                </div>
                <div class="input-data">
                  <div class="inner"></div>
                  <input type="button" value="Anuluj" onclick="popupAdd();">
               </div>
             </div>
            </div>
        </form>
        </div>
    </div>
    
    <div id="popupEdit">
  <div class="popup_container">
    <div class="text">
      Edytuj zadanie
    </div>
    <form action="update_task.php" method="POST">
        <?php
        // Retrieve the task details
        $taskId = $task['task_id'];
        $name = $task['name'];
        $note = $task['note'];
        $deadline = $task['deadline'];
        $priority = $task['priority'];
        ?>
        <!-- Hidden input field for task_id -->
        <input name="task_id" value="<?php echo $taskId; ?>">

        
        <div class="form-row">
            <div class="input-data">
                <input type="text" name="nazwa" value="<?php echo $name; ?>">
                <div class="underline"></div>
                <label for="">Nazwa</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input type="text" name="deadline" value="<?php echo $deadline; ?>">
                <div class="underline"></div>
                <label for="">Deadline</label>
            </div>
            <div class="input-data">
                <div class="underline"></div>
                <label for="">Priorytet</label>
                <select id="priority" name="priority">
                    <option value="1" <?php if ($priority == 1) echo 'selected'; ?>>1</option>
                    <option value="2" <?php if ($priority == 2) echo 'selected'; ?>>2</option>
                    <option value="3" <?php if ($priority == 3) echo 'selected'; ?>>3</option>
                    <option value="4" <?php if ($priority == 4) echo 'selected'; ?>>4</option>
                    <option value="5" <?php if ($priority == 5) echo 'selected'; ?>>5</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <textarea name="notatka"><?php echo $note; ?></textarea>
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

      // get the task_id from the selected row
      var taskId = this.cells[1].textContent; // Use textContent instead of innerHTML

      // store the task_id in a hidden input field for later use
      document.getElementById("selected-task-id").value = taskId;

      // fill the form with the selected row's values
      var name = this.cells[2].textContent; // Use textContent instead of innerHTML
      var note = this.cells[3].textContent; // Use textContent instead of innerHTML
      var priority = this.cells[5].textContent; // Use textContent instead of innerHTML
      var deadline = this.cells[4].textContent; // Use textContent instead of innerHTML

      document.getElementById("nazwa").value = name;
      document.getElementById("notatka").value = note;
      document.getElementById("priority").value = priority;
      document.getElementById("deadline").value = deadline;
    };
  }
}
// end select row function
// popup Edit button
function popupEdit() {
  var popup = document.getElementById("popupEdit");
  popup.classList.toggle("active");

  var selectedRow = document.querySelector(".selected");
  if (selectedRow) {
    // Populate the "popupEdit" form with data from the selected row
    var selectedRowData = selectedRow.cells;
    var popupEditForm = document.getElementById("popupEdit").querySelector("form");
    popupEditForm.querySelector('input[name="task_id"]').value = selectedRowData[1].innerText;
    popupEditForm.querySelector('input[name="nazwa"]').value = selectedRowData[2].innerText;
    popupEditForm.querySelector('textarea').value = selectedRowData[3].innerText;
    popupEditForm.querySelector('input[name="deadline"]').value = selectedRowData[4].innerText;
    popupEditForm.querySelector('select[name="priority"]').value = selectedRowData[5].innerText;

    // Add event listener to the form's submit button
    var submitButton = popupEditForm.querySelector('input[type="submit"]');
    submitButton.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent form submission

      // Get the form data
      var formData = new FormData(popupEditForm);

      // Make an AJAX request to update the row in the database
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "update_task.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Handle the response here, if needed
          console.log(xhr.responseText);
        }
      };
      xhr.send(formData);
    });
  }
}

// popup Add button
function popupAdd() {
  var popupadd = document.getElementById("popupAdd");
  popupadd.classList.toggle("active");
}

// Call the selectedRow function to enable row selection
selectedRow();
document.getElementById("delete-task-btn").addEventListener("click", function() {
  var selectedRow = document.querySelector(".selected");
  if (selectedRow) {
    var taskId = selectedRow.cells[1].textContent;

    // Make an AJAX request to delete the task from the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_task.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle the response here, if needed
        console.log(xhr.responseText);

        // Remove the selected row from the table
        selectedRow.remove();
      }
    };
    xhr.send("delete_task=" + encodeURIComponent(taskId));
  }
});
    </script>
  </body>
</html>