<?php
session_start();
$title = "All Teams"; 
include 'inc/header.php';
include 'inc/session-check.php';
?>

<!-- modal for created msg -->
<?php
if(isset($_SESSION['newteam'])): ?>
    <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invalidModalLabel">New record created successfully</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['newteam']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var myModal = new bootstrap.Modal(document.getElementById('invalidModal'));
      myModal.show();
    </script>
    <?php
    unset($_SESSION['newteam']);
endif;
?>
<!-- modal for deleted msg -->
<?php
if(isset($_SESSION['teamdelete'])): ?>
    <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invalidModalLabel">Record deleted successfully</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['teamdelete']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var myModal = new bootstrap.Modal(document.getElementById('invalidModal'));
      myModal.show();
    </script>
    <?php
    unset($_SESSION['teamdelete']);
endif;
?>
<?php
if(isset($_SESSION['update_success'])): ?>
    <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invalidModalLabel">Record updated successfully</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['update_success']; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      var myModal = new bootstrap.Modal(document.getElementById('invalidModal'));
      myModal.show();
    </script>
    <?php
    unset($_SESSION['update_success']);
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
  $read = "SELECT teams.id, teams.teamname, teams.logo, teams.team_coach, teams.location, teams.status, users.fullname 
             FROM teams  
             INNER JOIN users ON teams.created_by = users.id WHERE teams.status = 1";
    
    $stmt = $connect->query($read);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="ml-3 mt-3 mb-3">Teams List</h2>
<div class="add-teams">
<a href="teamform.php"><button class="m-3 me-4 p-2 add-teams-btn btn fw-bold">Add team</button></a>
</div>
<section class=' d-flex team-section'>
  <?php 
  include 'inc/sidebar.php';
  ?>
  <table border='1' class='table table-striped table-hover team-table ms-5 me-5'>
    <tr>
      <th class='text-center'>ID</th>
      <th class='text-center'>Team Name</th>
      <th class='text-center'>Team Logo</th>
      <th class='text-center'>Team Coach</th>
      <th class='text-center'>Location</th>
      <th class='text-center'>Created by</th>
      <th class='text-center'>Actions</th>
    </tr>
    
    <?php foreach ($results as $row) :?>
      
      <tr>
        <td class='text-center'><?php echo $row['id']; ?></td>
        <td><?php echo $row['teamname']; ?></td>
        <td><img src="/CricketScorepro/admin/uploads/<?php echo $row['logo']; ?>" alt="Team Logo" style="width: 50px; height: auto;"></td>
        <td><?php echo $row['team_coach']; ?></td>
        <td><?php echo $row['location']; ?></td>
        <td><?php echo $row['fullname']; ?></td>
        <td>
          <a href='teamform.php?id=<?php echo $row['id']; ?>' class="text-decoration-none">
            <img src='inc/images/user-avatar.png' width='22px'>
          </a> |
          <a href='#' data-bs-toggle='modal' data-bs-target='#deleteModal<?php echo $row['id']; ?>'>
            <img src='inc/images/bin.png' width='22px' title='Delete'>
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
              Are you sure you want to delete the record for <?php echo $row['teamname']; ?>?
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
              <a href='deleteam.php?id=<?php echo $row['id']; ?>' class='btn btn-danger'>Delete</a>
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
<style>
  aside{
    position: relative !important;
    top: -143px !important;
    left: -5px !important;
  }
</style>
<?php 
include 'inc/footer.php';
?>
