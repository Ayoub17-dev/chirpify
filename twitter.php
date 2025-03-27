<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirpify</title>
</head>
<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #ffffff;
    color: #0f1419;
    letter-spacing: 0.2px;
}
 
a {
    text-decoration: none;
    color: #1d9bf0;
    transition: color 0.2s ease-in-out;
}
 
a:hover {
    text-decoration: underline;
    color: #1a8cd8;
}
 
.sidebar {
    width: 250px;
    background-color: #ffffff;
    border-right: 1px solid #e1e8ed;
    height: 100vh;
    position: fixed;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
}
 
.sidebar a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #0f1419;
    font-size: 20px;
    font-weight: 400;
    transition: background-color 0.2s;
    border-radius: 9999px;
    margin: 0 10px;
    width: fit-content;
}
 
.sidebar a:hover {
    background-color: #e8f5fe;
    color: #1d9bf0;
}
 
.content {
    margin-left: 270px;
    padding: 20px;
    background-color: #ffffff;
    min-height: 100vh;
    max-width: 600px;
    margin-right: auto;
    border-right: 1px solid #e1e8ed;
    border-left: 1px solid #e1e8ed;
}
 
.chirp-form {
    background-color: #ffffff;
    padding: 15px;
    border-bottom: 1px solid #e1e8ed;
    margin-bottom: 20px;
}

.chirp-form-container {
    display: flex;
    gap: 12px;
    padding-bottom: 12px;
}

.chirp-form-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.chirp-form-content {
    flex: 1;
}

.chirp-form textarea {
    width: 100%;
    border: none;
    resize: none;
    font-size: 20px;
    padding: 12px 0;
    min-height: 60px;
    outline: none;
    font-family: inherit;
}

.chirp-form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12px;
}

.chirp-form-buttons {
    display: flex;
    gap: 8px;
}

.chirp-button {
    background-color: #1d9bf0;
    color: white;
    border: none;
    border-radius: 9999px;
    padding: 8px 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chirp-button:hover {
    background-color: #1a8cd8;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.chirp-button:disabled {
    background-color: #8ecdf7;
    cursor: default;
    transform: none;
    box-shadow: none;
}

.chirp {
    background-color: #ffffff;
    padding: 12px 16px;
    border-bottom: 1px solid #e1e8ed;
    transition: background-color 0.2s;
    position: relative;
    overflow: hidden;
}

.chirp:hover {
    background-color: #f7f7f7;
}

.chirp-header {
    display: flex;
    align-items: center;
    margin-bottom: 4px;
}

.chirp-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
}

