<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirpify</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f8fa;
        }

        /* Navbar styles */
        nav {
            background-color: #1da1f2;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }

        /* Sidebar styles */
        .sidebar {
            width: 20%;
            background-color: white;
            padding: 20px;
            height: 100vh;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            display: block;
            padding: 10px 0;
            color: #1da1f2;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #e8f5fe;
            border-radius: 20px;
            padding-left: 10px;
        }

        /* Main content area */
        .content {
            width: 60%;
            padding: 20px;
        }

        /* Profile Page styles */
        .profile-header {
            background-color: #1da1f2;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .profile-header h1 {
            margin: 0;
        }

        .profile-info {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: white;
            margin-top: -50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .profile-info div {
            text-align: center;
        }

        /* Chirp form styles */
        .chirp-form {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .chirp-form textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .chirp-form button {
            background-color: #1da1f2;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }

        .chirp-form button:hover {
            background-color: #0d95e8;
        }

        /* Footer styles */
        footer {
            background-color: #1da1f2;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: white;
        }

        body.dark-mode nav {
            background-color: #333;
        }

        body.dark-mode .chirp-form, body.dark-mode .sidebar {
            background-color: #333;
        }

        /* Profile Picture */
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Like, Bookmark, Delete button styles */
        .button-group button {
            background-color: #f5f8fa;
            border: 1px solid #1da1f2;
            color: #1da1f2;
            border-radius: 20px;
            margin-right: 10px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .button-group button:hover {
            background-color: #1da1f2;
            color: white;
        }

        /* Comment section styles */
        .comment-section {
            margin-top: 10px;
            margin-left: 20px;
        }

        .comment-box {
            margin-top: 10px;
        }

        .comment-box input {
            width: 80%;
            padding: 5px;
            margin-bottom: 5px;
        }

        .comment-box button {
            background-color: #1da1f2;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        .comment-box button:hover {
            background-color: #0d95e8;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="logo">Chirpify</div>
        <div>
            <a href="#home">Home</a>
            <a href="#profile">Profile</a>
            <a href="#settings">Settings</a>
            <a href="#notifications">Notifications</a>
            <a href="#bookmarks">Bookmarks</a>
            <a href="#" id="logout">Log Out</a>
        </div>
    </nav>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="#home">Home</a>
            <a href="#profile">Profile</a>
            <a href="#settings">Settings</a>
            <a href="#notifications">Notifications</a>
            <a href="#bookmarks">Bookmarks</a>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <!-- Home Page -->
            <section id="home">
                <h2>Home</h2>
                <div class="chirp-form">
                    <textarea id="tweetText" placeholder="What's happening?"></textarea>
                    <button onclick="postTweet()">Chirp</button>
                </div>
                <div class="chirps" id="chirps">
                    <p>No chirps yet. Start the conversation!</p>
                </div>
            </section>

            <!-- Profile Page -->
            <section id="profile" style="display:none;">
                <div class="profile-header">
                    <h1>Your Profile</h1>
                </div>
                <div class="profile-info">
                    <div>
                        <img src="default.jpg" alt="Profile Picture" class="profile-picture" id="profilePic">
                        <h3>Username</h3>
                        <p id="profileUsername">@username</p>
                    </div>
                    <div>
                        <h3>Posts</h3>
                        <p id="postsCount">0 Chirps</p>
                    </div>
                    <div>
                        <h3>Followers</h3>
                        <p id="followersCount">0 Followers</p>
                    </div>
                    <div>
                        <h3>Following</h3>
                        <p id="followingCount">0 Following</p>
                    </div>
                </div>
                <div class="bio-section">
                    <h3>Bio</h3>
                    <p id="profileBio">This is your bio.</p>
                </div>
            </section>

            <!-- Settings Page -->
            <section id="settings" style="display:none;">
                <h2>Settings</h2>
                <label for="darkMode">Dark Mode</label>
                <input type="checkbox" id="darkMode" onchange="toggleDarkMode()">
                <br><br>
                <label for="language">Select Language</label>
                <select id="language" onchange="changeLanguage()">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                </select>
                <br><br>
                <label for="username">Change Username</label>
                <input type="text" id="username" placeholder="Enter new username">
                <button onclick="changeUsername()">Change Username</button>
                <br><br>
                <label for="bio">Change Bio</label>
                <textarea id="bio" placeholder="Enter new bio"></textarea>
                <button onclick="changeBio()">Change Bio</button>
                <br><br>
                <label for="profilePicInput">Change Profile Picture</label>
                <input type="file" id="profilePicInput" onchange="changeProfilePic()">
            </section>

            <!-- Notifications Page -->
            <section id="notifications" style="display:none;">
                <h2>Notifications</h2>
                <p>No new notifications.</p>
            </section>

            <!-- Bookmarks Page -->
            <section id="bookmarks" style="display:none;">
                <h2>Bookmarks</h2>
                <div id="bookmarkedTweets">
                    <p>No bookmarks saved yet.</p>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2025 Chirpify
    </footer>

    <script>
        const links = document.querySelectorAll('nav a, .sidebar a');
        const sections = document.querySelectorAll('section');
        const profileUsername = document.getElementById('profileUsername');
        const profileBio = document.getElementById('profileBio');
        const profilePic = document.getElementById('profilePic');
        const postsCount = document.getElementById('postsCount');
        const followersCount = document.getElementById('followersCount');
        const followingCount = document.getElementById('followingCount');
        const bookmarkedTweetsContainer = document.getElementById('bookmarkedTweets');
        const chirpsContainer = document.getElementById('chirps');
        let chirps = [];
        let bookmarks = [];

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));

                sections.forEach(section => section.style.display = 'none');
                target.style.display = 'block';
            });
        });

        function postTweet() {
            const tweetText = document.getElementById('tweetText').value;
            if (tweetText) {
                chirps.push({ text: tweetText, likes: 0, reposted: false, comments: [] });
                updateChirps();
                document.getElementById('tweetText').value = '';
            }
        }

        function updateChirps() {
            chirpsContainer.innerHTML = '';
            chirps.forEach((chirp, index) => {
                const chirpDiv = document.createElement('div');
                chirpDiv.innerHTML = `
                    <p>${chirp.reposted ? "<strong>Reposted:</strong> " : ""}${chirp.text}</p>
                    <p>Likes: ${chirp.likes}</p>
                    <div class="button-group">
                        <button onclick="likeChirp(${index})">Like</button>
                        <button onclick="bookmarkChirp(${index})">Bookmark</button>
                        <button onclick="deleteChirp(${index})">Delete</button>
                        <button onclick="repostChirp(${index})">Repost</button>
                    </div>
                    <div class="comment-section">
                        <div class="comment-box">
                            <input type="text" id="commentInput${index}" placeholder="Write a comment">
                            <button onclick="postComment(${index})">Post Comment</button>
                        </div>
                        <div id="comments${index}">
                            ${chirp.comments.map(comment => `<p>${comment}</p>`).join('')}
                        </div>
                    </div>
                `;
                chirpsContainer.appendChild(chirpDiv);
            });
        }

        function likeChirp(index) {
            chirps[index].likes++;
            updateChirps();
        }

        function bookmarkChirp(index) {
            bookmarks.push(chirps[index]);
            updateBookmarks();
        }

        function deleteChirp(index) {
            chirps.splice(index, 1);
            updateChirps();
        }

        function repostChirp(index) {
            const repostedChirp = { ...chirps[index], reposted: true };
            chirps.unshift(repostedChirp);
            updateChirps();
        }

        function postComment(index) {
            const commentInput = document.getElementById(`commentInput${index}`);
            const commentText = commentInput.value;
            if (commentText) {
                chirps[index].comments.push(commentText);
                updateChirps();
                commentInput.value = '';
            }
        }

        function updateBookmarks() {
            if (bookmarks.length === 0) {
                bookmarkedTweetsContainer.innerHTML = '<p>No bookmarks saved yet.</p>';
            } else {
                bookmarkedTweetsContainer.innerHTML = '';
                bookmarks.forEach(bookmark => {
                    const bookmarkDiv = document.createElement('div');
                    bookmarkDiv.innerHTML = `<p>${bookmark.text}</p>`;
                    bookmarkedTweetsContainer.appendChild(bookmarkDiv);
                });
            }
        }

        // Dark mode functionality
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        // Change language functionality (for future expansion)
        function changeLanguage() {
            const lang = document.getElementById('language').value;
            alert(`Language changed to: ${lang}`);
        }

        // Change Username functionality
        function changeUsername() {
            const newUsername = document.getElementById('username').value;
            profileUsername.textContent = `@${newUsername}`;
            alert(`Username changed to: @${newUsername}`);
        }

        // Change Bio functionality
        function changeBio() {
            const newBio = document.getElementById('bio').value;
            profileBio.textContent = newBio;
            alert(`Bio updated!`);
        }

        // Change Profile Picture functionality
        function changeProfilePic() {
            const fileInput = document.getElementById('profilePicInput');
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Log out functionality
        document.getElementById('logout').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default behavior of the link
            window.location.href = 'index.php'; // Redirect to the sign-in page
        });
    </script>
</body>
</html>
