<?php 
$title = "Feedback";
include 'inc/header.php';

?>
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