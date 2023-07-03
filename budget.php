<?php
// Start the session
session_start();
include "db_conn.php";

// Create a new PDO instance
$pdo5 = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

// Prepare the SQL statement to fetch budget rows for the current user's room
$sql8 = "SELECT * FROM budget WHERE room_id IN (SELECT room_id FROM room WHERE user_id = :userId)";

// Bind the parameter
$statement = $pdo5->prepare($sql8);
$statement->bindParam(':userId', $_SESSION['user_id']);

// Execute the SQL statement
$statement->execute();

// Fetch all the rows as an associative array
$budgetRows = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                foreach ($budgetRows as $row) {
                ?>
                    <tr>
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
                <input type="submit" value="Usuń Kwotę">
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
                       <label for="">Data</label>
                    </div>
                 </div>
                 <div class="form-row">
                    <div class="input-data">
                       <input type="number">
                       <div class="underline"></div>
                       <label for="">Kwota</label>
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
    // sum table

    var tableSum = document.getElementById("table"), sumVal = 0;
    for (let i = 0; i < table.rows.length; i++) {
        sumVal = sumVal + parseFloat(table.rows[i].cells[2].innerHTML);
        
    }
    document.getElementById("budget_sum").innerHTML = "Saldo: " + sumVal + "zł";
    console.log(sumVal);
    </script>
  </body>
</html>