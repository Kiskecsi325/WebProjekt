<?php
session_start();
if (isset($_COOKIE["visits"])) {
    $latogatasok = $_COOKIE["visits"] + 1;  // az eddigi látogatások számát megnöveljük 1-gyel
  } else { $latogatasok = 1; }

  // egy "visits" nevű süti a látogatásszám tárolására, amelynek élettartama 30 nap
  setcookie("visits", $latogatasok, time() + (60*60*24*30), "/");

  // Az aktuális oldal URL-jének lekérése
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

<div class="contenti">

    <?php if (isset($_SESSION["user"])) { ?>

        <a class="btn" href="booking.php">Időpont Foglalás</a>
    <?php } else { ?>
        <a class="btn" href="login.php">Bejelentkezés</a>
    <?php } ?>

    <h1> Gokard <br>excepteur </h1>
    <p> Sed ut perspiciatis unde
</div>
<img src="../images/gokard2.png" alt="gokard" class="feature-img">
<?php include_once "footer.php"; ?>
<?php
      if ($latogatasok > 1) {     // ha már korábban járt a felhasználó a weboldalunkon...
        echo "Üdvözöllek ismét! Ez a(z) $latogatasok. látogatásod.";
      } else {                    // ha első alkalommal látogatja meg a weboldalunkat...
        echo "Üdvözöllek a weboldalamon!";
      }
    ?>
