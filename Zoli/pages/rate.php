<?php
// Fogadjuk el az értékelést az űrlapról
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['rating'])) {
        $rating = $_POST['rating'];
        // Tároljuk el az értékelést egy cookie-ban
        setcookie('rating', $rating, time() + (86400 * 30), "/"); // 30 napig érvényes
    }
}
// Átirányítás az index oldalra
header("Location: index.php");
exit;
?>
