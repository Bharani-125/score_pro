<?php
$title = isset($_GET['id']) ? 'Edit User' : 'Add User';
include 'inc/header.php';
session_start();
include 'inc/conn.php';
include 'inc/config.php';

include 'inc/session-check.php';

$emailError = '';
$user = [
    'fullname' => '',
    'email' => '',
    'usertype' => ''
];
// try {
//     $email = $_SESSION['email'];
//     $sql = "SELECT usertype FROM users WHERE email = :email";
//     $stmt = $connect->prepare($sql);
//     $stmt->bindParam(':email', $email);
//     $stmt->execute();
    
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
//     if ($user) {
//         if ($user['usertype'] == 'admin'){
//             header("Location: admin.php");
//             $_SESSION["invalid"] = "<h4 class=text-danger>Invalid Access</h4>";
//             exit();
//         }
//     }
// } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $connect->prepare("SELECT id, email, fullname, usertype FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['usertype'] == 'admin') {
                $_SESSION["invalid"] = "<h4 class='text-danger'>Invalid Access</h4>";
                header("Location: admin.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];
    $password = isset($_POST['password']) ? md5($_POST['password']) : null;
    date_default_timezone_set('Asia/Kolkata');
    $updatedDate = date('Y-m-d H:i:s');
    
    try {
        $checkEmailSql = "SELECT email FROM users WHERE email = :email AND id != :id";
        $stmt = $connect->prepare($checkEmailSql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $emailError = "<h6 class='text-danger'>Email already exists. Please use a different email.</h6><br>";
        } else {
            if (isset($_GET['id'])) {
                $stmt = $connect->prepare("UPDATE users SET email = :email, fullname = :fullname, usertype = :usertype, updated_date = :updatedDate WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                $stmt = $connect->prepare("INSERT INTO users (fullname, email, password, usertype, updated_date) VALUES (:fullname, :email, :password, :usertype, :updatedDate)");
                $stmt->bindParam(':password', $password);
            }

            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':usertype', $usertype);
            $stmt->bindParam(':updatedDate', $updatedDate);

            if ($stmt->execute()) {
                $_SESSION['newrecord'] = isset($_GET['id']) ? "User updated successfully." : "New user added successfully.";
                header("Location: allusers.php");
                exit();
            }
            
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<section class="d-flex">
<?php include 'inc/sidebar.php'; ?>

<div class="user-sec container">
    <form action="" method="POST" class="user-form">
        <h2 class="text-center"><?php echo isset($_GET['id']) ? 'Edit User' : 'Add User'; ?></h2>
        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <?php if (!isset($_GET['id'])): ?>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>User Type:</label><br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="usertype" id="usertypeAdmin" value="admin" <?php echo $user['usertype'] == 'admin' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="usertypeAdmin">Admin</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="usertype" id="usertypeSuperAdmin" value="superadmin" <?php echo $user['usertype'] == 'superadmin' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="usertypeSuperAdmin">Super Admin</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Update User' : 'Add User'; ?></button>
        <p class="mt-2"><?= $emailError; ?></p>
    </form>
</div>
</section>

<?php include 'inc/footer.php'; ?>
