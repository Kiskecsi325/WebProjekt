<?php
session_start();
include "messageManager.php";

$MessageManager = new MessageManager();

$users = $MessageManager->load_users("users.json");


// Az aktuális oldal URL-jének lekérése
$current_page = basename($_SERVER['PHP_SELF']);
// Az aktuális oldal változójának átadása a header fájlnak
include 'header.php';
$current_user = null;
if (isset($_SESSION["user"])) {
    $current_user = $_SESSION["user"];
}
if (!isset($_SESSION["user"])) {
    // ha a felhasználó nincs belépve (azaz a "user" munkamenet-változó értéke nem került korábban beállításra), akkor a login.php-ra navigálunk
    header("Location: index.php");
}

if (isset($_POST["send"])) {
    $sender = $current_user["username"];
    $receiver = $_POST["receiver"];
    $message = $_POST["message"];

    $MessageManager->sendMessage($sender, $receiver, $message);

}
if (isset($_POST["deleteBtn"])) {
    if (isset($_POST["deleteM"])) {
        $Id = $_POST['deleteM'];
        $MessageManager->delete_message($Id); // A törlési művelet meghívása az $Id alapján
    }
}


$header = new header($current_user, $current_page);
$header->print_header();


// Üzenetek lekérése
$receivedMessages = $MessageManager->getMessages($current_user["username"]);


?>

<div class="contactUs">
    <div class="title">
        <h3>Beérkezett üzenetek</h3>
    </div>
    <table border="1">
        <tr>
            <th style="width:15%;">feladó</th>
            <th>üzenet</th>
            <th style="width:15%;"></th>
        </tr>
        <form id="special-form" action="" method="POST">
            <?php foreach ($receivedMessages as $message): ?>
                <tr>
                    <td><?= $message["sender"] ?></td>
                    <td><?= $message["message"] ?></td>
                    <td>
                        <input type="hidden" name="deleteM" value="<?= $message["id"] ?>">
                        <button type="submit" name="deleteBtn" class="btn"
                            style="width:100%;background-color: black; color: white;">Törlés</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </form>
    </table>
</div>

<div class="box">
    <div class="contact form">
        <h3>Küldj üzenetet</h3>
        <form action="message.php" method="POST">
            <div class="formBox">
                <div class="row50">
                    <div class="inputBox">
                        <label for="receiver">Címzett</label>
                        <select id="receiver" name="receiver" required>
                            <option value="" selected disabled>Válassz címzettet</option>';
                            <?php foreach ($users["users"] as $user) {
                                echo ' <option value="' . $user["username"] . '">' . $user["username"] . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row100">
                    <div class="inputBox">
                        <span>Üzenet</span>
                        <textarea name="message" placeholder="ide irhatja üzenetét..." required></textarea>
                    </div>
                </div>
                <div>
                    <button type="submit" name="send" id="submint" class="btn"> Küldés</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<?php include_once "footer.php"; ?>