<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT tweets.id, tweets.content, tweets.created_at, users.username 
                        FROM tweets JOIN users ON tweets.user_id = users.id 
                        ORDER BY tweets.created_at DESC");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Twitter Clone</title>
    <link rel="stylesheet" href="styles.css">
    <script src="chirpify.js"></script>
</head>
<body>
    <a href="logout.php">Uitloggen</a>

    <form action="post_tweet.php" method="POST">
        <textarea name="tweet" placeholder="Wat is er nieuw?" required></textarea>
        <button type="submit">Tweet</button>
    </form>

    <?php while ($tweet = $result->fetch_assoc()): ?>
        <div>
            <strong>@<?= htmlspecialchars($tweet['username']) ?></strong>
            <p><?= htmlspecialchars($tweet['content']) ?></p>
            <small><?= $tweet['created_at'] ?></small>
            <form action="like_tweet.php" method="POST">
                <input type="hidden" name="tweet_id" value="<?= $tweet['id'] ?>">
                <button type="submit">Like</button>
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>
