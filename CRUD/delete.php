<?php
$conn = new mysqli("localhost", "root", "", "rrpg");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM rpg_game WHERE game_id = $id";

if ($conn->query($sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>