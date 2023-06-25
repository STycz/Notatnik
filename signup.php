<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style.css" type="text/css"/>
    <title>Notes - stwórz konto</title>
  </head>
  <body>
    <div class="container">
        <div class="text">
           Tworzenie konta
        </div>
        <form action="signup-check.php" method="post">
         <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
         <?php }?>

         <?php if(isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
         <?php }?>

         <?php if(isset($_GET['name'])) { ?>
            <p class="error"><?php echo $_GET['name']; ?></p>
         <?php } ?>
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
                   <input type="submit" value="Stwórz konto">
                </div>
             </div>
             <div class="item">
                     <a href="index.php" class="ca">
                     <i class="bx bx-log-out"></i>
                     <span>Masz już konto?</span>
                     </a>
                  </div>
            </div>
        </form>
        </div>
  </body>
</html>