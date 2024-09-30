<?php 
session_start();
include 'inc/conn.php';
include 'inc/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT image FROM featured_in WHERE id = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        $imagePath = __DIR__ . '/../frontend/featured-in-images/' . $image['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $deleteQuery = "DELETE FROM featured_in WHERE id = :id";
        $deleteStmt = $connect->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $id);
        
        if ($deleteStmt->execute()) {
            header('location: featured-in.php');
            $_SESSION['message']= "Deleted Successfully";
            exit();
        } else {
            echo "Fail to delete the record from the database.";
        }
    } else {
        echo "Image not found.";
    }
} else {
    echo "Invalid request.";
}
?>
