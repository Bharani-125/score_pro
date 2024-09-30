<?php 
session_start();
include 'inc/header.php';
?>

<div class="container d-flex justify-content-between align-items-center">
    <h2 class="ms-3 mt-3 mb-3">Teams List</h2>
    <a href="featured-form.php"><button class="btn add-img">Add Image</button></a>
</div>

<section class="d-flex">
<?php 
include 'inc/sidebar.php';
include 'inc/conn.php';
include 'inc/config.php';

try {
    $read = "SELECT id, title, image FROM featured_in";
    $stmt = $connect->query($read);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<table class="table f-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($images as $image): ?>
        <tr>
            <td class="pe-5"><?php echo $image['id']; ?></td>
            <td class="pe-5"><?php echo $image['title']; ?></td>
            <td class="pe-5">
                <img src="/CricketScorepro/frontend/featured-in-images/<?php echo $image['image']; ?>" width="100">
            </td>
            <td>
                <a href="featured-form.php?id=<?php echo $image['id']; ?>" class="btn btn-info text-light">Update</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $image['id']; ?>">Delete</button>
            </td>
        </tr>
        <div class="modal fade" id="deleteModal<?php echo $image['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $image['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel<?php echo $image['id']; ?>">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the record for "<?php echo $image['title']; ?>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="delete-featured.php?id=<?php echo $image['id']; ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </tbody>
</table>
</section>

<?php include 'inc/footer.php'; ?>

<?php if (isset($_SESSION['message'])): ?>
    <script>
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal<?php echo $_SESSION['id']; ?>'));
        deleteModal.show();
    </script>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['editmessage'])): ?>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Record updated successfully</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $_SESSION['editmessage']; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    </script>
    <?php unset($_SESSION['editmessage']); ?>
<?php endif; ?>

<style>
    aside {
        position: relative !important;
        top: -69px !important;
        left: -6px !important;
    }
</style>
