<?php 
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/config.php';
?>
<?php
try {
    $read = "SELECT teams.id, teams.teamname, teams.logo, teams.team_coach, teams.location, teams.status, users.fullname 
    FROM teams  
    INNER JOIN users ON teams.created_by = users.id WHERE teams.status = 1";

$stmt = $connect->query($read);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
 
?>
<title>Teams List</title>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Teams List</h2>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
include 'inc/footer.php'
?>