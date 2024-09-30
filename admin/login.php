<?php 
$title = "Login page ";
include 'inc/header.php';
?>
<style>
    nav ul{
        display: none;
    }
</style>
<?php 
include 'inc/config.php';
include 'inc/conn.php';

session_start();

$loginError = '';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT email, password, fullname, status FROM users WHERE email = :email";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password == $user['password']) {
            if ($user['status'] == 1) {
                $_SESSION['email'] = $user['email'];
                header("Location: admin.php");
                exit();
            } else {
                $loginError = "<h6 class='text-danger m-auto'>Your account is inactive</h6>";
            }
        } else {
            $loginError = "<h6 class='text-danger m-auto'>Invalid email or password.</h6>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php
if(isset($_COOKIE['loggedout'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong>
        <?php echo $_COOKIE['loggedout']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    setcookie('loggedout', '', time() - 3600, "/");
endif;
?>

<section class="login-sec form d-flex justify-content-center align-items-center">
    
    <form action="login.php" method="post" class="p-3 login-form  d-flex flex-column justify-content-center align-items-start">
        <label for="email">E-mail:</label>
        <input type="text" class="form-control" name="email">
        <label for="email" >Password:</label>
        <input type="password" class="form-control" name="password">
        <button class="btn btn-warning text-light m-auto">Sumbit</button>
        <h6 class="loginerror"><?php echo $loginError ?></h6>
    </form>
</section>

<?php 
include 'inc/footer.php';
?>
