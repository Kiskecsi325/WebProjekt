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
</head>

<body>
  <form action="login.php" method="POST">
    <label>Felhasználónév: <input type="text" name="felhasznalonev" /></label> <br />
    <label>Jelszó: <input type="password" name="jelszo" /></label> <br />
    <input type="submit" name="login" /> <br /><br />
  </form>
  <?php echo $uzenet . "<br/>"; ?>
</body>

</html>