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
                    <textarea placeholder="What's happening?"></textarea>
                    <button>Chirp</button>
                </div>
                <div class="chirps">
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
                        <h3>Username</h3>
                        <p>@username</p>
                    </div>
                    <div>
                        <h3>Posts</h3>
                        <p>0 Chirps</p>
                    </div>
                    <div>
                        <h3>Followers</h3>
                        <p>0 Followers</p>
                    </div>
                    <div>
                        <h3>Following</h3>
                        <p>0 Following</p>
                    </div>
                </div>
            </section>

            <!-- Settings Page -->
            <section id="settings" style="display:none;">
                <h2>Settings</h2>
                <p>Adjust your preferences here.</p>
            </section>

            <!-- Notifications Page -->
            <section id="notifications" style="display:none;">
                <h2>Notifications</h2>
                <p>No new notifications.</p>
            </section>

            <!-- Bookmarks Page -->
            <section id="bookmarks" style="display:none;">
                <h2>Bookmarks</h2>
                <p>No bookmarks saved yet.</p>
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

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));

                sections.forEach(section => section.style.display = 'none');
                target.style.display = 'block';
            });
        });
    </script>
</body>
</html>
