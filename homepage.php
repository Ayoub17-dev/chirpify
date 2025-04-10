<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';




error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION["user_id"])) {
    header("Location: loginpage.html");
    exit();
}

$userId = $_SESSION["user_id"];


$userData = [
    'username' => 'User',
    'profile_pic' => 'default.jpg',
    'banner_pic' => 'banner.jpg',
    'bio' => 'No bio yet'
];

try {
    $userQuery = $conn->prepare("SELECT username, email, 
                               COALESCE(profile_pic, 'default.jpg') AS profile_pic,
                               COALESCE(banner_pic, 'banner.jpg') AS banner_pic,
                               COALESCE(bio, 'No bio yet') AS bio
                               FROM users WHERE id = ?");
    $userQuery->bind_param("i", $userId);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    
    if ($userResult->num_rows > 0) {
        $userData = array_merge($userData, $userResult->fetch_assoc());
    }
} catch (Exception $e) {
    error_log("User query error: " . $e->getMessage());
}


$stats = [
    'post_count' => 0,
    'follower_count' => 0,
    'following_count' => 0
];

try {
    $statsQuery = "SELECT 
                  (SELECT COUNT(*) FROM tweets WHERE user_id = ?) AS post_count,
                  (SELECT COUNT(*) FROM followers WHERE following_id = ?) AS follower_count,
                  (SELECT COUNT(*) FROM followers WHERE follower_id = ?) AS following_count";
    $statsStmt = $conn->prepare($statsQuery);
    $statsStmt->bind_param("iii", $userId, $userId, $userId);
    $statsStmt->execute();
    $statsResult = $statsStmt->get_result();
    
    if ($statsResult->num_rows > 0) {
        $stats = array_merge($stats, $statsResult->fetch_assoc());
    }
} catch (Exception $e) {
    error_log("Stats query error: " . $e->getMessage());
}


$tweets = [];
try {
    $tweetsQuery = $conn->prepare("SELECT t.*, u.username, 
                                  COALESCE(u.profile_pic, 'default.jpg') AS profile_pic,
                                  (SELECT COUNT(*) FROM likes WHERE tweet_id = t.id) AS like_count,
                                  (SELECT COUNT(*) FROM comments WHERE tweet_id = t.id) AS comment_count,
                                  EXISTS(SELECT 1 FROM likes WHERE tweet_id = t.id AND user_id = ?) AS is_liked
                                  FROM tweets t
                                  JOIN users u ON t.user_id = u.id
                                  ORDER BY t.created_at DESC");
    $tweetsQuery->bind_param("i", $userId);
    $tweetsQuery->execute();
    $tweetsResult = $tweetsQuery->get_result();
    
    if ($tweetsResult->num_rows > 0) {
        $tweets = $tweetsResult->fetch_all(MYSQLI_ASSOC);
    }
} catch (Exception $e) {
    error_log("Tweets query error: " . $e->getMessage());
}


$userTweets = [];
try {
    $userTweetsQuery = $conn->prepare("SELECT t.*, 
                                     (SELECT COUNT(*) FROM likes WHERE tweet_id = t.id) AS like_count,
                                     (SELECT COUNT(*) FROM comments WHERE tweet_id = t.id) AS comment_count,
                                     EXISTS(SELECT 1 FROM likes WHERE tweet_id = t.id AND user_id = ?) AS is_liked
                                     FROM tweets t
                                     WHERE t.user_id = ? 
                                     ORDER BY t.created_at DESC");
    $userTweetsQuery->bind_param("ii", $userId, $userId);
    $userTweetsQuery->execute();
    $userTweetsResult = $userTweetsQuery->get_result();
    
    if ($userTweetsResult->num_rows > 0) {
        $userTweets = $userTweetsResult->fetch_all(MYSQLI_ASSOC);
    }
} catch (Exception $e) {
    error_log("User tweets query error: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postChirpBtn'])) {
    $content = trim($_POST['content'] ?? '');
    $tweetImage = null;
    $error = null;

    if (empty($content)) {
        $error = "Tweet content cannot be empty";
    } else {
        
        if (isset($_FILES['tweet_image']) && $_FILES['tweet_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['tweet_image']['type'];
            
            if (in_array($fileType, $allowedTypes)) {
                $imageName = time() . '_' . basename($_FILES['tweet_image']['name']);
                $imagePath = $uploadDir . $imageName;
                
                if (move_uploaded_file($_FILES['tweet_image']['tmp_name'], $imagePath)) {
                    $tweetImage = $imagePath;
                } else {
                    $error = "Failed to upload image";
                }
            }
        }
        
        try {
            $query = "INSERT INTO tweets (user_id, content, tweet_image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iss", $userId, $content, $tweetImage);
            
            if ($stmt->execute()) {
                header("Location: homepage.php");
                exit();
            } else {
                $error = "Error posting tweet: " . $conn->error;
            }
        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'like' && isset($_POST['tweet_id'])) {
        $tweetId = $_POST['tweet_id'];
        $stmt = $conn->prepare("INSERT INTO likes (user_id, tweet_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $tweetId);
        $stmt->execute();
        header("Location: homepage.php");
        exit();
    } elseif ($_POST['action'] === 'unlike' && isset($_POST['tweet_id'])) {
        $tweetId = $_POST['tweet_id'];
        $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND tweet_id = ?");
        $stmt->bind_param("ii", $userId, $tweetId);
        $stmt->execute();
        header("Location: homepage.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirpify</title>
    <link rel="stylesheet" href="twitter.css">

</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">Chirpify</div>
            <a href="#home" class="active"><span>🏠</span> <span>Home</span></a>
            <a href="#profile"><span>👤</span> <span>Profile</span></a>
            <a href="#settings"><span>⚙️</span> <span>Settings</span></a>
            <a href="logout.php" id="logoutBtn"><span>🔓</span> <span>Log Out</span></a>
        </aside>

        <main class="content">
            <section id="home">
                <h2>Home</h2>
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
               
                <div class="chirp-form">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="chirp-form-container">
                            <img src="<?php echo htmlspecialchars($userData['profile_pic']); ?>" 
                                 alt="Profile Picture" class="chirp-form-avatar">
                            <div class="chirp-form-content">
                                <textarea name="content" placeholder="What's happening?" required></textarea>
                                <div class="chirp-form-actions">
                                    <div class="chirp-form-icons">
                                        <input type="file" id="tweet_image" name="tweet_image" accept="image/*" style="display:none;">
                                        <label for="tweet_image" title="Add image">📷</label>
                                    </div>
                                    <button type="submit" name="postChirpBtn" class="chirp-button">Chirp</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="chirps">
                    <?php if (!empty($tweets)): ?>
                        <?php foreach ($tweets as $tweet): ?>
                            <div class="chirp <?php echo $tweet['user_id'] == $userId ? 'active-user' : ''; ?>">
                                <div class="chirp-header">
                                    <img src="<?php echo htmlspecialchars($tweet['profile_pic']); ?>" 
                                         alt="Profile Picture" class="chirp-avatar">
                                    <div class="chirp-user">
                                        <strong><?php echo htmlspecialchars($tweet['username']); ?></strong>
                                        <span>@<?php echo htmlspecialchars(strtolower(str_replace(' ', '', $tweet['username']))); ?></span>
                                    </div>
                                    <span class="chirp-time">
                                        <?php echo date('M j, Y g:i a', strtotime($tweet['created_at'])); ?>
                                    </span>
                                </div>
                                <div class="chirp-content">
                                    <p><?php echo htmlspecialchars($tweet['content']); ?></p>
                                    <?php if (!empty($tweet['tweet_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($tweet['tweet_image']); ?>" class="chirp-image">
                                    <?php endif; ?>
                                    <div class="chirp-actions">
    
    <?php if ($tweet['user_id'] == $userId): ?>
        <form method="POST" action="delete_tweet.php" style="display:inline;">
            <input type="hidden" name="tweet_id" value="<?php echo $tweet['id']; ?>">
            <button type="submit" class="chirp-action delete-btn">🗑️ Delete</button>
        </form>
    <?php endif; ?>
</div> 
                                </div>
                                <div class="chirp-actions">
                                    <a href="view_tweet.php?id=<?php echo $tweet['id']; ?>" class="chirp-action">💬 <?php echo $tweet['comment_count']; ?></a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="tweet_id" value="<?php echo $tweet['id']; ?>">
                                        <input type="hidden" name="action" value="<?php echo $tweet['is_liked'] ? 'unlike' : 'like'; ?>">
                                        <button type="submit" class="chirp-action like-btn <?php echo $tweet['is_liked'] ? 'liked' : ''; ?>">
                                            ❤️ <?php echo $tweet['like_count']; ?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">No chirps yet. Be the first to post!</div>
                    <?php endif; ?>
                </div>
            </section>

            
            <section id="profile" style="display:none;">
                <div class="profile-header">
                    <div class="profile-banner" style="background-image: url('<?php echo htmlspecialchars($userData['banner_pic']); ?>')"></div>
                    <img src="<?php echo htmlspecialchars($userData['profile_pic']); ?>" 
                         alt="Profile Picture" class="profile-picture">
                    <h1><?php echo htmlspecialchars($userData['username']); ?></h1>
                    <p>@<?php echo htmlspecialchars(strtolower(str_replace(' ', '', $userData['username']))); ?></p>
                    <button onclick="editProfile()">Edit Profile</button>
                </div>
                <div class="profile-info">
                    <div>
                        <h3>Posts</h3>
                        <p><?php echo htmlspecialchars($stats['post_count']); ?></p>
                    </div>
                    <div>
                        <h3>Followers</h3>
                        <p><?php echo htmlspecialchars($stats['follower_count']); ?></p>
                    </div>
                    <div>
                        <h3>Following</h3>
                        <p><?php echo htmlspecialchars($stats['following_count']); ?></p>
                    </div>
                </div>
                <div class="bio-section">
                    <h3>Bio</h3>
                    <p><?php echo htmlspecialchars($userData['bio']); ?></p>
                </div>
                <div class="profile-chirps">
                    <h2>Your Chirps</h2>
                    <?php if (!empty($userTweets)): ?>
                        <?php foreach ($userTweets as $tweet): ?>
                            <div class="chirp">
                                <div class="chirp-header">
                                    <img src="<?php echo htmlspecialchars($userData['profile_pic']); ?>" 
                                         alt="Profile Picture" class="chirp-avatar">
                                    <div class="chirp-user">
                                        <strong><?php echo htmlspecialchars($userData['username']); ?></strong>
                                        <span>@<?php echo htmlspecialchars(strtolower(str_replace(' ', '', $userData['username']))); ?></span>
                                    </div>
                                    <span class="chirp-time">
                                        <?php echo date('M j, Y g:i a', strtotime($tweet['created_at'])); ?>
                                    </span>
                                </div>
                                <div class="chirp-content">
                                    <p><?php echo htmlspecialchars($tweet['content']); ?></p>
                                    <?php if (!empty($tweet['tweet_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($tweet['tweet_image']); ?>" class="chirp-image">
                                    <?php endif; ?>
                                </div>
                                <div class="chirp-actions">
                                    <a href="view_tweet.php?id=<?php echo $tweet['id']; ?>" class="chirp-action">💬 <?php echo $tweet['comment_count']; ?></a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="tweet_id" value="<?php echo $tweet['id']; ?>">
                                        <input type="hidden" name="action" value="<?php echo $tweet['is_liked'] ? 'unlike' : 'like'; ?>">
                                        <button type="submit" class="chirp-action like-btn <?php echo $tweet['is_liked'] ? 'liked' : ''; ?>">
                                            ❤️ <?php echo $tweet['like_count']; ?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">You haven't posted any chirps yet.</div>
                    <?php endif; ?>
                </div>
            </section>

            
            <section id="settings" style="display:none;">
                <h2>Settings</h2>
                <form id="settingsForm" enctype="multipart/form-data" action="update_profile.php" method="POST">
                    <div class="form-group">
                        <label for="darkMode">Dark Mode</label>
                        <input type="checkbox" id="darkMode" onchange="toggleDarkMode()">
                    </div>
                    <div class="form-group">
                        <label for="username">Change Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="bio">Change Bio</label>
                        <textarea id="bio" name="bio" maxlength="160"><?php echo htmlspecialchars($userData['bio']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profilePicInput">Change Profile Picture</label>
                        <input type="file" id="profilePicInput" name="profile_pic" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="bannerPicInput">Change Banner Image</label>
                        <input type="file" id="bannerPicInput" name="banner_pic" accept="image/*">
                    </div>
                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
              </section>
        </main>
    </div>
    <footer>
        &copy; 2025 Chirpify
    </footer>
    <script src="twitter.js"></script>
</body>
</html>

<?php
$conn->close();
?>
