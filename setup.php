<?php
$config_file = "../config/config.php";

$sql_file = "../config/sql.php";

$sql_insert_file = "../config/sql_insert.php";



if(isset($_GET['step'])) {
    $step = $_GET['step'];
} else {
    $step = 0;
}

switch($GLOBALS["step"]){

    case 1:
        form_install_1();
    break;

    case 2:
        form_install_2();
    break;

    case 3:
        form_install_3();
    break;

    case 4:
        form_install_4();
    break;

    case 5:
        form_install_5();
    break;
    case 6:
        form_install_6();
    break;
    case 7:
        form_install_7();
    break;

    default:
        if(file_exists('config/config.php')){
            if(is_writable('config/config.php')){
            $step = 1;
            form_install_1();
            } else {
            echo "<p>Zmień uprawnienia do pliku <code>".'config/config.php'."</code><br>np. <code>chmod o+w ".'config/config.php'."</code></p>";
            echo "<p><button class=`btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
            }
        }else{
            echo "<p>Stwórz plik <code>".'config/config.php'."</code><br>np. <code>touch ".'config/config.php'."</code></p>";
            echo "<p><button class=`btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
        }
    break;
}

function form_install_1() {
    echo "<h1> Instalator :: krok: 1 </h1>
          <h2> Instalacja serwisu </h2>
          <form method='POST' action='?step=2'>
            <label for='server'> Nazwa lub adres serwera </label>
            <input type='text' id='server' name='server'>
            <label for='db'> Nazwa bazy danych </label>
            <input type='text' id='db' name='db'>
            <label for='user'> Nazwa użytkownika </label>
            <input type='text' id='user' name='user'>
            <label for='password'> Hasło </label>
            <input type='password' id='password' name='password'>
            <label for='prefix'> Prefix tabeli </label>
            <input type='text' id='prefix' name='prefix'>
            <input type='submit' value='Krok 2'>
          </form>";
}

function form_install_2() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $file=fopen('config/config.php',"w");
        $config = "<?php
        \$host=\"".$_POST['server']."\";
        \$user=\"".$_POST['user']."\";
        \$password=\"".$_POST['password']."\";
        \$dbname=\"".$_POST['db']."\";
        \$prefix=\"".$_POST['prefix']."\";\n
        \$link = mysqli_connect(\$host, \$user, \$password, \$dbname);\n;
        ?>";
        if (!fwrite($file, $config)) { 
            print "Nie mogę zapisać do pliku ($file)"; 
            exit; 
        } 
        if(file_exists('config/config.php')){
            include('config/config.php');
        }
        echo "<p>Krok 2 zakończony: \n";
        echo "Plik konfiguracyjny utworzony</p>";

        fclose($file);
        echo "<a href='?step=3'> Krok 3 </a>";
    }
}

function form_install_3() {
    if (file_exists("config/config.php")) 
    {
        include("config/config.php");
        if (file_exists("sql/sql.php")) {
            include("sql/sql.php");
            echo "Tworzę tabele bazy: ".$dbname.".<br>\n";
            mysqli_select_db($link, $dbname) or die(mysqli_error($link));
            for($i=0;$i<count($create);$i++){
                    echo "<p>".$i.". <code>".$create[$i]."</code></p>\n";
                    mysqli_query($link, $create[$i]);
            }
        }
        echo "<a href='?step=4'> Krok 4 </a>";
    }
    
}

function form_install_4() {
    if (file_exists("config/config.php")) 
    {
        include("config/config.php");
        if (file_exists("sql/insert.php")) {
            include("sql/insert.php");
            echo "<p> Wstawiam dane do tabel bazy: ".$dbname.".</p>\n";
            mysqli_select_db($link, $dbname) or die(mysqli_error($link));
            for($i=0;$i<count($insert);$i++){
                    echo "<p>".$i.". <code>".$insert[$i]."</code></p>\n";
                    mysqli_query($link, $insert[$i]);
            }
        }
        echo "<a href='?step=5'> Krok 5 </a>";
    }
}
    

function form_install_5() {
    echo "<h1> Instalator :: krok: 5 </h1>
          <form method='POST' action='?step=6'>
            <p><b> Konto administratora </b></p>
            <label for='admin_login'> Login administratora </label>
            <input type='text' id='admin_login' name='admin_login'>
            <label for='admin_pwd'> Hasło administratora </label>
            <input type='password' id='admin_pwd' name='admin_pwd'>
            <label for='admin_pwd_confirmation'> Potwierdzenie hasła administratora </label>
            <input type='password' id='admin_pwd_confirmation' name='admin_pwd_confirmation'>
            <label for='name'> Imię </label>
            <input type='text' id='name' name='name'>
            <label for='surname'> Nazwisko </label>
            <input type='text' id='surname' name='surname'>
            <label for='mail'> E-mail </label>
            <input type='text' id='mail' name='mail'>
            <input type='submit' value='Krok 6'>
          </form>";
}

function form_install_6() {
    if($_POST['admin_pwd'] !== $_POST['admin_pwd_confirmation']) {
        echo "Hasła się nie zgadzają";
        echo "<a href='?step=5'> Powrót </a>";
        return;
    }
    $config = "\n<?php# konfiguracja aplikacji\n
        \$base_url=\"".$_POST['address']."\";
        \$nazwa_aplikacji=\"".$_POST['appname']."\";
        \$data_powstania=\"".$_POST['date']."\";
        \$wersja=\"".$_POST['version']."\";
        \$brand=\"".$_POST['company']."\";
        \$adres1=\"".$_POST['street']."\";
        \$adres2=\"".$_POST['city']."\";
        \$phone=\"".$_POST['phone_number']."\";
        ?>"; 
    if (is_writable('config/config.php')) { 
            if (!$uchwyt = fopen('config/config.php', 'a')) { 
                echo "Nie mogę otworzyć pliku ('config/config.php')"; 
                exit; 
        } 
                if (fwrite($uchwyt, $config) == FALSE) { 
            echo "Nie mogę zapisać do pliku ('config/config.php')"; 
            exit; 
        } 
        echo "Sukces, zapisano (<code>konfigurację</code>) do pliku (".'config/config.php'.")"; 
    fclose($uchwyt); 
    } else { 
            echo "Plik ".'config/config.php'." nie jest zapisywalny"; 
    }
    include("config/config.php");
    $insert[] = "INSERT INTO `".$prefix."user` (`user_id`, `isadmin`, `username`, `mail`, `password`, `name`, `surname`) VALUES
(DEFAULT, 1, '".$_POST['admin_login']."', '".$_POST['mail']."', '".md5($_POST['admin_pwd'])."', '".$_POST['name']."', '".$_POST['surname']."');";

    mysqli_select_db($link, $dbname) or die(mysqli_error($link));
    for($i=0;$i<count($insert);$i++){
    echo "<p>".$i.". <code>".$insert[$i]."</code></p>\n";
    mysqli_query($link, $insert[$i]);                      
    }
    echo "<a href='?step=7'> Krok 7 </a>";
}

function form_install_7() {
    echo "<h1> Instalator :: krok: 7 </h1>
          <h2> Instalacja zakończona </h2>
          <a href='index.php'> Przejdź do strony głównej </a>";
}
?>