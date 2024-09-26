
<?php 
ob_start();
session_start();
$title = 'Terms and Conditions';
include 'inc/header.php';

// include 'inc/sidebar.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include 'inc/conn.php';
include 'inc/config.php';
$read = "SELECT id, title, content FROM pages WHERE id = 2 ";
$stmt = $connect->query($read);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    foreach ($results as $page) {
        echo "<section>" . nl2br($page['content']) . "</section>";
    }
} else {
    echo "<p>No content found for the Terms and Policy page.</p>";
}
?>

 
<?php 
include 'inc/footer.php';
?>