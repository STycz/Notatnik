<?php
if (!file_exists("config/config.php")) 
{
   header("Location: setup.php");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style.css" type="text/css"/>
    <title>Notes - login</title>
  </head>
  <body>
    <div class="container">
        <div class="text">
           Notes<br><h1>Panel logowania</h1>
        </div>
        <form action="login.php" method="post">
         <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
         <?php } ?>
           <div class="form-row">
              <div class="input-data">
                 <input type="text" name="uname" required>
                 <div class="underline"></div>
                 <label for="">Adres Email</label>
              </div>
            </div>
            <div class="form-row">
              <div class="input-data">
                 <input type="text" name="password" required>
                 <div class="underline"></div>
                 <label for="">Hasło</label>
              </div>
           </div>
           <div class="form-row">
           <div class="input-data textarea">
              <div class="form-row submit-btn">
                 <div class="input-data">
                    <div class="inner"></div>
                    <input type="submit" value="Zaloguj">
                 </div>
                 <div class="item">
                     <a href="signup.php" class="ca">
                     <i class="bx bx-log-out"></i>
                     <span>Stwórz konto</span>
                     </a>
                  </div>
                  <div class="item">
                     <a href="tasks_guest.php" class="ca">
                     <i class="bx bx-log-out"></i>
                     <span>Gość</span>
                     </a>
                  </div>
              </div>
        </form>
        </div>

  </body>
</html>