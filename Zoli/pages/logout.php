<?php
session_start();
include "userManager.php";
$usermanager = new UserManager();

//$usermanager->delete_users($usermanager->current_user()["username"]);
$usermanager->logout();

header("Location: index.php");    // átirányítás

