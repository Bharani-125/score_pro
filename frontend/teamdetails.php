<?php 
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/config.php';
?>
<title>Match Highlights</title>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $read = "SELECT teams.id, teams.teamname, teams.logo, teams.team_coach, teams.location, teams.status, users.fullname 
                 FROM teams
                 INNER JOIN users ON teams.created_by = users.id
                 WHERE teams.id = :id AND teams.status = 1";
        $stmt = $connect->prepare($read);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute(); 
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No team ID provided.";
}
?>
<section class="highlights container mt-5 bg-secondary">
    <h2 class="text-center mb-4">Teams List with Highlights</h2>
    <div class="teams-responsive ">
        <?php foreach($results as $team): ?>
        <div class="team-container mb-5 border-0">
            <div class="row">
                <div class="col-md-6">
                    <a href="team-stats.php?id=<?php echo $team['id']; ?>" class="text-decoration-none text-dark">
                        <img src="/CricketScorepro/admin/uploads/<?php echo $team['logo']; ?>" alt="Team Logo" class="w-100" style="max-height: 400px; object-fit: cover;">
                        <h5 class="text-center pt-2"><?php echo $team['teamname']; ?></h5>
                    </a>
                    <div class="team-details text-center bg-dark pt-3 mt-3 py-2 text-white">
                        <h6>Team Location: <?php echo $team['location']; ?></h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="pb-1">Matches Played: &nbsp; <?php echo rand(50, 100); ?></h5>
                    <h5 class="pb-1">Highest Score: &nbsp; <?php echo rand(80, 200); ?></h5>
                    <h5 class="pb-1">Team Captain: &nbsp; <?php echo ""; ?></h5>
                    <h5 class="pb-1">Total Wins: &nbsp; <?php echo rand(40, 50); ?></h5>
                    <h5 class="pb-1">Matches Lost: &nbsp; <?php echo rand(1, 30); ?></h5>
                    <h5 class="pb-1">Toss Won: &nbsp; <?php echo rand(1, 100); ?></h5>
                    <h5 class="pb-1">Win Rate: &nbsp; <?php echo rand(1, 80); ?>%</h5>
                </div>
            </div>
        </div>
        <div class="row iframe-container mt-3">
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/Yr98Gb4vgb4?si=m48rzbnDbsUE5th2" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/P1GoOvVGzrU?si=LApKdsY-60_M0b0M" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/rCyKRWussaw?si=BJ4yg7mFzXrgnMMO" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/vGgvJhA7gyk?si=IKEyUj6waZ8fRF4G" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>


<?php 
include 'inc/footer.php';
?>
