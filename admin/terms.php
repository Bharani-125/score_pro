
<?php 
ob_start();
session_start();
$title = 'Terms and Conditions';
include 'inc/header.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// include 'inc/sidebar.php';
?>
<?php
include 'inc/conn.php';
include 'inc/config.php';
$read = "SELECT id, title, content FROM pages WHERE id = 1 ";
$stmt = $connect->query($read);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    foreach ($results as $page) {
        echo "<h1 class=text-center>" . $page['title'] . "</h1>";
        echo "<body>" . $page['content'] . "</body>";
    }
} else {
    echo "<p>No content found for the Terms and Policy page.</p>";
}
?>

 
<?php 
include 'inc/footer.php';
?>