.chirp-user {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.chirp-name {
    font-weight: bold;
    margin-right: 4px;
}

.chirp-username {
    color: #536471;
    margin-right: 4px;
}

.chirp-time {
    color: #536471;
}

.chirp-time:hover {
    text-decoration: underline;
}

.chirp-content {
    margin-left: 60px;
    margin-bottom: 12px;
    font-size: 15px;
    line-height: 20px;
}

.chirp-image {
    width: 100%;
    border-radius: 16px;
    margin-top: 12px;
    border: 1px solid #e1e8ed;
}

.chirp-actions {
    display: flex;
    justify-content: space-between;
    margin-left: 60px;
    margin-top: 12px;
    max-width: 425px;
}

.chirp-action {
    display: flex;
    align-items: center;
    color: #536471;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 8px;
    border-radius: 9999px;
}

.chirp-action:hover {
    background-color: rgba(29, 155, 240, 0.1);
    transform: scale(1.1);
}

.chirp-action.comment:hover {
    color: #1d9bf0;
}

.chirp-action.repost:hover {
    color: #00ba7c;
}

.chirp-action.like:hover {
    color: #f91880;
}

.chirp-action.bookmark:hover {
    color: #1d9bf0;
}

.chirp-action-icon {
    margin-right: 4px;
    width: 18px;
    height: 18px;
}

.like-animation {
    animation: like 0.5s ease-in-out;
}

@keyframes like {
    0% { transform: scale(1); }
    25% { transform: scale(1.2); }
    50% { transform: scale(0.95); }
    100% { transform: scale(1); }
}


.profile-header {
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    background-color: #ffffff;
    border-bottom: 1px solid #e1e8ed;
    margin-bottom: 20px;
}
 
.profile-header button {
    margin-top: 10px;
    padding: 8px 16px;
    border-radius: 9999px;
    background-color: #1d9bf0;
    color: #fff;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}
 
.profile-header button:hover {
    background-color: #1a8cd8;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
 
.profile-info {
    display: flex;
    justify-content: space-around;
    padding: 20px;
    border-bottom: 1px solid #e1e8ed;
    background-color: #ffffff;
    margin-bottom: 20px;
}
 
.profile-info div {
    text-align: center;
}
 
.profile-info div span:first-child {
    font-size: 18px;
    font-weight: 600;
    color: #0f1419;
}
 
.profile-info div span:last-child {
    font-size: 14px;
    color: #536471;
}
 
.bio-section {
    padding: 20px;
    background-color: #ffffff;
    border-bottom: 1px solid #e1e8ed;
    margin-bottom: 20px;
}
 
.bio-section h2 {
    font-size: 18px;
    font-weight: 600;
    color: #0f1419;
    margin-bottom: 10px;
}
 
.profile-chirps {
    padding: 20px;
    background-color: #ffffff;
}
 
.profile-chirps h2 {
    font-size: 20px;
    font-weight: 600;
    color: #0f1419;
    margin-bottom: 15px;
}

.button-group button {
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    background-color: #1d9bf0;
    color: #fff;
    font-weight: bold;
    font-size: 14px;
    transition: all 0.3s ease;
    margin: 5px 0;
}

.button-group button:hover {
    background-color: #1a8cd8;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}


.settings-button {
    background: linear-gradient(135deg, #1d9bf0, #1a8cd8);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 10px 0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.settings-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}


.remove-bookmark-btn {
    background: linear-gradient(135deg, #ff4d4d, #e60000);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
    font-weight: bold;
}

.remove-bookmark-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}


.comment {
    display: flex;
    align-items: flex-start;
    margin: 10px 0;
    padding: 10px;
    border-radius: 10px;
    background-color: #f7f7f7;
}

.comment-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 10px;
}

.comment-content {
    flex: 1;
}

.comment-user {
    font-weight: bold;
    margin-right: 5px;
}

.comment-text {
    margin: 5px 0;
}

.delete-comment-btn {
    background: none;
    border: none;
    color: #ff4d4d;
    cursor: pointer;
    font-size: 16px;
    margin-left: 10px;
    transition: all 0.2s;
}

.delete-comment-btn:hover {
    transform: scale(1.2);
}


.account-button {
    padding: 12px 24px;
    border-radius: 25px;
    margin: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #1d9bf0, #1a8cd8);
    color: white;
    border: none;
    display: block;
    width: 100%;
    text-align: left;
}

.add-account-button {
    padding: 12px 24px;
    border-radius: 25px;
    margin: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: transparent;
    color: #1d9bf0;
    border: 2px solid #1d9bf0;
    display: block;
    width: 100%;
    text-align: center;
}

.account-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.add-account-button:hover {
    background-color: #e8f5fe;
    transform: translateY(-2px);
}
 
body.dark-mode {
    background-color: #000000;
    color: #e7e9ea;
}
 
body.dark-mode .sidebar,
body.dark-mode .content,
body.dark-mode .chirp-form,
body.dark-mode .chirp,
body.dark-mode .profile-header,
body.dark-mode .profile-info,
body.dark-mode .bio-section,
body.dark-mode .profile-chirps {
    background-color: #000000;
    color: #e7e9ea;
    border-color: #2f3336;
}
 
body.dark-mode .chirp-form textarea,
body.dark-mode .sidebar a {
    background-color: transparent;
    color: #e7e9ea;
}
 
body.dark-mode .sidebar a:hover {
    background-color: #16181c;
    color: #1d9bf0;
}
 
body.dark-mode .profile-header button {
    background-color: #1d9bf0;
}
 
body.dark-mode .profile-header button:hover {
    background-color: #1a8cd8;
}
 
body.dark-mode .profile-info div span:first-child {
    color: #e7e9ea;
}
 
body.dark-mode .profile-info div span:last-child {
    color: #71767b;
}
 
body.dark-mode .bio-section h2,
body.dark-mode .profile-chirps h2 {
    color: #e7e9ea;
}
 
body.dark-mode .button-group button {
    background-color: #1d9bf0;
    color: #fff;
}
 
body.dark-mode .button-group button:hover {
    background-color: #1a8cd8;
}

body.dark-mode .chirp:hover {
    background-color: #16181c;
}

body.dark-mode .chirp-username,
body.dark-mode .chirp-time {
    color: #71767b;
}

body.dark-mode .comment {
    background-color: #16181c;
}


.logo {
    font-size: 28px;
    font-weight: bold;
    padding: 20px;
    text-align: left;
    margin-bottom: 20px;
    color: #1d9bf0;
}


#logoutBtn {
    margin-top: auto;
    margin-bottom: 20px;
    background-color: transparent;
    color: #0f1419;
    padding: 12px 20px;
    border-radius: 9999px;
    font-weight: 400;
    transition: background-color 0.2s;
    text-align: left;
    font-size: 20px;
    width: fit-content;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
}

#logoutBtn:hover {
    background-color: #e8f5fe;
    color: #1d9bf0;
}

body.dark-mode #logoutBtn {
    color: #e7e9ea;
}

body.dark-mode #logoutBtn:hover {
    background-color: #16181c;
    color: #1d9bf0;
}


.chirp-form-icons {
    display: flex;
    gap: 12px;
}

.chirp-form-icon {
    width: 20px;
    height: 20px;
    color: #1d9bf0;
    cursor: pointer;
    padding: 8px;
    border-radius: 9999px;
    transition: background-color 0.2s;
}

.chirp-form-icon:hover {
    background-color: rgba(29, 155, 240, 0.1);
}


.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #536471;
    font-size: 15px;
}

