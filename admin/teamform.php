<?php 
session_start();
$title = isset($_GET['id']) ? 'Edit Team' : 'Add Team'; 
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/config.php';

include 'inc/session-check.php';

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
    $logoFileName = null; 

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $uploads_dir = 'uploads/';

        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        $file_tmp_name = $_FILES['logo']['tmp_name'];
        $file_name = basename($_FILES['logo']['name']);
        $file_destination = $uploads_dir . $file_name;
        if (move_uploaded_file($file_tmp_name, $file_destination)) {
            $logoFileName = $file_name; 
            echo "File uploaded successfully!<br>";
        } else {
            echo "Failed to upload the file.<br>";
        }
    }

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $updatedDate = date('Y-m-d H:i:s');
            $sql = "UPDATE teams SET teamname = :teamname, team_coach = :teamcoach, location = :location, updated_date = :updatedDate";
            
            if ($logoFileName !== null) {
                $sql .= ", logo = :logo";
            }
            
            $sql .= " WHERE id = :id";
    
            $stmt = $connect->prepare($sql);
    
            $stmt->bindParam(':teamname', $teamname);
            $stmt->bindParam(':teamcoach', $teamcoach);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':updatedDate', $updatedDate);
            $stmt->bindParam(':id', $id);
    
            if ($logoFileName !== null) {
                $stmt->bindParam(':logo', $logoFileName);
            }
    
            if ($stmt->execute()) {
                echo "Team updated successfully!<br>";
                header("Location: allteams.php");
                exit();
            } else {
                echo "Failed to update team.<br>";
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

                $sql = "INSERT INTO teams (teamname, team_coach, location, logo, created_by)
                        VALUES (:teamname, :teamcoach, :location, :logo, :adminId)";
                $stmt = $connect->prepare($sql);
                $stmt->bindParam(':teamname', $teamname);
                $stmt->bindParam(':teamcoach', $teamcoach);
                $stmt->bindParam(':location', $location);
                $stmt->bindParam(':logo', $logoFileName);
                $stmt->bindParam(':adminId', $adminId);

                if ($stmt->execute()) {
                    $_SESSION["newteam"] = "New team record created successfully";
                    echo "New team record created successfully!<br>";
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
<?php 
if (isset($_POST["submit"])) {
     $file = $_FILES['logo'];
     print_r($file);
     $filename = $_FILES['logo']['name'];
}
?>
<section class="d-flex">
    <?php 
    include 'inc/sidebar.php'; 
    ?>

<div class="team-form-container">
    <h2 class="form-title"><?php echo isset($_GET['id']) ? 'Edit Cricket Team' : 'Create Cricket Team'; ?></h2>
    <form action="teamform.php" method="POST" enctype="multipart/form-data">
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
</section>

<?php include 'inc/footer.php'; ?>
