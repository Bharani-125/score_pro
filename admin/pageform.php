<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
ob_start();
session_start();
$title = isset($_GET['id']) ? "Edit Page" : "Add Page";
include 'inc/header.php';
include 'inc/session-check.php';
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
    date_default_timezone_set('Asia/Kolkata');
    $updatedDate = date('Y-m-d H:i:s');

    try {
        if ($id) {
            $sql = "UPDATE pages SET title = :title, content = :content,updated_date = :updatedDate WHERE id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $id);
            
        } else {
            $sql = "INSERT INTO pages (title, content) VALUES (:title, :content)";
            $stmt = $connect->prepare($sql);
        }

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':updatedDate', $updatedDate);
        $stmt->execute();

        $_SESSION['post-update'] = "Record updated successfully";
        header('Location: allpages.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
 <section class="d-flex">
    <?php 
    include 'inc/sidebar.php';
    ?>
<form action="pageform.php<?php echo isset($id) ? '?id=' . $id : ''; ?>" method="post" enctype="multipart/form-data" class="ms-5 mt-5">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <h6>Title</h6>
    <input type="text" placeholder="Title" name="title" value="<?php echo $existingTitle; ?>" required>

    <h6>Description</h6> 
    <textarea name="content" id="content" rows="4" placeholder="Content"><?php echo $existingContent; ?></textarea><br>

    <button class="btn btn-primary"><?php echo isset($id) ? 'Update' : 'Submit'; ?></button>
</form>
</section>
<!-- TinyMCE Script -->
<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.1/ckeditor5.css">
<script type="module">
			import {
				ClassicEditor,
				Essentials,
				Paragraph,
				Bold,
				Italic,
				Font
			} from 'ckeditor5';
			ClassicEditor
				.create( document.querySelector( '#content' ), {
					plugins: [ Essentials, Paragraph, Bold, Italic, Font ],
					toolbar: [
						'undo', 'redo', '|', 'bold', 'italic', '|',
						'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
					]
				} )
				.then( editor => {
					window.editor = editor;
				} )
				.catch( error => {
					console.error( error );
				} );
		</script>

<?php 
include 'inc/footer.php';
?>

