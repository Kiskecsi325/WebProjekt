<?php
include "functions.php";              // beágyazzuk a load_users() és save_users() függvényeket tartalmazó PHP fájlt
include "userManager.php";
$usermanager = new UserManager();
$hibak = [];

if (isset($_POST["regiszt"])) {
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "")
        $hibak[] = "A felhasználónév megadása kötelező!";

    if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || strlen($_POST["jelszo"]) < 5 || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"] ) === "" || $_POST["jelszo"] !== $_POST["jelszo2"])
        $hibak[] = "A jelszó minimum 5 karakter hosszúnak kell lennie, és az ellenőrző jelszó megadása kötelező és egyeznie kell az elsődleges jelszóval!";

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
        input[type="password"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<form action="signup.php" method="POST">
    <h2>Regisztráció</h2>
    <label>Felhasználónév: <input type="text" name="felhasznalonev" value="<?php if (isset($_POST['felhasznalonev']))
            echo $_POST['felhasznalonev']; ?>" /></label> <br />
    <label>Jelszó: <input type="password" name="jelszo" minlength="5" required /></label> <br />
    <label>Jelszó ismét: <input type="password" name="jelszo2" minlength="5" required /></label> <br />
    <label>Szül.Dátum: <input type="date" name="eletkor" value="<?php if (isset($_POST['eletkor']))
            echo $_POST['eletkor']; ?>" required /></label> <br />
    Nem:
    <label><input type="radio" name="nem" value="F" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'F')
            echo 'checked'; ?> required /> Férfi</label>
    <label><input type="radio" name="nem" value="N" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'N')
            echo 'checked'; ?> required /> Nő</label>
    <label><input type="radio" name="nem" value="E" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'E')
            echo 'checked'; ?> required /> Egyéb</label> <br />
    Hobbik:
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
<?php
if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
    echo "<p>Sikeres regisztráció!</p>";
} else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
    foreach ($hibak as $hiba) {
        echo "<p class='error'>" . $hiba . "</p>";
    }
}
?>
</body>

</html>
