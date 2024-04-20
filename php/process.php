<?php
session_start();

// Regisztráció feldolgozása
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($result->num_rows > 0) {
        echo "A felhasználónév vagy az email már foglalt!";
    } else {
        // Jelszó hashelése
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $file = fopen("ki.txt", "w");                       // fájl megnyitása írásra
        fwrite($file, $username+" , "+$hashed_password);
        fclose($file);

        if ($conn->query($insert_query) === TRUE) {
            echo "Sikeres regisztráció!";
        } else {
            echo "Hiba a regisztráció során: " . $conn->error;
        }
    }
}

// Bejelentkezés feldolgozása
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Felhasználó ellenőrzése
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            echo "Sikeres bejelentkezés!";
            // Átirányítás a bejelentkezett felhasználó kezdőoldalára
            header("Location: profile.php");
        } else {
            echo "Rossz felhasználónév vagy jelszó!";
        }
    } else {
        echo "Rossz felhasználónév vagy jelszó!";
    }
}

?>
