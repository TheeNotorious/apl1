<?php
$mysqli = new mysqli("localhost", "username", "password", "feedback");
$result = $mysqli->query("SELECT * FROM reviews WHERE is_approved = 1 ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo "<div class='review'>";
    echo "<h3>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['email']) . ")</h3>";
    echo "<p>" . htmlspecialchars($row['message']) . "</p>";
    if ($row['image']) {
        echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Review image'>";
    }
    if ($row['is_edited']) {
        echo "<p><em>Edited by admin</em></p>";
    }
    echo "<p><small>Posted on " . $row['created_at'] . "</small></p>";
    echo "</div>";
}

$mysqli->close();
?>
