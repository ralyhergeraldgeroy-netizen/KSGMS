<?php
$conn = new mysqli("localhost", "root", "", "rrpg");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM rpg_game ORDER BY game_id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>RPG Game CRUD</title>
</head>
<body>

<h1>RPG Game List</h1>

<a href="create.php">Add New Game</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Game Name</th>
        <th>Description</th>
        <th>Category</th>
        <th>Release Date</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>

    <tr>
        <td><?= $row['game_id'] ?></td>
        <td><?= htmlspecialchars($row['game_name']) ?></td>
        <td><?= htmlspecialchars($row['game_descP']) ?></td>
        <td><?= htmlspecialchars($row['game_category']) ?></td>
        <td><?= $row['game_release'] ?></td>

        <td>
            <a href="edit.php?id=<?= $row['game_id'] ?>">Edit</a> |
            <a href="delete.php?id=<?= $row['game_id'] ?>"
               onclick="return confirm('Are you sure you want to delete this game?')">
               Delete
            </a>
        </td>
    </tr>

    <?php endwhile; ?>

</table>

</body>
</html>