<?php
session_start();

include "functions.php";              // beágyazzuk a load_users() és save_users() függvényeket tartalmazó PHP fájlt
include "userManager.php";
$usermanager = new UserManager();
$hibak = [];

if (isset($_POST["regiszt"])) {
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "")
        $hibak[] = "A felhasználónév megadása kötelező!";

    if (isset($_POST["jelszo"]) && isset($_POST["jelszo2"]) && trim($_POST["jelszo"]) != "" && trim($_POST["jelszo2"]) != ""&&  $_POST["jelszo"] != $_POST["jelszo2"])
        $hibak[] = "Az ellenőrző jelszónak egyeznie kell az elsődleges jelszóval!";

    if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "")
        $hibak[] = "A jelszó megadása kötelező";

    if (isset($_POST["jelszo"]) && trim($_POST["jelszo"]) !== "" && !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "")
        $hibak[] = "Az ellenőrző jelszó megadása kötelező";


    if (!isset($_POST["eletkor"]) || trim($_POST["eletkor"]) === "")
        $hibak[] = "Az életkor megadása kötelező!";

    if (!isset($_POST["level"]) || trim($_POST["level"]) === "")
        $hibak[] = "A gokard szint megadása kötelező!";

    if (!isset($_POST["hobbik"]) || count($_POST["hobbik"]) < 2)
        $hibak[] = "Legalább 2 hobbit kötelező kiválasztani!";

    $felhasznalonev = $_POST["felhasznalonev"];
    $jelszo = $_POST["jelszo"];
    $jelszo2 = $_POST["jelszo2"];
    $eletkor = $_POST["eletkor"];
    $email = $_POST["email"];
    $level = NULL;
    $hobbik = NULL;

    if (isset($_POST["level"]))
        $level = $_POST["level"];
    if (isset($_POST["hobbik"]))
        $hobbik = $_POST["hobbik"];

    if (count($hibak) === 0) {
        
        $registrationResult = $usermanager->singup($felhasznalonev, $jelszo, $jelszo2, $eletkor, $email, $level, "user", $hobbik);
        $hibak += $registrationResult;

    }

    if (count($hibak) === 0) {   // sikeres regisztráció
        $siker = TRUE;
        header("Location: login.php");
    } else {                    // sikertelen regisztráció
        $siker = FALSE;

    }
}



// Az aktuális oldal URL-jének lekérése
$current_page = basename($_SERVER['PHP_SELF']);


include 'header.php';
$current_user = null;
$header = new header($current_user, $current_page);
$header->print_header();

?>

<div class="contactUs">
    <div class="title">
        <h3>Regisztráció</h3>
    </div>
    <form action="signup.php" method="POST">
        <label>Felhasználónév*: <input type="text" name="felhasznalonev" value="<?php if (isset($_POST['felhasznalonev']))
            echo $_POST['felhasznalonev']; ?>" /></label> <br />
        <label>Jelszó*: <h6> (A jelszónak minimum 8 karakternek kell lennie.)</h6> <input type="password" name="jelszo"
                minlength="8" required /></label> <br />
        <label>Jelszó ismét*: <input type="password" name="jelszo2" minlength="8" required /></label> <br />
        <label>életkor*: <h6>(18. élet évét betöltött személy regisztrálhat.)</h6> <input type="number" name="eletkor"
                value="<?php if (isset($_POST['eletkor']))
                    echo $_POST['eletkor']; ?>" required /></label> <br />
        <label>E-mail cím: <input type="email" name="email"
                value="<?php if (isset($_POST['email']))
                    echo $_POST['email']; ?>" required /></label> <br />


        <h4>Gokárd szint*:</h4>
        <label><input type="radio" name="level" value="K" <?php if (isset($_POST['level']) && $_POST['level'] === 'K')
            echo 'checked'; ?> required /> Kezdő</label>
        <label><input type="radio" name="level" value="H" <?php if (isset($_POST['level']) && $_POST['level'] === 'H')
            echo 'checked'; ?> required /> Haladó</label>
        <label><input type="radio" name="level" value="P" <?php if (isset($_POST['level']) && $_POST['level'] === 'P')
            echo 'checked'; ?> required /> Profi</label> <br />


        <h4>Hobbik*</h4>:
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
        <input type="submit" name="regiszt" value="Regisztráció" /> <br /><br />
    </form>
</div>

<p>* -kötelező kitölteni</p>
<?php


if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
    echo "<p>Sikeres regisztráció!</p>";
} else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
    foreach ($hibak as $hiba) {
        echo "<p class='error'>" . $hiba . "</p>";
    }
}

include_once "footer.php";

?>