<?php
session_start();
$title = "All Users"; 
include 'inc/header.php';

include 'inc/session-check.php';
?>

<!-- modal for created msg -->
<?php
if(isset($_SESSION['newrecord'])): ?>
    <div class="modal fade" id="recordModal" tabindex="-1" aria-labelledby="recordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="recordModalLabel"><?php echo $_SESSION['newrecord']; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Operation successful.
          </div>
        </div>
      </div>
    </div>
    <script>
      var recordModal = new bootstrap.Modal(document.getElementById('recordModal'));
      recordModal.show();
    </script>
    <?php
    unset($_SESSION['newrecord']);
endif;
?>

<!-- modal for deleted msg -->
<?php
if(isset($_SESSION['message'])): ?>
    <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invalidModalLabel">Record deleted successfully</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['message']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var myModal = new bootstrap.Modal(document.getElementById('invalidModal'));
      myModal.show();
    </script>
    <?php
    unset($_SESSION['message']);
endif;
?>
<?php
if(isset($_SESSION['editmessage'])): ?>
    <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invalidModalLabel">Record updated successfully</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['editmessage']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var myModal = new bootstrap.Modal(document.getElementById('invalidModal'));
      myModal.show();
    </script>
    <?php
    unset($_SESSION['editmessage']);
endif;
?>
<!-- only super admin can acsess -->
<?php
include 'inc/conn.php';
include 'inc/config.php';
try {
    $email = $_SESSION['email'];
    $sql = "SELECT usertype FROM users WHERE email = :email";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
  include 'inc/conn.php';
  include 'inc/config.php';
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pagination logic
    $results_per_page = 5;  // Number of results per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page or default to page 1
    $starting_limit = ($page - 1) * $results_per_page;

    // Query to fetch users with pagination
    $query = $connect->prepare("SELECT id, email, fullname, usertype, status FROM users WHERE status = 1 LIMIT :start, :limit");
    $query->bindValue(':start', $starting_limit, PDO::PARAM_INT);
    $query->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    // Total pages calculation
    $total_query = $connect->query("SELECT COUNT(*) FROM users WHERE status = 1");
    $total_rows = $total_query->fetchColumn();
    $total_pages = ceil($total_rows / $results_per_page);

?>

<h2 class="ml-3 mt-3 mb-3">Users List</h2>
<div class="add-user">
    <a href="userform.php"><button class="m-3 me-4 p-2 add-user-btn btn fw-bold">Add user</button></a>
</div>

<section class="user-sec" id="table">
  <?php 
  include 'inc/sidebar.php';
  ?>
    <table border="1" class="table table-striped table-hover user-table">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Fullname</th>
                <th class="text-center">E-mail</th>
                <th class="text-center">User Type</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $row) : ?>
            <tr>
                <td class="text-center"><?php echo $row['id']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['usertype']; ?></td>
                <td>
                    <a href="userinfo.php?id=<?php echo $row['id']; ?>" class="text-decoration-none">
                        <img src="inc/images/user-avatar.png" width="22px" title="Edit user">
                    </a> |
                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                        <img src="inc/images/bin.png" width="22px" title="Delete user">
                    </a>
                </td>
            </tr>
            <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the record for <?php echo $row['fullname']; ?>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="deleteuser.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $page - 1; ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $page + 1; ?>">Next</a>
        </li>
    </ul>
</nav>
<?php 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include 'inc/footer.php'; 
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  aside{
    position: relative !important;
    top: -143px !important;
    left: -61px !important;
  }
</style>