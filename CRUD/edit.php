<?php
$conn = new mysqli("localhost", "root", "", "rrpg");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$result = $conn->query(
    "SELECT * FROM rpg_game WHERE game_id = $id"
);

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $name = $_POST['game_name'];
    $desc = $_POST['game_descP'];
    $category = $_POST['game_category'];
    $release = $_POST['game_release'];

    $sql = "UPDATE rpg_game SET
            game_name = '$name',
            game_descP = '$desc',
            game_category = '$category',
            game_release = '$release'
            WHERE game_id = $id";

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
    <title>Edit Game</title>
</head>
<body>

<h1>Edit RPG Game</h1>

<form method="POST">

    <label>Game Name:</label><br>
    <input type="text"
           name="game_name"
           value="<?= htmlspecialchars($row['game_name']) ?>"
           required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="game_descP" required><?= htmlspecialchars($row['game_descP']) ?></textarea>
    <br><br>

    <label>Category:</label><br>
    <input type="text"
           name="game_category"
           value="<?= htmlspecialchars($row['game_category']) ?>"
           required>
    <br><br>

    <label>Release Date:</label><br>
    <input type="date"
           name="game_release"
           value="<?= $row['game_release'] ?>"
           required>
    <br><br>

    <button type="submit" name="update">Update Game</button>

</form>

<br>

<a href="index.php">Back</a>

</body>
</html>