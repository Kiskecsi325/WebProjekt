<?php
session_start();
include "functions.php";              // a load_users() függvény ebben a fájlban van
include "userManager.php";
$uzenet = "";                     // az űrlap feldolgozása után kiírandó üzenet

if (isset($_POST["login"])) {    // miután az űrlapot elküldték...
  if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") {
    // ha a kötelezően kitöltendő űrlapmezők valamelyike üres, akkor hibaüzenetet jelenítünk meg
    $uzenet = "<strong>Hiba:</strong> Adj meg minden adatot!";
  } else {
    // ha megfelelően kitöltötték az űrlapot, lementjük az űrlapadatokat egy-egy változóba
    $felhasznalonev = $_POST["felhasznalonev"];
    $jelszo = $_POST["jelszo"];
    $usermanager = new UserManager();

    if ($usermanager->login($felhasznalonev, $jelszo)) {

      $uzenet = "Sikeres belépés!";
      header("Location: index.php");         // ekkor átírjuk a megjelenítendő üzenet szövegét

    } else {
      $uzenet = "Sikertelen belépés! A belépési adatok nem megfelelők!";  // alapból azt feltételezzük, hogy a bejelentkezés sikertelen

    }
  }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
  <title>Bejelentkezés</title>
  <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
  <form action="login.php" method="POST">
      <h2>Bejelentkezés</h2>
    <label>Felhasználónév: <input type="text" name="felhasznalonev" /></label> <br />
    <label>Jelszó: <input type="password" name="jelszo" /></label> <br />
    <input type="submit" name="login" /> <br /><br />
  </form>
  <?php echo $uzenet . "<br/>"; ?>
  <img src="../images/gokard2.png" alt="gokard" class="feature-img">
</body>

</html>