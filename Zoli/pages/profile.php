<?php
session_start();

// Az aktuális oldal azonosítójának mentése a session változóba
$_SESSION['current_page'] = basename($_SERVER['PHP_SELF']);



if (!isset($_SESSION["user"])) {
  // ha a felhasználó nincs belépve (azaz a "user" munkamenet-változó értéke nem került korábban beállításra), akkor a login.php-ra navigálunk
  header("Location: login.php");
}

include 'header.php';
$current_user=null;
if(isset($_SESSION["user"])){
  $current_user=$_SESSION["user"];
}
$header=new header($current_user,$current_page);
$header->print_header();

if (isset($_FILES["profile-pic"])) {
  echo "A fájl neve: " . $_FILES["profile-pic"]["name"] . "<br/>";
  echo "A fájl ideiglenes neve: " . $_FILES["profile-pic"]["tmp_name"] . "<br/>";
  echo "A fájl mérete (bájtokban): " . $_FILES["profile-pic"]["size"] . "<br/>";
  echo "A fájl típusa: " . $_FILES["profile-pic"]["type"] . "<br/>";
  echo "Hibakód: " . $_FILES["profile-pic"]["error"] . "<br/>";
}

$fajlnev = $_FILES["profile-pic"]["name"];
  $darabok = explode(".", $fajlnev);            // fájlnév feldarabolása pont karakterek mentén
  $kiterjesztes = strtolower(end($darabok));    // a feldarabolás után kapott értékek közül az utolsó lesz a kiterjesztés

  echo "A fájl kiterjesztése: $kiterjesztes <br/>";   // "A fájl kiterjesztése: jpg"
?>


  <div class="container">
    <div class="title">
      <h2>Profil</h2>
    </div>

    <form action="process.php" method="POST" enctype="multipart/form-data">
      <label for="file-upload">Profilkép:</label>
      <!-- Csak képfájlokat szeretnénk engedélyezni a feltöltés során -->
      <input type="file" id="file-upload" name="profile-pic" accept="image/*"/> <br/>
      <input type="submit" name="upload-btn" value="Feltöltés"/>
    </form>
  </div>

  <?php include_once "footer.php"; ?>
