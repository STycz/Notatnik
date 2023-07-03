<?php
// Start the session
session_start();
include "db_conn.php";
// Create a new PDO instance
$pdo4 = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

// Prepare the SQL statement to fetch notes for the current user's room
$sql7 = "SELECT * FROM notes WHERE room_id IN (SELECT room_id FROM room WHERE user_id = :userId)";

// Bind the parameter
$statement = $pdo4->prepare($sql7);
$statement->bindParam(':userId', $_SESSION['user_id']);

// Execute the SQL statement
$statement->execute();

// Fetch all the rows as an associative array
$notes = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                    <th width="2%">Nr</th>
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
                            <td width="2%"><?php echo $rowNumber++; ?></td>
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
                <input type="submit" value="Usuń Notatkę">
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
                 Edytuj zadanie
              </div>
              <form action="#">
                 <div class="form-row">
                    <div class="input-data">
                       <input type="text">
                       <div class="underline"></div>
                       <label for="">Nazwa</label>
                    </div>
                 </div>
                 <div class="form-row">
                    <div class="input-data">
                       <input type="text">
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
                  <textarea>Some text...</textarea>
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
    // start select row function 
      function selectedRow(){
                
                var index,
                    table = document.getElementById("table");
            
                for(var i = 0; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                        if(typeof index !== "undefined"){
                           table.rows[index].classList.toggle("selected");
                        }
                        // get the selected row index
                        index = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle("selected");
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