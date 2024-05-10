<?php 

$pageTitle = 'Statistics';


require_once dirname(__FILE__) . '/assets/phptools/template_top.php';

require_once dirname(__FILE__) . '/assets/phptools/databaseFunctions.php';



session_start_secure();



$query = $db->prepare("SELECT * FROM user_stats WHERE user_id = :user_id");
$query->bindValue(':user_id', $_SESSION['id']);
$query->execute();
$stats = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">User Statistics</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <tr><th>Username:</th><td><?php echo $stats['username']; ?></td></tr>
                <tr><th>Followers Count:</th><td><?php echo $stats['followers_count']; ?></td></tr>
                <tr><th>Following Count:</th><td><?php echo $stats['following_count']; ?></td></tr>
                <tr><th>Total Posts:</th><td><?php echo $stats['total_posts']; ?></td></tr>
                <tr><th>Average Posts per week:</th><td><?php echo $stats['avg_posts_per_week']; ?></td></tr>
                <tr><th>Average Posts per month:</th><td><?php echo $stats['avg_posts_per_month']; ?></td></tr>
                <tr><th>Total Likes given:</th><td><?php echo $stats['total_likes_given']; ?></td></tr>
                <tr><th>Average Likes given per week:</th><td><?php echo $stats['avg_likes_given_per_week']; ?></td></tr>
                <tr><th>Average Likes given per month:</th><td><?php echo $stats['avg_likes_given_per_month']; ?></td></tr>
                <tr><th>Total Likes received:</th><td><?php echo $stats['total_likes_received']; ?></td></tr>
                <tr><th>Average Likes received per week:</th><td><?php echo $stats['avg_likes_received_per_week']; ?></td></tr>
                <tr><th>Average Likes received per month:</th><td><?php echo $stats['avg_likes_received_per_month']; ?></td></tr>
            </table>
        </div>
    </div>
</div>

<?php require_once dirname(__FILE__) . '/assets/phptools/template_bot.php'; ?>