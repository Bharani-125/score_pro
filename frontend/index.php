<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score-Pro</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<style>
    .up-btn{
        position: fixed;
        right: 60px;
        bottom: 100px;
        z-index: 10;
    }
</style>
<?php 
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/config.php';
?>
<div class="up-btn ">
    <a href="#header"><img src="images/up-arrow.png" alt="" width="60px"></a>
</div>
<!-- banner section -->
    <section class="banner-section">
           <div>
              <img src="images/download.png" alt=""  class="banner-img">
           </div>

           <div class="banner">
              <h1 class="Banner Title">
              Live Cricket Scores, Fast and Reliable</h1>
              <p>Track live cricket scores from around the globe, follow your favorite teams, and never miss a moment of the action. We deliver real-time updates, in-depth stats, and match highlights—all in one place.</p>
              <div>
                <a href="https://play.google.com/store/games?hl=en"><img src="images/googlestore.png" alt="" class="me-4"></a>
                <a href="https://www.apple.com/in/app-store/"><img src="images/applestore.png" alt=""></a>
              </div>
           </div>
    </section>
<!-- teams list -->
 <section>
 <?php
try {
    $read = "SELECT teams.id, teams.teamname, teams.logo, teams.team_coach, teams.location, teams.status, users.fullname 
    FROM teams  
    INNER JOIN users ON teams.created_by = users.id 
    WHERE teams.status = 1  
    LIMIT 3 OFFSET 1";

$stmt = $connect->query($read);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $read = "SELECT id, title, image FROM featured_in";
    $stmt = $connect->query($read);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
 
?>
<h2 class="text-center mb-3 mt-5 ">Teams List</h2>
<div class="d-flex justify-content-end container">
    <a href="teams.php"><button class="btn btn-info text-light fs-5 more-button pe-3 ps-3 pt-2">More</button></a>
</div>
<div class="container mt-5"> 
    <div class="teams-responsive">
        <?php foreach($results as $team): ?>
            <div class="team-container">
                <a href="team-stats.php?id=<?php echo $team['id']; ?>" class="text-decoration-none text-dark">
                    <img src="/CricketScorepro/admin/uploads/<?php echo $team['logo']; ?>" alt="Team Logo" width="100%" height="320px">
                    <h5 class="text-center pt-2"><?php echo $team['teamname']; ?></h5>
                </a>
                <div class="team-details">
                    <h6>Team Coach: <?php echo $team['team_coach']; ?></h6>
                    <h6>Team Location: <?php echo $team['location']; ?></h6>
                </div>
                <div class="stats">
                    <h5 class="pb-1">Matches Played: &nbsp; <?php echo rand(50, 100); ?></h5>
                    <h5 class="pb-1">Highest Score: &nbsp; <?php echo rand(80, 200); ?></h5>
                    <h5 class="pb-1">Team Captain: &nbsp; <?php echo ""; ?></h5>
                    <h5 class="pb-1">Total Wins: &nbsp; <?php echo rand(40, 50); ?></h5>
                    <h5 class="pb-1">Matches Lost: &nbsp; <?php echo rand(1, 30); ?></h5>
                    <h5 class="pb-1">Toss Won: &nbsp; <?php echo rand(1, 100); ?></h5>
                    <h5 class="pb-1">Win Rate: &nbsp; <?php echo rand(1, 80); ?>%</h5>
                    <a href="teamdetails.php?id=<?php echo $team['id']; ?>" class="text-decoration-none text-dark"><button class="mb-1 Highlights">Watch Highlights</button></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
 </section>

<!-- featured section -->
<section class="container featured-section">
    <h2>Featured In</h2>
    <marquee behavior="" direction="left" class="marquee" scrollamount="20">
        <?php foreach ($images as $image): ?>
            <img src="/CricketScorepro/frontend/featured-in-images/<?php echo $image['image']; ?>" alt="<?php echo $image['title']; ?>">
        <?php endforeach; ?>
    </marquee>
</section>

<?php 
include 'inc/footer.php';
?>
</body>
</html>
