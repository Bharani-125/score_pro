<?php 
session_start();
$title = isset($_GET['id']) ? 'Edit Team' : 'Add Team'; 
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$team = [
    'teamname' => '',
    'team_coach' => '',
    'location' => ''
];
// var_dump($team);
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT id, teamname, team_coach, location FROM teams WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $team = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$team) {
        header("Location: allteams.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamname = $_POST['teamname'];
    $teamcoach = $_POST['teamcoach'];
    $location = $_POST['location'];
    // $logo = $_POST['logo'];

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $updatedDate = date('Y-m-d H:i:s');
            $sql = "UPDATE teams SET teamname = :teamname, team_coach = :teamcoach, location = :location, updated_date = :updatedDate WHERE id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':teamname', $teamname);
            $stmt->bindParam(':teamcoach', $teamcoach);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':updatedDate', $updatedDate);
            
            if ($stmt->execute()) {
                $_SESSION["update_success"] = "Team updated successfully!";
                header("Location: allteams.php");
                exit();
            }

        } else {
            $adminEmail = $_SESSION['email'];

            $sqlAdmin = "SELECT id FROM users WHERE email = :email";
            $stmtAdmin = $connect->prepare($sqlAdmin);
            $stmtAdmin->bindParam(':email', $adminEmail);
            $stmtAdmin->execute();
            $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $adminId = $admin['id'];
                
                $sql = "INSERT INTO teams (teamname, team_coach, location, created_by)
                        VALUES (:teamname, :teamcoach, :location, :adminId)";
                
                $stmt = $connect->prepare($sql);
                $stmt->bindParam(':teamname', $teamname);
                $stmt->bindParam(':teamcoach', $teamcoach);
                $stmt->bindParam(':location', $location);
                $stmt->bindParam(':adminId', $adminId);
                
                if ($stmt->execute()) {
                    $_SESSION["newteam"] = "New team record created successfully";
                    header("Location: allteams.php");
                    exit();
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<style>
    .form-container {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    width: 100%;
    max-width: 600px;
    margin: 50px auto;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.form-title {
    font-size: 24px;
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}

.btn-submit {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    display: block;
    margin: 0 auto;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #0056b3;
}
</style>
<?php include 'inc/sidebar.php'; 
if (isset($_POST["submit"])) {
     $file = $_FILES['logo'];
     print_r($file);
     $filename = $_FILES['logo']['name'];
}
?>
<div class="form-container">
    <h2 class="form-title"><?php echo isset($_GET['id']) ? 'Edit Cricket Team' : 'Create Cricket Team'; ?></h2>
    <form action="teaminfo.php" method="POST" enctype="multipart/form-data">
        <?php if (isset($team['id'])): ?>
            <input type="hidden" name="id" value="<?php echo $team['id']; ?>"> 
        <?php endif; ?>
        <div class="form-group">
            <label for="teamname">Team Name:</label>
            <input type="text" class="form-control" id="teamname" name="teamname" value="<?php echo $team['teamname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="teamcoach">Team Coach:</label>
            <input type="text" class="form-control" id="teamcoach" name="teamcoach" value="<?php echo $team['team_coach']; ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Team City:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $team['location']; ?>" required>
        </div>
        <div class="form-group">
            <label for="logo">Team Logo:</label>
            <input type="file" class="form-control" id="logo" name="logo" value="" >
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-<?php echo isset($_GET['id']) ? 'primary' : 'success'; ?> m-auto d-block" name="submit">submit
        </button>
        </div>
    </form>
</div>

<?php include 'inc/footer.php'; ?>
