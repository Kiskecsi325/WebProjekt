<?php
session_start();
include "userManager.php";
$usermanager = new UserManager();
$usermanager->logout();

header("Location: index.php");    // átirányítás

