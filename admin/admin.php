<?php 
session_start();
$title = "Admin Page";
include 'inc/header.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<h1 class="text-center mt-4">Dashboard Page</h1>
<?php if (isset($_SESSION['invalid'])): ?>
    <div class="alert alert-danger alert-dismissible fade show w-50 m-auto mt-5" role="alert">
        <strong>Error!</strong> <?php echo $_SESSION['invalid']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['invalid']); ?>
<?php endif; ?>


<?php 

include 'inc/sidebar.php';
include 'inc/footer.php';
?>
