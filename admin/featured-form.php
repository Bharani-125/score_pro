<?php 
session_start();
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/config.php';

// Initialize variables to avoid undefined variable warnings
$id = null;
$title = '';
$image = '';

if (isset($_GET['id'])) {
    // Fetch existing data if an id is passed in the URL
    $id = $_GET['id'];
    $query = "SELECT * FROM featured_in WHERE id = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        $title = $record['title'];
        $image = $record['image'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $title = $_POST['title'];
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    // Handle file upload if a new image is provided
    if ($image && $image['name'] != '') {
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $uploadDir = __DIR__ . '/../frontend/featured-in-images/' . $imageName;

        if (move_uploaded_file($imageTmpName, $uploadDir)) {
            $imageQuery = ", image = :image";
        } else {
            echo "Failed to upload the image.";
            exit();
        }
    } else {
        $imageQuery = '';
        $imageName = $image; // Retain old image if none is uploaded
    }

    // Update existing record or insert new one
    if ($id) {
        $query = "UPDATE featured_in SET title = :title $imageQuery WHERE id = :id";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);

        if ($imageQuery) {
            $stmt->bindParam(':image', $imageName);
        }
    } else {
        $query = "INSERT INTO featured_in (title, image) VALUES (:title, :image)";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image', $imageName);
    }

    // Execute and redirect if successful
    if ($stmt->execute()) {
        $_SESSION['editmessage'] = $id ? "Updated Successfully" : "Added Successfully";
        header('Location: featured-in.php');
        exit();
    } else {
        echo "Failed to update the database.";
    }
}
?>

<section class="fi-form">
    <form action="featured-form.php<?php echo $id ? '?id=' . $id : ''; ?>" method="post" enctype="multipart/form-data" class="fi-add form-control mt-5 mb-5">
        <h3 class="text-secondary text-center h4 p-3 mb-3">
            <?php echo isset($id) && $id ? 'Update Image' : 'Add New Image'; ?>
        </h3>
        
        <!-- Hidden input to pass the ID for update -->
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>

        <!-- Title input with value pre-filled if updating -->
        <input type="text" name="title" placeholder="Title" class="form-control mb-3" value="<?php echo $title; ?>" required>

        <!-- File input; image is required if adding, but optional if updating -->
        <input type="file" name="image" accept="image/*" class="form-control mb-3" <?php echo !$id ? 'required' : ''; ?>>

        <!-- Show current image if updating -->
        <?php if ($image && $id): ?>
            <div class="mb-3 text-center">
                <img src="/CricketScorepro/frontend/featured-in-images/<?php echo $image; ?>" width="100">
            </div>
        <?php endif; ?>

        <!-- Submit button text changes depending on action -->
        <button type="submit" class="btn btn-success m-auto d-block">
            <?php echo isset($id) && $id ? 'Update' : 'Add'; ?>
        </button>
    </form>
</section>

<?php include 'inc/footer.php'; ?>
