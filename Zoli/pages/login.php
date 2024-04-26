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
$current_page = basename($_SERVER['PHP_SELF']);
// Az aktuális oldal változójának átadása a header fájlnak
include 'header.php';
$current_user=null;
if(isset($_SESSION["user"])){
    $current_user=$_SESSION["user"];
}
$header=new header($current_user,$current_page);
$header->print_header();
?>


<div class="contactUs">
    <div  class="title">
        <h3>Bejelentkezés</h3>
    </div>

    <form action="login.php" method="POST">
        <label>Felhasználónév: <input type="text" name="felhasznalonev" /></label> <br />
        <label>Jelszó: <input type="password" name="jelszo" /></label> <br />
        <input type="submit" name="login" /> <br /><br />
    </form>
    <?php echo $uzenet . "<br/>"; ?>
    <img src="../images/gokard2.png" alt="gokard" class="feature-img">
</div>

<?php include_once "footer.php"; ?>