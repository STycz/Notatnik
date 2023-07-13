<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notes - Gość</title>
  <link rel="stylesheet" href="create_room_style.css" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
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
            <span class="name">Gość</span>
          </div>
        </div>
      </div>
  </nav>

  <div class="tasks-section">
    <span class="title">Zadania</span>
    <span class="line"></span>
    <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th width="2%">Nr</th>
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
        <tbody id="tableBody">
          <!-- Table rows will be dynamically added here -->
        </tbody>
      </table>
    </div>
    <div class="btn-section">
      <div>
        <input type="submit" value="Dodaj zadanie" onclick="popupAdd();">
    </div>
    </div>
  </div>

  <div id="popupAdd">
    <div class="popup_container">
      <div class="text">
        Dodaj zadanie
      </div>
      <form onsubmit="addTask(); return false;">
        <div class="form-row">
          <div class="input-data">
            <input type="text" name="nazwa" required>
            <div class="underline"></div>
            <label for="nazwa">Nazwa</label>
          </div>
        </div>
        <div class="form-row">
          <div class="input-data">
            <input type="text" name="deadline" required>
            <div class="underline"></div>
            <label for="deadline">Deadline</label>
          </div>
          <div class="input-data">
            <div class="underline"></div>
            <label for="priority">Priorytet</label>
            <select id="priority" name="priority" required>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <textarea name="notatka" required></textarea>
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
        </div>
      </form>
    </div>
  </div>

  <div id="popupEdit">
    <div class="popup_container">
      <!-- Popup Edit content here -->
    </div>
  </div>

  <script>
  

    // Function to show the "Add" popup
    function popupAdd() {
      const popupAdd = document.getElementById("popupAdd");
      popupAdd.classList.toggle("active");
    }

    // Function to show the "Edit" popup
    function popupEdit() {
      const popupEdit = document.getElementById("popupEdit");
      popupEdit.classList.toggle("active");
    }
    function addTask() {
    var tableBody = document.getElementById("tableBody");

    var nazwa = document.querySelector("input[name='nazwa']").value;
    var deadline = document.querySelector("input[name='deadline']").value;
    var priorytet = document.querySelector("select[name='priority']").value;
    var notatka = document.querySelector("textarea[name='notatka']").value;

    var nr = tableBody.rows.length + 1;

    var newRow = document.createElement("tr");
    var nrCell = document.createElement("td");
    var nazwaCell = document.createElement("td");
    var notatkaCell = document.createElement("td");
    var deadlineCell = document.createElement("td");
    var priorytetCell = document.createElement("td");
    var zrobioneCell = document.createElement("td");

    nrCell.style.width = "2%";
    nazwaCell.style.width = "8%";
    notatkaCell.style.width = "30%";
    deadlineCell.style.width = "5%";
    priorytetCell.style.width = "5%";
    zrobioneCell.style.width = "5%";

    nrCell.innerHTML = nr;
    nazwaCell.innerHTML = nazwa;
    notatkaCell.innerHTML = notatka;
    deadlineCell.innerHTML = deadline;
    priorytetCell.innerHTML = priorytet;

    var checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.name = 'zrobione';
    zrobioneCell.appendChild(checkbox);

    newRow.appendChild(nrCell);
    newRow.appendChild(nazwaCell);
    newRow.appendChild(notatkaCell);
    newRow.appendChild(deadlineCell);
    newRow.appendChild(priorytetCell);
    newRow.appendChild(zrobioneCell);

    tableBody.appendChild(newRow);

    document.querySelector('#popupAdd form').reset();
    popupAdd()
}
    
  </script>
</body>
</html>
