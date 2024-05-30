<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    $image = null;

    if ($email && $name && $message) {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= 1048576) {
                $image_path = 'uploads/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
                $image = $image_path;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid image file']);
                exit;
            }
        }

        $mysqli = new mysqli("localhost", "username", "password", "feedback");
        $stmt = $mysqli->prepare("INSERT INTO reviews (name, email, message, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $email, $message, $image);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    }
}
?>
