<?php
// Start the session

include "db_conn.php";

// Assuming you have established a connection to your MySQL database

// Create a new PDO instance
$pdo1 = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

// Prepare the SQL statement
$sql4 = "SELECT * FROM room WHERE user_id = :userId";

// Bind the parameter
$statement = $pdo1->prepare($sql4);
$statement->bindParam(':userId', $_SESSION['user_id']);

// Execute the SQL statement
$statement->execute();

// Fetch all the rows as an associative array
$rooms = $statement->fetchAll(PDO::FETCH_ASSOC);
?>   
        <ul class="menu_item">
            <div class="menu_title flex">
                <span class="title">Pokoje</span>
                <span class="line"></span>
            </div>
            <?php foreach ($rooms as $room) { ?>
                <li class="item">
                    <a href="#" class="link flex">
                        <i class="bx bx-home-alt"></i>
                        <span><?php echo $room['room_name']; ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>