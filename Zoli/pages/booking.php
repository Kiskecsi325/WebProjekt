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
                <img id="backimg" src="../images/DSC05775.jpg" alt="Gokartverseny">
            </div>
        </div>

        <div id="formtable">
            <div class="box">
                <div class="formbackg" id="formbackg">
                    <form>
                        <div class="name">
                            <div>
                                <label for="lastName">Vezetéknév:</label>
                                <input type="text" id="lastName" name="lastName" placeholder="Kiss" required>
                            </div>
                            <div class="formRightElement">
                                <label for="firstName">Keresztnév:</label>
                                <input type="text" id="firstName" name="firstName" placeholder="János" required>
                            </div>
                        </div>

                        <div class="name">
                            <div>
                                <label for="email">E-mail:</label>
                                <input type="email" id="email" name="email" placeholder="info@gokart.com" required>
                            </div>
                            <div class="formRightElement">
                                <label for="phone">Telefonszám:</label>
                                <input type="tel" id="phone" name="phone" value="+36" required>
                            </div>
                        </div>

                        <div class="name">
                            <div>
                                <label for="headcount">Létszám (1-7):</label>
                                <input type="number" id="headcount" name="headcount" value="1" min="1" max="7" required>
                            </div>

                            <div class="formRightElement">
                                <label for="reservationDateTime">Foglalási időpont:</label>
                                <input type="datetime-local" id="reservationDateTime" name="reservationDateTime"
                                    required>
                            </div>

                        </div>


                        <fieldset>
                            <legend>Válassz Gokartot:</legend>
                            <div class="form-group">
                                <label for="option1">Gyerek Gokart</label>
                                <div class="inp">
                                    <input type="radio" id="option1" name="options" value="option1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="option2">Felnőtt Gokart</label>
                                <div class="inp">
                                    <input type="radio" id="option2" name="options" value="option2">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="option3">Verseny Gokart</label>
                                <div class="inp">
                                    <input type="radio" id="option3" name="options" value="option3">
                                </div>

                            </div>
                        </fieldset>


                        <label for="terms" class="checkbox-label">
                            <input type="checkbox" id="terms" name="terms" required>
                            Elfogadom a <a href="#">foglalási feltételeket</a>
                        </label>

                        <button class="btn" type="submit">Küldés</button>
                        <button class="btn" type="reset">Alaphelyzet</button>
                    </form>
                </div>
            </div>
            <div class="box">
                <table>
                    <thead>
                        <tr>
                            <th id="Nap">Nap</th>
                            <th id="Nyitás">Nyitás</th>
                            <th id="Zárás">Zárás</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td headers="Nap">Hétfő</td>
                            <td headers="Nyitás">9:00</td>
                            <td headers="Zárás">18:00</td>
                        </tr>
                        <tr>
                            <td headers="Nap">Kedd</td>
                            <td headers="Nyitás">9:00</td>
                            <td headers="Zárás">18:00</td>
                        </tr>
                        <tr>
                            <td headers="Nap">Szerda</td>
                            <td headers="Nyitás">9:00</td>
                            <td headers="Zárás">18:00</td>
                        </tr>
                        <tr>
                            <td headers="Nap">Csütörtök</td>
                            <td headers="Nyitás">9:00</td>
                            <td headers="Zárás">18:00</td>
                        </tr>
                        <tr>
                            <td headers="Nap">Péntek</td>
                            <td headers="Nyitás">9:00</td>
                            <td headers="Zárás">17:00</td>
                        </tr>
                        <tr>
                            <td headers="Nap">Szombat</td>
                            <td headers="Nyitás">10:00</td>
                            <td headers="Zárás">14:00</td>
                        </tr>
                        <tr>
                            <td headers="Nap">Vasárnap</td>
                            <td headers="Nap">10:00</td>
                            <td headers="Zárás">14:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include_once "footer.php"; ?>
