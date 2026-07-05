<?php
$isAdmin = isset($_SESSION['is_admin']) &&
           $_SESSION['is_admin'] === true;

$isGuestLoggedIn = isset($_SESSION['guest_user']) &&
                   !empty($_SESSION['guest_user']);
?>
