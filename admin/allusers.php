<?php
session_start();
$title = "All Users"; 
include 'inc/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<style>
   #table{
     height: auto;
   }
   table{
    width: 80% !important;
    margin-right: 30px;
   }
   section{
    display: flex !important;
    justify-content: end !important;
   }
   #table{
    margin-bottom: 50px;
   }
   th,td{
    text-align: center;
    border-right: 0.5px solid #dee2e6 !important;
   }  
   .add-user-btn{
    width: 100px;
    border: 1px solid #2271b1 !important;
    color: #2271b1 !important;
   }
   .add-user{
    display: flex;
    justify-content: end;
   }
   th{
      background-color: #2271b1 !important; 
       color: white !important;
   }
</style>
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
include 'inc/sidebar.php';
try {
    $read = "SELECT id, email, fullname, usertype, status FROM users WHERE status = 1";
    $stmt = $connect->query($read);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="text-center mt-3 mb-3">Users List</h2>
<div class="add-user">
<a href="userinfo.php"><button class="m-3 me-4 p-2 add-user-btn btn fw-bold">Add user</button></a>
</div>

<section id='table'>
  <table border='1' class='table table-striped table-hover'>
    <tr>
      <th class='text-center'>ID</th>
      <th class='text-center'>Fullname</th>
      <th class='text-center'>E-mail</th>
      <th class='text-center'>User Type</th>
      <th class='text-center'>Actions</th>
    </tr>

    <?php foreach ($results as $row) : ?>
    <tr>
      <td class='text-center'><?php echo $row['id']; ?></td>
      <td><?php echo $row['fullname']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['usertype']; ?></td>
      <td>
        <a href='userinfo.php?id=<?php echo $row['id']; ?>' class="text-decoration-none">
          <img src='inc/images/user-avatar.png' width='22px' title='Edit user'>
        </a> |
        <a href='#' data-bs-toggle='modal' data-bs-target='#deleteModal<?php echo $row['id']; ?>'>
          <img src='inc/images/bin.png' width='22px' title='Delete user'>
        </a>
      </td>
    </tr>
    <div class='modal fade' id='deleteModal<?php echo $row['id']; ?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Confirm Delete</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            Are you sure you want to delete the record for <?php echo $row['fullname']; ?>?
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <a href='deleteuser.php?id=<?php echo $row['id']; ?>' class='btn btn-danger'>Delete</a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </table>
</section>
<?php 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php 
include 'inc/footer.php';
?>