<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$mysqli = new mysqli("localhost", "username", "password", "feedback");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $stmt = $mysqli->prepare("UPDATE reviews SET is_approved = 1 WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == 'reject') {
        $stmt = $mysqli->prepare("UPDATE reviews SET is_approved = 0 WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == 'edit') {
        $message = htmlspecialchars($_POST['message']);
        $stmt = $mysqli->prepare("UPDATE reviews SET message = ?, is_edited = 1 WHERE id = ?");
        $stmt->bind
