<?php
session_start();

include 'header.php';
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

if (isset($_POST["save"])) {

  if (!isset($_POST["eletkor"]) || trim($_POST["eletkor"]) === "")
    $hibak[] = "Az életkor megadása kötelező!";

  if (!isset($_POST["level"]) || trim($_POST["level"]) === "")
    $hibak[] = "A gokard szint megadása kötelező!";

  if (!isset($_POST["hobbik"]) || count($_POST["hobbik"]) < 2)
    $hibak[] = "Legalább 2 hobbit kötelező kiválasztani!";

  $felhasznalonev = $nev;
  $eletkor = $_POST["eletkor"];
  $email= $_POST["email"];
  $level = NULL;
  $hobbik = NULL;

  if (isset($_POST["level"]))
    $level = $_POST["level"];
  if (isset($_POST["hobbik"]))
    $hobbik = $_POST["hobbik"];

    if (count($hibak) === 0) {
        
      $registrationResult = $usermanager->update_user_basicdata($felhasznalonev, $eletkor, $email, $level, $hobbik);
      $hibak += $registrationResult;

  }

  if (count($hibak) === 0) {   // sikeres regisztráció
    $siker = TRUE;
    header("Location: login.php");
  } else {                    // sikertelen regisztráció
    $siker = FALSE;

  }
}

if (isset($_POST["delete"])) {
  // Profil törlése gombra kattintás esetén
  if (isset($_SESSION["user"])) {
      $username = $_SESSION["user"]["username"];
      $usermanager->delete_users($username);
      $usermanager->logout();
      // Például visszairányítás a főoldalra
      echo "A profil sikeresen törölve.";
      header("Location: login.php"); // Átirányítás a login.php oldalra
      exit; // Kilépés a programból
  }
}

?>

<div class="contactUs">
  <div class="title">
    <h3>Adatlap</h3>
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

<form action="profile2.php" method="POST">
        <label>Felhasználónév:<?php echo $nev?> </label> <br /> <br />
        <label>életkor*: <h6>(18. élet évét betöltött személy regisztrálhat.)</h6> <input type="number" name="eletkor" value="<?php echo $_SESSION["user"]["age"]; ?>" required /></label> <br />
        <label>E-mail cím: <input type="email" name="email" value="<?php echo $_SESSION["user"]["email"]; ?>"required /></label> <br />
   

        <h4>Gokárd szint*:</h4>
        <label><input type="radio" name="level" value="K" <?php if ( $_SESSION["user"]["level"] === "K")
            echo 'checked'; ?> required /> Kezdő</label>
        <label><input type="radio" name="level" value="H" <?php if ( $_SESSION["user"]["level"] === "H")
            echo 'checked'; ?> required /> Haladó</label>
        <label><input type="radio" name="level" value="P" <?php if ( $_SESSION["user"]["level"] === "P")
            echo 'checked'; ?> required /> Profi</label> <br />


        <h4>Hobbik*</h4>:
        <label><input type="checkbox" name="hobbik[]" value="programozás" <?php if (isset($_SESSION["user"]['hobbies']) && in_array("programozás", $_SESSION["user"]['hobbies']))
            echo 'checked'; ?> /> Programozás</label>
        <label><input type="checkbox" name="hobbik[]" value="Autózás" <?php if (isset($_SESSION["user"]['hobbies']) && in_array("Autózás", $_SESSION["user"]['hobbies'])){
            echo 'checked';} ?> /> Autózás</label>
        <label><input type="checkbox" name="hobbik[]" value="Versenyzés" <?php if (isset($_SESSION["user"]['hobbies']) && in_array("Versenyzés", $_SESSION["user"]['hobbies']))
            echo 'checked'; ?> /> Versenyzés</label>
        <label><input type="checkbox" name="hobbik[]" value="Quadozás" <?php if (isset($_SESSION["user"]['hobbies']) && in_array("Quadozás", $_SESSION["user"]['hobbies']))
            echo 'checked'; ?> /> Quadozás</label>
        <label><input type="checkbox" name="hobbik[]" value="Motorozás" <?php if (isset($_POST['hobbies']) && in_array("Motorozás", $_SESSION["user"]['hobbies']))
            echo 'checked'; ?> /> Motorozás</label> <br />
  
    <input type="submit" name="save" value="Mentés" /> <br /><br />
    <input class="delete" type="submit" name="delete" value="Profil törlése" /> <br /><br />
  </form>
</div>
<?php
if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
  $usermanager->login( $username, $password);
  echo "<p>Sikeres Mentés!</p>";
} else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
  foreach ($hibak as $hiba) {
    echo "<p class='error'>" . $hiba . "</p>";
  }
}

include_once "footer.php";
?>