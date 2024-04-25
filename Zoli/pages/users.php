<?php
session_start();

// Az aktuális oldal URL-jének lekérése
$current_page = basename($_SERVER['PHP_SELF']);
// Az aktuális oldal változójának átadása a header fájlnak
include 'header.php';
$current_user = null;
if (isset($_SESSION["user"])) {
    $current_user = $_SESSION["user"];
}

$header = new header($current_user, $current_page);
$header->print_header();


// JSON fájl beolvasása
$file_content = file_get_contents('users.json');

// JSON dekódolása asszociatív tömbbe
$users = json_decode($file_content, true);

// Ellenőrzés, hogy a dekódolás sikeres volt-e
if ($users === null) {
    die("Hiba történt a JSON fájl dekódolása során.");
}

if (isset($_POST["delete"])) {
    // Profil törlése gombra kattintás esetén
    if (isset($_SESSION["user"]) ) {
        $role = $_SESSION["user"]["username"];

        $usermanager->delete_users($username);
        $usermanager->logout();
        // Például visszairányítás a főoldalra
        echo "A profil sikeresen törölve.";
        header("Location: login.php"); // Átirányítás a login.php oldalra
        exit; // Kilépés a programból
    }
  }

// Táblázat fejléce
echo ' <div class="contactUs">
        <div class="title">
        <h3>Felhasználók</h3>
        </div>';
echo "<table border='1'>";
echo '<tr>
            <th>Felhasználónév</th>
            <th>Élet év</th>
            <th>Gokard szint</th>
            <th>Szerepkör</th>
            <th>Hobbik</th>';
            if( $current_user['role'] ==="admin"){
                echo '<th>Email cím</th>
                <th></th>';
            }
            echo '</tr>';

// Felhasználók adatainak megjelenítése a táblázatban
foreach ($users['users'] as $user) {
    echo'<form action="users.php" method="POST">';
echo'<tr>';
    echo '<th> <input type="text" name="username" value="'; echo $user['username']; echo' "'; if( $current_user['role'] ==="user")echo'readonly'; echo'></th>';
    echo '<th> <input type="text" name="age" value="'; echo $user['age']; echo' "'; if( $current_user['role'] ==="user")echo'readonly'; echo'></th>';
    echo '<th> <input type="text" name="level" value="'; echo $user['level']; echo' "'; if( $current_user['role'] ==="user")echo'readonly'; echo'></th>';
    echo "<th>" . $user['role'] . "</th>";
    echo "<td>" . implode(", ", $user['hobbies']) . "</td>"; 
    if( $current_user['role'] ==="admin"){echo '<th> <input type="text"  name="email" value="'; echo $user['email']; echo' "'; if( $current_user['role'] ==="user")echo'readonly'; echo'></th>';};
    if( $current_user['role'] ==="admin"){echo'<th><input type="submit"style="width: 90px;" name="save" value="Mentés" /><input class="delete" style="width: 90px;" type="submit" name="delete" value="Profil törlése" /></th>';};
}

echo "</table>";

echo "</div>";

 include_once "footer.php";

