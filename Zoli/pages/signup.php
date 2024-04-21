<?php
include "functions.php";              // beágyazzuk a load_users() és save_users() függvényeket tartalmazó PHP fájlt
include "userManager.php";
$usermanager = new UserManager();
$hibak = [];

if (isset($_POST["regiszt"])) {
  if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "")
    $hibak[] = "A felhasználónév megadása kötelező!";

  if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "")
    $hibak[] = "A jelszó és az ellenőrző jelszó megadása kötelező!";

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

<!DOCTYPE html>
<html lang="hu">

<head>
  <title>Regisztráció</title>
  <meta charset="UTF-8" />
  <style>
    form input {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <form action="signup.php" method="POST">
    <label>Felhasználónév: <input type="text" name="felhasznalonev" value="<?php if (isset($_POST['felhasznalonev']))
      echo $_POST['felhasznalonev']; ?>" /></label> <br />
    <label>Jelszó: <input type="password" name="jelszo" /></label> <br />
    <label>Jelszó ismét: <input type="password" name="jelszo2" /></label> <br />
    <label>Életkor: <input type="number" name="eletkor" value="<?php if (isset($_POST['eletkor']))
      echo $_POST['eletkor']; ?>" /></label> <br />
    Nem:
    <label><input type="radio" name="nem" value="F" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'F')
      echo 'checked'; ?> /> Férfi</label>
    <label><input type="radio" name="nem" value="N" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'N')
      echo 'checked'; ?> /> Nő</label>
    <label><input type="radio" name="nem" value="E" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'E')
      echo 'checked'; ?> /> Egyéb</label> <br />
    Hobbik:
    <label><input type="checkbox" name="hobbik[]" value="programozás" <?php if (isset($_POST['hobbik']) && in_array('programozás', $_POST['hobbik']))
      echo 'checked'; ?> /> Programozás</label>
    <label><input type="checkbox" name="hobbik[]" value="főzés" <?php if (isset($_POST['hobbik']) && in_array('főzés', $_POST['hobbik']))
      echo 'checked'; ?> /> Főzés</label>
    <label><input type="checkbox" name="hobbik[]" value="macskázás" <?php if (isset($_POST['hobbik']) && in_array('macskázás', $_POST['hobbik']))
      echo 'checked'; ?> /> Macskázás</label>
    <label><input type="checkbox" name="hobbik[]" value="mémnézegetés" <?php if (isset($_POST['hobbik']) && in_array('mémnézegetés', $_POST['hobbik']))
      echo 'checked'; ?> /> Mémnézegetés</label>
    <label><input type="checkbox" name="hobbik[]" value="alvás" <?php if (isset($_POST['hobbik']) && in_array('alvás', $_POST['hobbik']))
      echo 'checked'; ?> /> Alvás</label> <br />
    <input type="submit" name="regiszt" value="Regisztráció" /> <br /><br />
  </form>
  <?php
  if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
    echo "<p>Sikeres regisztráció!</p>";
  } else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
    foreach ($hibak as $hiba) {
      echo "<p>" . $hiba . "</p>";
    }
  }
  ?>
</body>

</html>