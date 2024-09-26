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
    
    try {
        $sql = "DELETE FROM pages WHERE id = :id";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $_SESSION['post-delete'] = "Page deleted successfully";
        
        header('Location: allposts.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
