<?php
session_start();

include 'header.php';
include "functions.php";              // beágyazzuk a load_users() és save_users() függvényeket tartalmazó PHP fájlt
include "userManager.php";
$usermanager = new UserManager();
$hibak = [];
// Az aktuális oldal URL-jének lekérése
$current_page = basename($_SERVER['PHP_SELF']);
$current_user = null;
if (isset($_SESSION["user"])) {
  $current_user = $_SESSION["user"];
}
$nev = $_SESSION["user"]["username"] ;
$header = new header($current_user, $current_page);
$header->print_header();

if (isset($_POST["regiszt"])) {
  if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "")
    $hibak[] = "A felhasználónév megadása kötelező!";

  if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || strlen($_POST["jelszo"]) < 8 || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "" || $_POST["jelszo"] !== $_POST["jelszo2"])
    $hibak[] = "A jelszó minimum 8 karakter hosszúnak kell lennie, és az ellenőrző jelszó megadása kötelező és egyeznie kell az elsődleges jelszóval!";



  if (!isset($_POST["eletkor"]) || trim($_POST["eletkor"]) === "")
    $hibak[] = "Az életkor megadása kötelező!";

  if (!isset($_POST["nem"]) || trim($_POST["nem"]) === "")
    $hibak[] = "A nem megadása kötelező!";

  if (!isset($_POST["hobbik"]) || count($_POST["hobbik"]) < 2)
    $hibak[] = "Legalább 2 hobbit kötelező kiválasztani!";

  $felhasznalonev = $_POST["felhasznalonev"];
  $jelszo = $_POST["jelszo"];
  $jelszo2 = $_POST["jelszo2"];
  $eletkor = $_POST["eletkor"];
  $nem = NULL;
  $hobbik = NULL;

  if (isset($_POST["nem"]))
    $nem = $_POST["nem"];
  if (isset($_POST["hobbik"]))
    $hobbik = $_POST["hobbik"];

  if (count($hibak) === 0) {
    array_merge($hibak, $usermanager->singup($felhasznalonev, $jelszo, $jelszo2, $eletkor, $nem, "user", $hobbik));
  }

  if (count($hibak) === 0) {   // sikeres regisztráció
    $siker = TRUE;
    header("Location: login.php");
  } else {                    // sikertelen regisztráció
    $siker = FALSE;

  }
}


?>

<div class="contactUs">
  <div class="title">
    <h3>Profil</h3>
  </div>

  <form action="process.php" method="POST" enctype="multipart/form-data">
       <div class="gallery-item">
          <?php echo' <img src="../images/profilpic/' . $nev .'.jpg" alt="profile kép">'; ?>
        </div>
    <label for="file-upload">Profilkép:</label>
    <input type="file" id="file-upload" name="profile-pic" accept="image/*" /> <br />
    <input type="submit" name="upload-btn" value="Feltöltés" onclick="delayedRefresh(2000)" />
  </form>
  <script>
  function delayedRefresh(delay) {
        setTimeout(function() {
            location.reload(); // Az oldal frissítése késleltetett idő után
        }, delay);
    }
    </script>

  <form action="signup.php" method="POST">
    <label>Felhasználónév:<?php echo $nev?> </label> <br />
    <label>Jelszó: <input type="password" name="jelszo" minlength="8" required /></label> <br />
    <label>Jelszó ismét: <input type="password" name="jelszo2" minlength="8" required /></label> <br />
    <label>Szül.Dátum: <input type="date" name="eletkor" placeholder="<?php echo $current_user["age"]  ?>" value="<?php if (isset($_POST['eletkor']))
      echo $_POST['eletkor']; ?>" required /></label> <br />
    <label>E-mail cím: <input type="email" name="email" placeholder="<?php echo $current_user["age"]  ?>" required /></label> <br />
   
    <strong>Gokárd szint:</strong>
    <label><input type="radio" name="nem" value="K" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'K')
      echo 'checked'; ?> required /> Kezdő</label>
    <label><input type="radio" name="nem" value="H" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'H')
      echo 'checked'; ?> required /> Haladó</label>
    <label><input type="radio" name="nem" value="P" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'P')
      echo 'checked'; ?> required /> Profi</label> <br />

    <strong>Hobbik:</strong>
    <label><input type="checkbox" name="hobbik[]" value="programozás" <?php if (isset($_POST['hobbik']) && in_array('programozás', $_POST['hobbik']))
      echo 'checked'; ?> /> Programozás</label>
    <label><input type="checkbox" name="hobbik[]" value="Autózás" <?php if (isset($_POST['hobbik']) && in_array('Autózás', $_POST['hobbik']))
      echo 'checked'; ?> /> Autózás</label>
    <label><input type="checkbox" name="hobbik[]" value="Versenyzés" <?php if (isset($_POST['hobbik']) && in_array('Versenyzés', $_POST['hobbik']))
      echo 'checked'; ?> /> Versenyzés</label>
    <label><input type="checkbox" name="hobbik[]" value="Quadozás" <?php if (isset($_POST['hobbik']) && in_array('Quadozás', $_POST['hobbik']))
      echo 'checked'; ?> /> Quadozás</label>
    <label><input type="checkbox" name="hobbik[]" value="Motorozás" <?php if (isset($_POST['hobbik']) && in_array('Motorozás', $_POST['hobbik']))
      echo 'checked'; ?> /> Motorozás</label> <br />
</form>
<form action="signup.php" method="POST">
    <input type="submit" name="save" value="Mentés" /> <br /><br />
    <input class="delete" type="submit" name="delete" value="Profil törlése" /> <br /><br />
  </form>
</div>
<?php
if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
  echo "<p>Sikeres Mentés!</p>";
} else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
  foreach ($hibak as $hiba) {
    echo "<p class='error'>" . $hiba . "</p>";
  }
}

include_once "footer.php";
?>