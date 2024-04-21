<?php
session_start();

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
if (!isset($_SESSION["user"])) {
    // ha a felhasználó nincs belépve (azaz a "user" munkamenet-változó értéke nem került korábban beállításra), akkor a login.php-ra navigálunk
    header("Location: login.php");
}
?>
    <main>
        <div>
            <div class="backimgPos">
                <img id="backimg" src="../images/DSC05775.jpg" alt="Gokart verseny">
            </div>
        </div>

        <div id="formtable">
            <div class="box2">
                <table>
                    <thead>
                        <tr>
                            <th id="Nev">Név</th>
                            <th id="1.ford">1. forduló</th>
                            <th id="2.ford">2. forduló</th>
                            <th id="3.ford">3. forduló</th>
                            <th id="pont">Pontállás</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td headers="Nev">Pista</td>
                            <td headers="1.ford">4</td>
                            <td headers="2.ford">4</td>
                            <td headers="3.ford">2</td>
                            <td headers="pont">10</td>
                        </tr>
                        <tr>
                            <td headers="Nev">Attila</td>
                            <td headers="1.ford">2</td>
                            <td headers="2.ford">2</td>
                            <td headers="3.ford">5</td>
                            <td headers="pont">9</td>
                        </tr>
                        <tr>
                            <td headers="Nev">Zénó</td>
                            <td headers="1.ford">0</td>
                            <td headers="2.ford">4</td>
                            <td headers="3.ford">4</td>
                            <td headers="pont">8</td>
                        </tr>
                        <tr>
                            <td headers="Nev">Bence</td>
                            <td headers="1.ford">4</td>
                            <td headers="2.ford">2</td>
                            <td headers="3.ford">1</td>
                            <td headers="pont">7</td>
                        </tr>
                        <tr>
                            <td headers="Nev">Áron</td>
                            <td headers="1.ford">3</td>
                            <td headers="2.ford">0</td>
                            <td headers="3.ford">3</td>
                            <td headers="pont">6</td>
                        </tr>
                        <tr>
                            <td headers="Nev">Tamás</td>
                            <td headers="1.ford">2</td>
                            <td headers="2.ford">1</td>
                            <td headers="3.ford">2</td>
                            <td headers="pont">5</td>
                        </tr>
                        <tr>
                            <td headers="Nev">Dénes</td>
                            <td headers="1.ford">1</td>
                            <td headers="2.ford">2</td>
                            <td headers="3.ford">1</td>
                            <td headers="pont">4</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="box2">
                <div class="gallery">
                    <div class="gallery-item">
                        <img src="../images/DSC05775.jpg" alt="Image 1">
                    </div>
                    <div class="gallery-item">
                        <img src="../images/DSC04688.jpg" alt="Image 2">
                    </div>
                    <div class="gallery-item">
                        <img src="../images/DSC06535.jpg" alt="Image 3">
                    </div>
                    <div class="gallery-item">
                        <img src="../images/DSC06536.jpg" alt="Image 4">
                    </div>
                    <div class="gallery-item">
                        <img src="../images/DSC06537.jpg" alt="Image 5">
                    </div>
                    <div class="gallery-item">
                        <img src="../images/DSC06538.jpg" alt="Image 6">
                    </div>
                    <div class="gallery-item ">
                        <video controls width="200">
                            <source src="../video/20240324_110349.mp4" type="video/ogg" />
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "footer.php"; ?>
