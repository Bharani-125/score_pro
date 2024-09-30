<?php 
include 'header.php';
include 'inc/conn.php';
include 'inc/config.php';
?>

<style>
    .banner-bg img{
        object-fit:cover;
        height: 400px !important;
        width: 100% !important;
    }
    .team-logo{
        height: 200px;
        width: 200px;
        position: absolute;
        bottom: 10px;
        left: 100px;
    }
    .stats-section {
    padding: 40px 20px;
    background-color: #f5f5f5;
}
.banner-bg img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 40px;
}
.teams-container {
    margin: auto;
    width:50%;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 40px;
    padding: 20px;
}
.teams-container img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}
.teams-details {
    background-color: #f7f7f7;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 20px;
}
.teams-details h6 {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}
.team-stats {
    text-align: center;
    background-color: #fafafa;
    padding: 20px;
    border-radius: 8px;
}
.team-stats h5 {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
}
a.text-decoration-none.text-dark {
    display: inline-block;
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    padding: 10px 20px;
    background-color: #f1f1f1;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    margin-top: 20px;
}

</style>
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
<?php foreach($results as $title): ?>
 <title><?php echo $title['teamname'] ?></title>
 <?php endforeach; ?>
<section class="stats-section">
    <!-- <div class="banner-bg">
        <img src="images/download.jpeg" alt="">
    </div> -->
    <?php foreach($results as $team): ?>
    <div class="teams-container">
        <img src="/CricketScorepro/admin/uploads/<?php echo $team['logo']; ?>" alt="Team Logo" width="100%" height="320px"> 
        <div class="teams-details">
            <h6>Team Coach: <?php echo $team['team_coach']; ?></h6>
            <h6>Team Location: <?php echo $team['location']; ?></h6>
        </div>
        <div class="team-stats">
            <h5 class="pb-1">Matches Played: &nbsp; <?php echo rand(50, 100); ?></h5>
            <h5 class="pb-1">Highest Score: &nbsp; <?php echo rand(80, 200); ?></h5>
            <h5 class="pb-1">Team Captain: &nbsp; <?php echo ""; ?></h5>
            <h5 class="pb-1">Total Wins: &nbsp; <?php echo rand(40, 50); ?></h5>
            <h5 class="pb-1">Matches Lost: &nbsp; <?php echo rand(1, 30); ?></h5>
            <h5 class="pb-1">Toss Won: &nbsp; <?php echo rand(1, 100); ?></h5>
            <h5 class="pb-1">Win Rate: &nbsp; <?php echo rand(1, 80); ?>%</h5>
            <a href="team-stats.php?id=<?php echo $team['id']; ?>" class="text-decoration-none text-dark">

            </a>
        </div>
    </div>
    <?php endforeach; ?>
</section>


<?php 
include 'footer.php';
?>