body.dark-mode .empty-state {
    color: #71767b;
}


@media (max-width: 1000px) {
    .sidebar {
        width: 80px;
    }
    .sidebar a span {
        display: none;
    }
    .content {
        margin-left: 90px;
    }
    .logo {
        text-align: center;
        padding: 20px 10px;
    }
    #logoutBtn span {
        display: none;
    }
}

@media (max-width: 500px) {
    .sidebar {
        width: 60px;
    }
    .content {
        margin-left: 70px;
        padding: 10px;
    }
    .chirp-content {
        margin-left: 0;
        margin-top: 12px;
    }
    .chirp-actions {
        margin-left: 0;
    }
    .chirp-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .chirp-avatar {
        margin-right: 0;
        margin-bottom: 8px;
    }
}
.chirp-action.delete {
    color: #ff4d4d;
}

.chirp-action.delete:hover {
    background-color: rgba(255, 77, 77, 0.1);
    transform: scale(1.1);
}
.profile-header {
    position: relative;
    padding-top: 150px; 
}

.profile-banner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 230px;
    background-size: cover;
    background-position: center;
    background-color: #1d9bf0; 
}

.profile-picture {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    position: relative;
    z-index: 1;
    margin-bottom: 15px;
}
</style>
<body>

    <div class="container">
        
        <aside class="sidebar">
            <div class="logo">Chirpify</div>
            <a href="#home"><span>🏠</span> <span>Home</span></a>
            <a href="#profile"><span>👤</span> <span>Profile</span></a>
            <a href="#settings"><span>⚙️</span> <span>Settings</span></a>
            <a href="#notifications"><span>🔔</span> <span>Notifications</span></a>
            <a href="#bookmarks"><span>📌</span> <span>Bookmarks</span></a>
            <button id="logoutBtn"><span>🔓</span> <span>Log Out</span></button>
        </aside>

        
        <main class="content">
            
            <section id="home">
                <h2>Home</h2>
                <div class="chirp-form">
                    <div class="chirp-form-container">
                        <img src="default.jpg" alt="Profile Picture" class="chirp-form-avatar" id="chirpProfilePic">
                        <div class="chirp-form-content">
                            <textarea id="chirpText" placeholder="What's happening?"></textarea>
                            <div class="chirp-form-actions">
                                <div class="chirp-form-icons">
                                    <div class="chirp-form-icon" title="Add image">
                                        <input type="file" id="chirpImage" accept="image/*" style="display: none;">
                                        <label for="chirpImage">📷</label>
                                    </div>
                                </div>
                                <button class="chirp-button" id="postChirpBtn" onclick="postChirp()" disabled>Chirp</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chirps" id="chirps">
                    <div class="empty-state">No chirps yet. Start the conversation!</div>
                </div>
            </section>

            
            <section id="profile" style="display:none;">
            <div class="profile-header">
            <div class="profile-banner" id="profileBanner"></div>
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
                        <div class="empty-state">No chirps yet.</div>
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
    <button class="settings-button" onclick="changeUsername()">Change Username</button>
    <br><br>
    <label for="bio">Change Bio</label>
    <textarea id="bio" placeholder="Enter new bio"></textarea>
    <button class="settings-button" onclick="changeBio()">Change Bio</button>
    <br><br>
    <label for="profilePicInput">Change Profile Picture</label>
    <input type="file" id="profilePicInput" onchange="changeProfilePic()">
    <button class="settings-button" onclick="document.getElementById('profilePicInput').click()">Select New Photo</button>
    <br><br>
    
    
    <label for="bannerPicInput">Change Banner Image</label>
    <input type="file" id="bannerPicInput" onchange="changeBannerPic()">
    <button class="settings-button" onclick="document.getElementById('bannerPicInput').click()">Select New Banner</button>
    <br><br>
</section>

            
            <section id="notifications" style="display:none;">
                <h2>Notifications</h2>
                <div class="empty-state">No new notifications.</div>
            </section>

            
            <section id="bookmarks" style="display:none;">
                <h2>Bookmarks</h2>
                <div id="bookmarkedChirps">
                    <div class="empty-state">No bookmarks saved yet.</div>
                </div>
            </section>

            
            <section id="accounts" style="display:none;">
                <h2>Accounts</h2>
                <div id="accountsList">
                    <button class="account-button" onclick="switchAccount('main')">Main Account</button>
                    <button class="account-button" onclick="switchAccount('account2')">Second Account</button>
                    <button class="add-account-button" onclick="addAccount()">+ Add Account</button>
                </div>
                <div id="accountChirps"></div>
            </section>
        </main>
    </div>
    <footer>
        &copy; 2025 Chirpify
    </footer>
    <script src="twitter.js"></script>
</body>
</html>
