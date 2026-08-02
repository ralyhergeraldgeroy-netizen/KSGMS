<?php
$conn = new mysqli("localhost", "root", "", "rrpg");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {

    $name = $_POST['game_name'];
    $desc = $_POST['game_descP'];
    $category = $_POST['game_category'];
    $release = $_POST['game_release'];

    $sql = "INSERT INTO rpg_game
            (game_name, game_descP, game_category, game_release)
            VALUES
            ('$name', '$desc', '$category', '$release')";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Game</title>
</head>
<body>

<h1>Add New RPG Game</h1>

<form method="POST">

    <label>Game Name:</label><br>
    <input type="text" name="game_name" required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="game_descP" required></textarea>
    <br><br>

    <label>Category:</label><br>
    <input type="text" name="game_category" required>
    <br><br>

    <label>Release Date:</label><br>
    <input type="date" name="game_release" required>
    <br><br>

    <button type="submit" name="submit">Add Game</button>

</form>

<br>

<a href="index.php">Back</a>

</body>
</html>