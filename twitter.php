<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirpify</title>
</head>
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
