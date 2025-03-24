<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirpify</title>
    <style>
   
body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f8fa;
    color: #14171a;
    transition: background-color 0.3s, color 0.3s;
}

a {
    text-decoration: none;
    color: #1da1f2;
}

a:hover {
    text-decoration: underline;
}


nav {
    background-color: #ffffff;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e1e8ed;
}

nav a {
    color: #1da1f2;
    margin-left: 20px;
}


.sidebar {
    width: 250px;
    background-color: #ffffff;
    border-right: 1px solid #e1e8ed;
    height: 100vh;
    position: fixed;
    padding-top: 20px;
}

.sidebar a {
    display: block;
    padding: 10px 20px;
    color: #14171a;
}

.sidebar a:hover {
    background-color: #e8f5fe;
    color: #1da1f2;
}


.content {
    margin-left: 270px;
    padding: 20px;
}


.chirp-form {
    background-color: #ffffff;
    padding: 15px;
    border: 1px solid #e1e8ed;
    border-radius: 8px;
    margin-bottom: 20px;
}

.chirp-form textarea {
    width: 100%;
    height: 80px;
    border: 1px solid #ccd6dd;
    border-radius: 4px;
    padding: 10px;
    resize: none;
    font-size: 14px;
}


.chirp {
    background-color: #ffffff;
    padding: 15px;
    border: 1px solid #e1e8ed;
    border-radius: 8px;
    margin-bottom: 15px;
}

.chirp img {
    max-width: 100%;
    border-radius: 8px;
    margin-top: 10px;
}


.button-group {
    display: flex;
    justify-content: flex-end;
    margin-top: 10px;
}

.button-group button {
    margin-left: 10px;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #1da1f2;
    color: #fff;
}

.button-group button:hover {
    background-color: #0d8ddb;
}


.profile-header {
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.profile-header button {
    margin-top: 10px;
    padding: 8px 16px;
    border-radius: 9999px;
    background-color: #1da1f2;
    color: white;
    border: none;
    cursor: pointer;
}

.profile-header button:hover {
    background-color: #0d8ddb;
}

.profile-info {
    display: flex;
    justify-content: space-around;
    padding: 20px;
    border-top: 1px solid #e1e8ed;
    border-bottom: 1px solid #e1e8ed;
}

.profile-info div {
    text-align: center;
}

.bio-section {
    padding: 20px;
}

.profile-chirps {
    padding: 20px;
}


.comment-box {
    display: flex;
    margin-top: 10px;
}

.comment-box input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ccd6dd;
    border-radius: 4px;
}


body.dark-mode {
    background-color: #15202b;
    color: #e1e8ed;
}

body.dark-mode nav,
body.dark-mode .sidebar,
body.dark-mode .content,
body.dark-mode .chirp-form,
body.dark-mode .chirp,
body.dark-mode .profile-header,
body.dark-mode .bio-section,
body.dark-mode .profile-info {
    background-color: #192734;
    color: #e1e8ed;
    border-color: #2f3336;
}

body.dark-mode .chirp-form textarea,
body.dark-mode .comment-box input {
    background-color: #22303c;
    color: #e1e8ed;
    border-color: #2f3336;
}

body.dark-mode .button-group button,
body.dark-mode nav a,
body.dark-mode .sidebar a {
    color: #8899a6;
}

body.dark-mode .sidebar a:hover,
body.dark-mode nav a:hover {
    background-color: #22303c;
    color: #1da1f2;
}

</style>

