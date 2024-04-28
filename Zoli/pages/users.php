<?php
session_start();

// Az aktuális oldal URL-jének lekérése
$current_page = basename($_SERVER['PHP_SELF']);
// Az aktuális oldal változójának átadása a header fájlnak
include 'header.php';
include 'userManager.php'; // userManager.php fájl beolvasása
$usermanager = new UserManager(); // UserManager osztály példányosítása

$current_user = null;
if (isset($_SESSION["user"])) {
    $current_user = $_SESSION["user"];
}

$header = new header($current_user, $current_page);
$header->print_header();

// JSON fájl beolvasása
$users = $usermanager->load_users("users.json");

if (isset($_POST["delete"])) {
    // Profil törlése gombra kattintás esetén
        $username = $_POST["userid"];  // Felhasználónév kinyerése a POST adatokból
        $usermanager->delete_users($username);
        $usermanager->delete_Image($username);
        // Például visszairányítás a főoldalra
        echo  "A profil sikeresen törölve.";
        header("Location: index.php");
    
    }


if (isset($_POST["save"])) {
    // Profil törlése gombra kattintás esetén
    $username = $_POST["userid"];
    $age = $_POST["age"];
    $email=$_POST["email"];
    $level=$_POST["level"];
    $hobbies=$usermanager->find_user_by_username($username)["hobbies"];
         // Felhasználónév kinyerése a POST adatokból
        $usermanager->update_user_basicdata($username,$age,$email,$level,$hobbies);
        // Például visszairányítás a főoldalra
        echo "A profil sikeresen módosítva.";
        header("Location: index.php");
    }


// Táblázat fejléce
echo '
<div class="contactUs">
    <div class="title">
        <h3>Felhasználók</h3>
    </div>';
echo "<table border='1'>";
echo '<tr>
            <th>Felhasználónév</th>
            <th>Életkor</th>
            <th>Gokart szint</th>
            <th>Szerepkör</th>
            <th>Hobbik</th>';
            if ($current_user['role'] === "admin") {
echo        '<th>Email cím</th>
            <th></th>';
            }
echo '</tr>';

// Felhasználók adatainak megjelenítése a táblázatban
foreach ($users['users'] as $user) {
echo '<form action="users.php" method="POST">';
echo    '<tr>';
echo       '<td> '; echo $user['username'] ;  echo '</td>';
echo       '<td> <input type="number" name="age" value="' . $user['age'] . '"'; if ($current_user['role'] === "user") echo 'readonly'; echo '></td>';
echo       '<td> <input type="text" name="level" value="' . $user['level'] . '"'; if ($current_user['role'] === "user") echo 'readonly'; echo '>
            </td>';
echo       "<td>" . $user['role'] . "</th>";
echo       "<td>" . implode(", ", $user['hobbies']) . "</th>";
    if ($current_user['role'] === "admin") {
echo        '<td> <input type="text"  name="email" value="' . $user['email'] . '"'; if ($current_user['role'] === "user") echo 'readonly'; echo '></td>';
echo        '<td>
                    <input type="hidden" name="userid" value="' ; echo $user["username"] ; echo'">
                    <input type="submit" style="width: 90px;" name="save" value="Mentés"  />
                    <input class="delete" style="width: 90px;" type="submit" name="delete" value="Profil törlése" />
             </td>';
        }
        echo'</form>';
    }
echo    "</table>";
echo "</div>";

include_once "footer.php";