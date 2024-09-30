<?php 
ob_start();
session_start();
$title = 'All Pages';
include 'inc/header.php';

include 'inc/conn.php';
include 'inc/config.php';
include 'inc/session-check.php';
?>

<title>All Pages</title>
<div class="add-user">
   <a href="pageform.php"><button class="m-3 me-4 p-2 add-user-btn btn fw-bold">Add Page</button></a>
</div>

<?php 
try {
    $read = "SELECT id, title, content FROM pages WHERE status = 1";
    $stmt = $connect->query($read);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($results) {
?>
   <section class="d-flex flex-wrap pages-sec">
    <?php 
    include 'inc/sidebar.php';
    ?>
   <table class="pages-table">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($results as $post) { ?>
            <tr>
                <td><?php echo $post['id']; ?></td>
                <td><?php echo $post['title']; ?></td>
                <td>
                    <a href="pageform.php?id=<?php echo $post['id']; ?>" class="text-decoration-none">
                        <img src="inc/images/user-avatar.png" width="22px">
                    </a> |
                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $post['id']; ?>">
                      <img src="inc/images/bin.png" width="22px" title="Delete">
                    </a>
                    <div class="modal fade" id="deleteModal<?php echo $post['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $post['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel<?php echo $post['id']; ?>">Confirm Deletion</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this post?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <a href="deletepage.php?id=<?php echo $post['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
            </tr>
            <?php } ?>
        </table>
        </section>
<?php 
// var_dump($_SESSION['post-update']);
    } else {
        echo '<p>No posts found.</p>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
if (isset($_SESSION['post-update'])): ?>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateModalLabel">Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['post-update']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
      updateModal.show();
    </script>
    <?php
    unset($_SESSION['post-update']);
endif;
?>
<?php
if (isset($_SESSION['post-delete'])): ?>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateModalLabel">Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['post-delete']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
      updateModal.show();
    </script>
    <?php
    unset($_SESSION['post-delete']);
endif;
?>

<?php 
include 'inc/footer.php';
?>

<style>
  aside{
    position: relative !important;
    top: -70px !important;
    left: -1px !important;
  }
</style>
<style>
   .pages-sec .add-user-btn {
      width: 100px;
      border: 1px solid #2271b1 !important;
      color: #2271b1 !important;
   }
   .pages-sec .add-user{
      display: flex;
      justify-content: end;
   }
   .pages-table{
    height: 30vh;
   }
   .pages-table {
      width: 80%;
      margin: 20px 0;
      margin-left: 30px;
   }
    .pages-table, th, td {
      border: 1px solid #ccc;
   }
   .pages-table,th, td {
      padding: 12px 15px;
      text-align: left;
   }
    .pages-table th {
      background-color: #2271b1; 
       color: white;
   } 
   .pages-table tr:nth-child(even) {
      background-color: #f2f2f2;
   }
   .content-column {
      max-width: 200px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }
   .content-column:hover {
      overflow: visible;
      white-space: normal;
      word-wrap: break-word;
      position: relative;
      z-index: 1;
      background-color: #fff;
      box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
   } 
   .pages-sec{
    height: 77vh;
   } 
</style>
