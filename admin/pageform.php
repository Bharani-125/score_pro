<?php
ob_start();
session_start();
$title = isset($_GET['id']) ? "Edit Page" : "Add Page";
include 'inc/header.php';
include 'inc/sidebar.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
include 'inc/conn.php';
include 'inc/config.php';
$existingTitle = '';
$existingContent = '';
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pages WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $page = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($page) {
        $existingTitle = $page['title'];
        $existingContent = $page['content'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id = $_POST['id'] ?? null;

    try {
        if ($id) {
            $sql = "UPDATE pages SET title = :title, content = :content WHERE id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $id);
        } else {
            $sql = "INSERT INTO pages (title, content) VALUES (:title, :content)";
            $stmt = $connect->prepare($sql);
        }
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        
        $_SESSION['post-update'] = "Record updated successfully";
        header('Location: allposts.php');
        exit();
    }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form action="pageform.php<?php echo isset($id) ? '?id=' . $id : ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <h6>Title</h6>
    <input type="text" placeholder="Title" name="title" value="<?php echo $existingTitle; ?>" required>

    <h6>Description</h6> 
    <textarea name="content" id="content" rows="4" placeholder="Content"><?php echo $existingContent; ?></textarea><br>

    <button class="btn btn-primary"><?php echo isset($id) ? 'Update' : 'Submit'; ?></button>
</form>


<style>
    form{
        margin-left: 300px;
        margin-top: 50px;
    }
</style>
<script src="https://cdn.tiny.cloud/1/mqsphduydrgww8n2djq37b0we17snkynzh733aih3zn974ex/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#content',
        plugins: [
          'a11ychecker','advlist','advcode','advtable','autolink','checklist','markdown',
          'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
          'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
        ],
        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
    });
</script>

<?php 
include 'inc/footer.php';
?>
