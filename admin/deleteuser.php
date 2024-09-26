<?php
session_start();
include 'inc/conn.php';
include 'inc/config.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    var_dump($id);
    try {
        $stmt = $connect->prepare("UPDATE users SET status ='0' WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['message'] = "User deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete user.";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
}
header("Location: allusers.php");
exit();
?>
