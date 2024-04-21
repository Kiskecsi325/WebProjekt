<?php

class header
{
    private $user;
    private $current_page;

    function __construct($user, $current_page)
    {
        $this->user = $user;
        $this->current_page = $current_page;
    }

    function print_header()
    {
        echo '<!DOCTYPE html>
        <html lang="hu">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" type="image/x-icon" href="../images/icon.png">
        </head>
        
        <body>
            <div class="container">
                <header>
                    <nav>
                        <ul class="nav">
                            <li><a href="index.php" class="logo">
                                    <h2>Gokart</h2>
                                </a></li>';

        if (!is_null($this->user)) {
            echo ' <li class="hideOnMobile"><a href="booking.php"';
            if ($this->current_page === 'booking.php')
                echo 'class="active"';
            echo '>Időpont foglalás</a></li>';
            echo ' <li class="hideOnMobile"><a href="contact.php"';
            if ($this->current_page === 'contact.php')
                echo 'class="active"';
            echo '>Kapcsolat</a></li>';
            echo ' <li class="hideOnMobile"><a href="champs.php"';
            if ($this->current_page === 'champs.php')
                echo 'class="active"';
            echo '>Versenyek</a></li>';
            echo ' <li class="hideOnMobile"><a href="service.php"';
            if ($this->current_page === 'service.php')
                echo 'class="active"';
            echo '>Szolgáltatások</a></li>';
            echo ' <li class="hideOnMobile"><a href="profile.php"';
            
            if ($this->current_page === 'profile.php')
                echo 'class="active"';
            echo '>Profil</a></li>';
            if($this->user["role"]==='admin'){
                echo'<li class="hideOnMobile"><a href="users.php">Felhasználók</a></li>';
            }
            echo ' <li class="hideOnMobile"><a href="logout.php">Kijelentkezés</a></li>';
        } else {
            echo '<li class="hideOnMobile"><a href="login.php">Bejelentkezés</a></li>';
            echo '<li class="hideOnMobile"><a href="signup.php">Regisztráció</a></li>';
        }
        echo '<li><button class="menu-button" onclick="showSidebar()"><img src="../images/Icons/menu.svg"
                                        alt="menu icon"></button></li>
                            <li class="hideOnMobile"> <img src="../images/Icons/moon.svg" id="darkModeSwitch" alt="moon"> </li>
                        </ul>
        
                        <ul class="sidebar">
                            <li> <button class="menu-button" onclick="hideSidebar()">
                                    <img src="../images/Icons/close.svg" alt="close menu">
                                </button></li>';
        if (!is_null($this->user)) {
            echo ' <li ><a href="booking.php"';
            if ($this->current_page === 'booking.php')
                echo 'class="active"';
            echo '>Időpont foglalás</a></li>';
            echo ' <li ><a href="contact.php"';
            if ($this->current_page === 'contact.php')
                echo 'class="active"';
            echo '>Kapcsolat foglalás</a></li>';
            echo ' <li ><a href="champs.php"';
            if ($this->current_page === 'champs.php')
                echo 'class="active"';
            echo '>Versenyek foglalás</a></li>';
            echo ' <li ><a href="service.php"';
            if ($this->current_page === 'service.php')
                echo 'class="active"';
            echo '>Szolgáltatások foglalás</a></li>';
            echo ' <li ><a href="profile.php"';
            if ($this->current_page === 'profile.php')
                echo 'class="active"';
            echo '>Profil</a></li>';
            echo ' <li ><a href="logout.php">Kijelentkezés</a></li>';
            if($this->user["role"]==='admin'){
                echo'<li><a href="users.php">Felhasználók</a></li>';
            }
        } else {
            echo '<li ><a href="login.php">Bejelentkezés</a></li>';
            echo '<li ><a href="signup.php">Regisztráció</a></li>';
        }

        echo '  </ul>
                    </nav>
                </header> ';
       
    }
}