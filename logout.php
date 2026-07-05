<?php
session_start();

unset($_SESSION['is_admin']);
unset($_SESSION['guest_user']);

session_destroy();

header("Location: index.php");
exit;
?>
