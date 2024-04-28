<?php
session_start();

// Az aktuális oldal URL-jének lekérése
$current_page = basename($_SERVER['PHP_SELF']);

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
?>

    <div class="contactUs">
        <div class="title">
            <h3>További Szolgáltatások</h3>
        </div>
        <div class="card-container">
            <div class="card">
                <img src="../images/coffeeShop.png" alt="coffeeShop">
                <div class="card-content">
                    <h3>Kávézó</h3>
                    <p>Velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    </p>
                    <!-- <button class="btn">Bővebben</button> -->
                </div>
            </div>
            <div class="card">
                <img src="../images/kertmozi.jpg" alt="kertmozi">
                <div class="card-content">
                    <h3>Kertmozi</h3>

                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id
                        est laborum.</p>
                    <!-- <button class="btn">Bővebben</button> -->
                </div>
            </div>
            <div class="card">
                <img src="../images/grill.png" alt="grill">
                <div class="card-content">
                    <h3>Sütögetős helyek</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. </p>
                    <!-- <button class="btn">Bővebben</button> -->
                </div>
            </div>
            <div class="card">
                <img src="../images/csocso.png" alt="csocso">
                <div class="card-content">
                    <h3>Csocsó asztalok</h3>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur. </p>
                    <!-- <button class="btn">Bővebben</button> -->
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>