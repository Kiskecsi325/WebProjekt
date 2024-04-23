
<?php
session_start();

// Felhasználónév kinyerése a munkamenetből
$felhasznalonev = isset($_SESSION["user"]["username"]) ? $_SESSION["user"]["username"] : "unknown_user";

if (isset($_FILES["profile-pic"])) {
    // Engedélyezett kiterjesztések
    $engedelyezett_kiterjesztesek = ["jpg", "jpeg", "png"];

    // Feltöltött fájl nevének lekérése és kiterjesztésének meghatározása
    $eredeti_fajlnev = $_FILES["profile-pic"]["name"];
    $kiterjesztes = strtolower(pathinfo($eredeti_fajlnev, PATHINFO_EXTENSION));

    // Ha a feltöltött fájl kiterjesztése engedélyezett
    if (in_array($kiterjesztes, $engedelyezett_kiterjesztesek)) {
        // Fájl méret ellenőrzése (30 MB-nál kisebb legyen)
        if ($_FILES["profile-pic"]["error"] === 0 && $_FILES["profile-pic"]["size"] <= 31457280) {
            // Új fájlnév összeállítása (felhasználónév + eredeti fájlnév kiterjesztéssel)
            $uj_fajlnev = $felhasznalonev . "." . $kiterjesztes;

            // Célútvonal összeállítása az új fájlnévvel így a kép megfog egyezni a feltöltö nevével.
            $cel = "../images/profilpic/" . $uj_fajlnev;

            // Ha már létezik ilyen nevű fájl a célútvonalon, figyelmeztetés kiírása
            if (file_exists($cel)) {
                echo "<strong>Figyelem:</strong> A régebbi fájl felülírásra kerül! <br/>";
            }

            // Fájl átmozgatása a célútvonalra
            if (move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $cel)) {
                echo "Sikeres fájlfeltöltés! <br/>";
            } else {
                echo "<strong>Hiba:</strong> A fájl átmozgatása nem sikerült! <br/>";
            }
        } else {
            echo "<strong>Hiba:</strong> Helytelen fájlméret vagy fájlfeltöltési hiba! <br/>";
        }
    } else {
        echo "<strong>Hiba:</strong> Nem engedélyezett fájlkiterjesztés! Csak JPG, JPEG és PNG engedélyezett. <br/>";
    }
}

// Átirányítás a profil oldalra
header("Location: profile2.php");
?>
