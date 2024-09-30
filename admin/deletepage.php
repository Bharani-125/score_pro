<?php
session_start();
include 'inc/conn.php'; 
include 'inc/config.php';
include 'inc/session-check.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $sql = "UPDATE pages SET status = '0' WHERE id = :id";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $_SESSION['post-delete'] = "Page deleted successfully";
        
        header('Location: allpages.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
