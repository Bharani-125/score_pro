<?php 
ob_start();
session_start();
$title = "Feedback";
include 'inc/header.php';
include 'inc/sidebar.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}
.feedback-container {
    width: 30%;
    padding: 30px;
    margin: 50px auto;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}
label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}
input,select,textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
textarea {
    resize: vertical;
}
.submit-fb {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
.submit-fb:hover {
    background-color: #45a049;
}
</style>
<?php
include 'inc/conn.php';
include 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $feature = $_POST['favorite_feature'];
    $improvements = $_POST['improvements'];

    try {
        $sql = 'INSERT INTO feedback ( name, email, rating, favorite_feature, improvements) VALUES (:name, :email, :rating, :feature, :improvements)';
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':feature', $feature);
        $stmt->bindParam(':improvements', $improvements);
        $stmt->execute();
        if ($stmt->execute()): ?>
        <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title " id="invalidModalLabel">Thanks for your feedback</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body"><h6>Feedback submitted successfully</h6>
          </div>
        </div>
      </div>
    </div>
    <script>
      var myModal = new bootstrap.Modal(document.getElementById('invalidModal'));
      myModal.show();
    </script>
        <?php 
           endif;
        ?>
    <?php }
    catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
}
?>
 <div class="feedback-container">
        <h2>Website Feedback</h2>
        <form action="feedback.php" method="POST">

            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name"  required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="rating">How would you rate the website?</label>
            <select id="rating" name="rating" required>
            <option value="">Select</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>

            <label for="favorite_feature">What is your favorite feature?</label>
            <input type="text" id="favorite_feature" name="favorite_feature" required>

            <label for="improvements">What improvements would you like to see?</label>
            <textarea id="improvements" name="improvements" rows="4" required></textarea>
            <button type="submit" class="submit-fb">Submit Feedback</button>

        </form>
    </div>
<?php
include 'inc/footer.php';

?>