</head>
<body>

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
        
        <aside class="sidebar">
            <a href="#home">Home</a>
            <a href="#profile">Profile</a>
            <a href="#settings">Settings</a>
            <a href="#notifications">Notifications</a>
            <a href="#bookmarks">Bookmarks</a>
        </aside>

        
        <main class="content">
            
            <section id="home">
                <h2>Home</h2>
                <div class="chirp-form">
                    <textarea id="tweetText" placeholder="What's happening?"></textarea>
                    <input type="file" id="tweetImage" accept="image/*">
                    <button onclick="postTweet()">Chirp</button>
                </div>
                <div class="chirps" id="chirps">
                    <p>No chirps yet. Start the conversation!</p>
                </div>
            </section>

            
            <section id="profile" style="display:none;">
                <div class="profile-header">
                    <img src="default.jpg" alt="Profile Picture" class="profile-picture" id="profilePic">
                    <h1 id="profileName">Username</h1>
                    <p id="profileUsername">@username</p>
                    <button onclick="editProfile()">Edit Profile</button>
                </div>
                <div class="profile-info">
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
                <div class="profile-chirps">
                    <h2>Your Chirps</h2>
                    <div id="userChirps">
                        <p>No chirps yet.</p>
                    </div>
                </div>
            </section>

            
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

            
            <section id="notifications" style="display:none;">
                <h2>Notifications</h2>
                <p>No new notifications.</p>
            </section>

            
            <section id="bookmarks" style="display:none;">
                <h2>Bookmarks</h2>
                <div id="bookmarkedTweets">
                    <p>No bookmarks saved yet.</p>
                </div>
            </section>
        </main>
    </div>

    
    <footer>
        &copy; 2025 Chirpify
    </footer>

    <script>
        function toggleDarkMode() {
        document.body.classList.toggle("dark-mode");
    }
        const links = document.querySelectorAll('nav a, .sidebar a');
        const sections = document.querySelectorAll('section');
        const chirpsContainer = document.getElementById('chirps');
        const userChirpsContainer = document.getElementById('userChirps');
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
            const tweetImage = document.getElementById('tweetImage').files[0];
            const tweetData = { text: tweetText, likes: 0, reposted: false, comments: [], image: tweetImage };

            if (tweetText || tweetImage) {
                chirps.push(tweetData);
                updateChirps();
                updateUserChirps();
                document.getElementById('tweetText').value = '';
                document.getElementById('tweetImage').value = '';
            }
        }

        function updateChirps() {
            chirpsContainer.innerHTML = '';
            chirps.forEach((chirp, index) => {
                const chirpDiv = document.createElement('div');
                chirpDiv.classList.add('chirp');
                let chirpContent = `
                    <p>${chirp.reposted ? "<strong>Reposted:</strong> " : ""}${chirp.text}</p>
                    <p>Likes: <span class="heart" onclick="likeChirp(${index})">&#9829;</span> ${chirp.likes}</p>
                    <div class="button-group">
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
                            ${chirp.comments.map(comment => `
                                <p><strong>@username</strong>: ${comment} <button onclick="deleteComment(${index}, ${chirp.comments.indexOf(comment)})">Delete</button></p>
                            `).join('')}
                        </div>
                    </div>`;

                if (chirp.image) {
                    chirpContent += `<img src="${URL.createObjectURL(chirp.image)}" alt="Tweet image">`;
                }

                chirpDiv.innerHTML = chirpContent;
                chirpsContainer.appendChild(chirpDiv);
            });
        }

        function updateUserChirps() {
            userChirpsContainer.innerHTML = '';
            chirps.forEach((chirp, index) => {
                const chirpDiv = document.createElement('div');
                chirpDiv.classList.add('chirp');
                let chirpContent = `
                    <p>${chirp.reposted ? "<strong>Reposted:</strong> " : ""}${chirp.text}</p>
                    <p>Likes: <span class="heart" onclick="likeChirp(${index})">&#9829;</span> ${chirp.likes}</p>
                    <div class="button-group">
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
                            ${chirp.comments.map(comment => `
                                <p><strong>@username</strong>: ${comment} <button onclick="deleteComment(${index}, ${chirp.comments.indexOf(comment)})">Delete</button></p>
                            `).join('')}
                        </div>
                    </div>`;

                if (chirp.image) {
                    chirpContent += `<img src="${URL.createObjectURL(chirp.image)}" alt="Tweet image">`;
                }

                chirpDiv.innerHTML = chirpContent;
                userChirpsContainer.appendChild(chirpDiv);
            });
        }

        function likeChirp(index) {
            chirps[index].likes = chirps[index].likes ? 0 : 1;  
            updateChirps();
            updateUserChirps();
        }

        function bookmarkChirp(index) {
            bookmarks.push(chirps[index]);
            updateBookmarks();
        }

        function deleteChirp(index) {
            chirps.splice(index, 1);
            updateChirps();
            updateUserChirps();
        }

        function repostChirp(index) {
            const repostedChirp = { ...chirps[index], reposted: true };
            chirps.unshift(repostedChirp);
            updateChirps();
            updateUserChirps();
        }

        function postComment(index) {
            const commentInput = document.getElementById(`commentInput${index}`);
            const commentText = commentInput.value;
            if (commentText) {
                chirps[index].comments.push(commentText);
                updateChirps();
                updateUserChirps();
                commentInput.value = '';
            }
        }

        function deleteComment(index, commentIndex) {
            chirps[index].comments.splice(commentIndex, 1);
            updateChirps();
            updateUserChirps();
        }

        function updateBookmarks() {
            const bookmarksContainer = document.getElementById('bookmarkedTweets');
            if (bookmarks.length) {
                bookmarksContainer.innerHTML = bookmarks.map(bookmark => `
                    <div class="chirp">
                        <p>${bookmark.text}</p>
                    </div>
                `).join('');
            } else {
                bookmarksContainer.innerHTML = '<p>No bookmarks saved yet.</p>';
            }
        }

       
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        
        function changeLanguage() {
            const language = document.getElementById('language').value;
            alert(`Language changed to: ${language}`);
        }

        
        function changeUsername() {
            const newUsername = document.getElementById('username').value;
            document.getElementById('profileUsername').innerText = `@${newUsername}`;
        }

        
        function changeBio() {
            const newBio = document.getElementById('bio').value;
            document.getElementById('profileBio').innerText = newBio;
        }

        
        function changeProfilePic() {
            const file = document.getElementById('profilePicInput').files[0];
            document.getElementById('profilePic').src = URL.createObjectURL(file);
        }

    
        function editProfile() {
            const newName = prompt('Enter your new name:');
            const newBio = prompt('Enter your new bio:');
            if (newName) document.getElementById('profileName').innerText = newName;
            if (newBio) document.getElementById('profileBio').innerText = newBio;
        }

        
        document.getElementById('logout').addEventListener('click', function(e) {
            e.preventDefault();
            alert('You have been logged out.');
            window.location.href = 'index.php'; 
        });
    </script>

</body>
</html> 
