<?php
session_start();
include 'inc/conn.php';
include 'inc/config.php';
include 'inc/session-check.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    var_dump($id);
    try {
        $stmt = $connect->prepare("UPDATE teams SET status = '0' WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['teamdelete'] = "Team deleted successfully.";
        } else {
            $_SESSION['teamdelete'] = "Failed to delete user.";
        }
    } catch (PDOException $e) {
        $_SESSION['teamdelete'] = "Error: " . $e->getMessage();
    }
}
header("Location: allteams.php");
exit();
?>
