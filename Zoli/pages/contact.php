<?php
session_start();

include 'messageManager.php';
$MessageManager=new MessageManager();

if (isset($_POST["send"])) {
    $sender = $_POST["LastName"] . " " . $_POST["FirstName"]  ;
    $receiver = "admin";
    $message = $_POST["text"] . "   " . "email: " . $_POST["email"] . "   " . "tel: " . $_POST["tel"];

    $MessageManager->sendMessage($sender, $receiver, $message);

}
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
    <div class="contactUs">
        <div class="title">
            <h2>Lépj kapcsolatba velünk!</h2>
        </div>
        <div class="box">
            <div class="contact form">
                <h3>Küldj üzenetet</h3>
                <!-- form box -->
                <form action="contact.php" method="POST">
                    <div class="formBox">
                        <div class="row50">
                            <div class="inputBox">
                                <span>Vezeték név</span>
                                <input type="text" name="LastName" placeholder="Minta" required>
                            </div>
                            <div class="inputBox">
                                <span>Kereszt név</span>
                                <input type="text" name="FirstName" placeholder="János" required>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="inputBox">
                                <span>E-mail cím</span>
                                <input type="email" name="email" placeholder="minta@valami.com"
                                    pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" required>
                            </div>
                            <div class="inputBox">
                                <span>Telefon</span>
                                <input type="tel"  name="tel" placeholder="+36301234567"
                                    pattern="^\+(?:36)(?:20|30|70)\d{3}\d{2}\d{2}$" required>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="inputBox">
                                <span>Üzenet</span>
                                <textarea name="text" placeholder="ide irhatja üzenetét..." required></textarea>
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="send" id="submint" class="btn"> Küldés</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- info box -->
            <div class="contact info">
                <h3>Kapcsolat</h3>
                <div class="infoBox">
                    <div>
                        <span><img src="../images/Icons/location.svg" alt="location icon"></span>
                        <p><strong> 6700. Szeged,</strong> <br> Valahol u. 118/b</p>
                    </div>
                    <div>
                        <span><img src="../images/Icons/mail.svg" alt="mail icon"></span>
                        <a href="mailto:info@gokard.com">info@gokard.com</a>
                    </div>
                    <div>
                        <span><img src="../images/Icons/phone.svg" alt="phone icon"></span>
                        <a href="tel:+36305554444">+36 30 555 44 44</a>
                    </div>
                </div>
                <!-- Social Media  -->
                <ul class="sci">
                    <li><a href=""><img src="../images/Icons/logo-facebook.svg" alt="logo-facebook"></a></li>
                    <li><a href=""><img src="../images/Icons/logo-discord.svg" alt="logo-discord"></a></li>
                    <li><a href=""><img src="../images/Icons/logo-instagram.svg" alt="logo-instagram"></a></li>
                    <li><a href=""><img src="../images/Icons/logo-linkedin.svg" alt="logo-linkedin"></a></li>
                    <li><a href=""><img src="../images/Icons/logo-twitter.svg" alt="logo-twitter"></a></li>
                </ul>
            </div>
            <div class="contact map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2759.013828919266!2d20.143835076053076!3d46.2499528806708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4744886ff749d09b%3A0x3c136b11e025c582!2sUniversity%20of%20Szeged!5e0!3m2!1sen!2shu!4v1711269939941!5m2!1sen!2shu"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <?php include_once "footer.php"; ?>
