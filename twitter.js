function changeBannerPic() {
    const file = document.getElementById('bannerPicInput').files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileBanner').style.backgroundImage = `url(${e.target.result})`;
            saveUserData();
        };
        reader.readAsDataURL(file);
    }
}
    
    let currentAccount = 'main';
    let accounts = {
        'main': {
            chirps: [],
            bookmarks: [],
            profile: {
                name: "Main User",
                username: "mainuser",
                bio: "This is my main account",
                profilePic: "default.jpg"
            }
        },
        'account2': {
            chirps: [],
            bookmarks: [],
            profile: {
                name: "Second User",
                username: "seconduser",
                bio: "This is my second account",
                profilePic: "default.jpg"
            }
        }
    };

   
    const links = document.querySelectorAll('.sidebar a');
    const sections = document.querySelectorAll('section');
    const chirpsContainer = document.getElementById('chirps');
    const userChirpsContainer = document.getElementById('userChirps');

    
    document.addEventListener('DOMContentLoaded', function() {
        loadUserData();
        
        
        setInterval(saveUserData, 5000);
        
       
        document.getElementById('chirpText').addEventListener('input', function() {
            const chirpBtn = document.getElementById('postChirpBtn');
            chirpBtn.disabled = this.value.trim() === '' && !document.getElementById('chirpImage').files[0];
        });
        
        document.getElementById('chirpImage').addEventListener('change', function() {
            const chirpBtn = document.getElementById('postChirpBtn');
            chirpBtn.disabled = document.getElementById('chirpText').value.trim() === '' && !this.files[0];
        });
    });

    
    function saveUserData() {
        const userData = {
            accounts: accounts,
            currentAccount: currentAccount,
            darkMode: document.body.classList.contains('dark-mode')
        };
        localStorage.setItem('chirpifyUserData', JSON.stringify(userData));
    }

    
    function loadUserData() {
        const savedData = localStorage.getItem('chirpifyUserData');
        if (savedData) {
            const userData = JSON.parse(savedData);
            
            
            accounts = userData.accounts || accounts;
            
            
            currentAccount = userData.currentAccount || 'main';
            
            
            if (userData.darkMode) {
                document.body.classList.add('dark-mode');
                document.getElementById('darkMode').checked = true;
            }
            
            
            loadAccountData(currentAccount);
        } else {
            
            loadAccountData('main');
        }
    }

    
    function loadAccountData(accountName) {
        const account = accounts[accountName];
        document.getElementById('profileName').innerText = account.profile.name;
        document.getElementById('profileUsername').innerText = `@${account.profile.username}`;
        document.getElementById('profileBio').innerText = account.profile.bio;
        document.getElementById('profilePic').src = account.profile.profilePic;
        document.getElementById('chirpProfilePic').src = account.profile.profilePic;
        document.getElementById('postsCount').innerText = `${account.chirps.length} Chirps`;
        updateChirps();
        updateUserChirps();
        updateBookmarks();
    }

    
    function switchAccount(accountName) {
        currentAccount = accountName;
        loadAccountData(accountName);
    }

    
    function addAccount() {
        const accountName = prompt("Enter new account name:");
        if (accountName) {
            accounts[accountName] = {
                chirps: [],
                bookmarks: [],
                profile: {
                    name: accountName,
                    username: accountName.toLowerCase(),
                    bio: "This is my new account",
                    profilePic: "default.jpg"
                }
            };
            saveUserData();
            
           
            const newAccountBtn = document.createElement('button');
            newAccountBtn.className = 'account-button';
            newAccountBtn.textContent = accountName;
            newAccountBtn.onclick = function() { switchAccount(accountName); };
            
            
            const addAccountBtn = document.querySelector('.add-account-button');
            addAccountBtn.parentNode.insertBefore(newAccountBtn, addAccountBtn);
            
            alert(`Account ${accountName} created!`);
        }
    }

    
    function postChirp() {
        const chirpText = document.getElementById('chirpText').value;
        const chirpImage = document.getElementById('chirpImage').files[0];
        
        const chirpData = { 
            text: chirpText, 
            likes: 0, 
            liked: false,
            reposted: false, 
            comments: [], 
            timestamp: new Date().toISOString(),
            image: chirpImage ? URL.createObjectURL(chirpImage) : null,
            user: {
                name: accounts[currentAccount].profile.name,
                username: accounts[currentAccount].profile.username,
                avatar: accounts[currentAccount].profile.profilePic
            }
        };

        if (chirpText || chirpImage) {
            accounts[currentAccount].chirps.unshift(chirpData);
            updateChirps();
            updateUserChirps();
            document.getElementById('chirpText').value = '';
            document.getElementById('chirpImage').value = '';
            document.getElementById('postChirpBtn').disabled = true;
            document.getElementById('postsCount').innerText = `${accounts[currentAccount].chirps.length} Chirps`;
            saveUserData();
            window.scrollTo(0, 0);
        }
    }

    
    function updateChirps() {
        chirpsContainer.innerHTML = '';
        
        if (accounts[currentAccount].chirps.length === 0) {
            chirpsContainer.innerHTML = '<div class="empty-state">No chirps yet. Start the conversation!</div>';
            return;
        }
        
        accounts[currentAccount].chirps.forEach((chirp, index) => {
            const chirpDiv = document.createElement('div');
            chirpDiv.classList.add('chirp');
            
            let chirpContent = `
                <div class="chirp-header">
                    <img src="${chirp.user.avatar}" alt="Profile Picture" class="chirp-avatar">
                    <div class="chirp-user">
                        <span class="chirp-name">${chirp.user.name}</span>
                        <span class="chirp-username">${chirp.user.username}</span>
                        <span class="chirp-time">· ${formatTime(chirp.timestamp)}</span>
                    </div>
                </div>
                <div class="chirp-content">${chirp.text}</div>`;

            if (chirp.image) {
                chirpContent += `<img src="${chirp.image}" alt="Chirp image" class="chirp-image">`;
            }

            chirpContent += `
                <div class="chirp-actions">
                    <div class="chirp-action comment" onclick="focusComment(${index})">
                        <span class="chirp-action-icon">💬</span>
                        <span>${chirp.comments.length}</span>
                    </div>
                    <div class="chirp-action repost" onclick="repostChirp(${index})">
                        <span class="chirp-action-icon">🔁</span>
                        <span>${chirp.reposted ? '1' : '0'}</span>
                    </div>
                    <div class="chirp-action like" onclick="likeChirp(${index})">
                        <span class="chirp-action-icon ${chirp.liked ? 'liked' : ''}">${chirp.liked ? '❤️' : '🤍'}</span>
                        <span>${chirp.likes}</span>
                    </div>
                    <div class="chirp-action bookmark" onclick="bookmarkChirp(${index})">
                        <span class="chirp-action-icon">🔖</span>
                    </div>
                    ${chirp.user.username === accounts[currentAccount].profile.username ? 
                        `<div class="chirp-action delete" onclick="deleteChirp(${index})">
                            <span class="chirp-action-icon">🗑️</span>
                        </div>` : ''}
                </div>
                <div class="comment-section" id="commentSection${index}" style="display: none;">
                    <div class="comment-box">
                        <img src="${accounts[currentAccount].profile.profilePic}" class="comment-avatar">
                        <input type="text" id="commentInput${index}" placeholder="Write a comment">
                        <button onclick="postComment(${index})">Post</button>
                    </div>
                    <div id="comments${index}">
                        ${chirp.comments.map((comment, commentIndex) => `
                            <div class="comment">
                                <img src="${accounts[currentAccount].profile.profilePic}" class="comment-avatar">
                                <div class="comment-content">
                                    <span class="comment-user">@${accounts[currentAccount].profile.username}</span>
                                    <p class="comment-text">${comment}</p>
                                </div>
                                <button class="delete-comment-btn" onclick="deleteComment(${index}, ${commentIndex})">×</button>
                            </div>
                        `).join('')}
                    </div>
                </div>`;

            chirpDiv.innerHTML = chirpContent;
            chirpsContainer.appendChild(chirpDiv);
        });
    }

    
    function updateUserChirps() {
        userChirpsContainer.innerHTML = '';
        
        if (accounts[currentAccount].chirps.length === 0) {
            userChirpsContainer.innerHTML = '<div class="empty-state">No chirps yet.</div>';
            return;
        }
        
        accounts[currentAccount].chirps.forEach((chirp, index) => {
            const chirpDiv = document.createElement('div');
            chirpDiv.classList.add('chirp');
            
            let chirpContent = `
                <div class="chirp-header">
                    <img src="${chirp.user.avatar}" alt="Profile Picture" class="chirp-avatar">
                    <div class="chirp-user">
                        <span class="chirp-name">${chirp.user.name}</span>
                        <span class="chirp-username">${chirp.user.username}</span>
                        <span class="chirp-time">· ${formatTime(chirp.timestamp)}</span>
                    </div>
                </div>
                <div class="chirp-content">${chirp.text}</div>`;

            if (chirp.image) {
                chirpContent += `<img src="${chirp.image}" alt="Chirp image" class="chirp-image">`;
            }

            chirpContent += `
                <div class="chirp-actions">
                    <div class="chirp-action comment" onclick="focusComment(${index})">
                        <span class="chirp-action-icon">💬</span>
                        <span>${chirp.comments.length}</span>
                    </div>
                    <div class="chirp-action repost" onclick="repostChirp(${index})">
                        <span class="chirp-action-icon">🔁</span>
                        <span>${chirp.reposted ? '1' : '0'}</span>
                    </div>
                    <div class="chirp-action like" onclick="likeChirp(${index})">
                        <span class="chirp-action-icon ${chirp.liked ? 'liked' : ''}">${chirp.liked ? '❤️' : '🤍'}</span>
                        <span>${chirp.likes}</span>
                    </div>
                    <div class="chirp-action delete" onclick="deleteChirp(${index})">
                        <span class="chirp-action-icon">🗑️</span>
                    </div>
                </div>
                <div class="comment-section" id="userCommentSection${index}" style="display: none;">
                    <div class="comment-box">
                        <img src="${accounts[currentAccount].profile.profilePic}" class="comment-avatar">
                        <input type="text" id="userCommentInput${index}" placeholder="Write a comment">
                        <button onclick="postUserComment(${index})">Post</button>
                    </div>
                    <div id="userComments${index}">
                        ${chirp.comments.map((comment, commentIndex) => `
                            <div class="comment">
                                <img src="${accounts[currentAccount].profile.profilePic}" class="comment-avatar">
                                <div class="comment-content">
                                    <span class="comment-user">@${accounts[currentAccount].profile.username}</span>
                                    <p class="comment-text">${comment}</p>
                                </div>
                                <button class="delete-comment-btn" onclick="deleteComment(${index}, ${commentIndex})">×</button>
                            </div>
                        `).join('')}
                    </div>
                </div>`;

            chirpDiv.innerHTML = chirpContent;
            userChirpsContainer.appendChild(chirpDiv);
        });
    }

    
    function formatTime(timestamp) {
        const now = new Date();
        const chirpTime = new Date(timestamp);
        const diffInSeconds = Math.floor((now - chirpTime) / 1000);
        
        if (diffInSeconds < 60) return `${diffInSeconds}s`;
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h`;
        return chirpTime.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }

    function toggleDarkMode() {
        document.body.classList.toggle("dark-mode");
        saveUserData();
    }

    function focusComment(index) {
        const commentSection = document.getElementById(`commentSection${index}`);
        commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';
        if (commentSection.style.display === 'block') {
            document.getElementById(`commentInput${index}`).focus();
        }
    }

    function likeChirp(index) {
        const chirp = accounts[currentAccount].chirps[index];
        if (chirp.liked) {
            chirp.likes--;
            chirp.liked = false;
        } else {
            chirp.likes++;
            chirp.liked = true;
            
            const likeIcon = document.querySelectorAll('.like')[index].querySelector('.chirp-action-icon');
            likeIcon.classList.add('like-animation');
            setTimeout(() => {
                likeIcon.classList.remove('like-animation');
            }, 500);
        }
        updateChirps();
        updateUserChirps();
        saveUserData();
    }

    function bookmarkChirp(index) {
        const chirp = accounts[currentAccount].chirps[index];
        if (!accounts[currentAccount].bookmarks.some(bm => bm.timestamp === chirp.timestamp)) {
            accounts[currentAccount].bookmarks.push(chirp);
            updateBookmarks();
            saveUserData();
            alert('Chirp bookmarked!');
        } else {
            alert('This chirp is already bookmarked!');
        }
    }

    function deleteChirp(index) {
        if (confirm('Are you sure you want to delete this chirp?')) {
            
            const chirpToDelete = accounts[currentAccount].chirps[index];
            accounts[currentAccount].bookmarks = accounts[currentAccount].bookmarks.filter(
                bm => bm.timestamp !== chirpToDelete.timestamp
            );
            
           
            accounts[currentAccount].chirps.splice(index, 1);
            
            updateChirps();
            updateUserChirps();
            updateBookmarks();
            document.getElementById('postsCount').innerText = `${accounts[currentAccount].chirps.length} Chirps`;
            saveUserData();
        }
    }

    function repostChirp(index) {
        const chirp = accounts[currentAccount].chirps[index];
        if (!chirp.reposted) {
            const repostedChirp = { ...chirp, reposted: true, timestamp: new Date().toISOString() };
            accounts[currentAccount].chirps.unshift(repostedChirp);
            chirp.reposted = true;
            updateChirps();
            updateUserChirps();
            saveUserData();
            alert('Chirp reposted!');
        } else {
            alert('You already reposted this chirp!');
        }
    }

    function postComment(index) {
        const commentInput = document.getElementById(`commentInput${index}`);
        const commentText = commentInput.value;
        if (commentText) {
            accounts[currentAccount].chirps[index].comments.push(commentText);
            updateChirps();
            updateUserChirps();
            commentInput.value = '';
            saveUserData();
        }
    }

    function postUserComment(index) {
        const commentInput = document.getElementById(`userCommentInput${index}`);
        const commentText = commentInput.value;
        if (commentText) {
            accounts[currentAccount].chirps[index].comments.push(commentText);
            updateChirps();
            updateUserChirps();
            commentInput.value = '';
            saveUserData();
        }
    }

    function deleteComment(chirpIndex, commentIndex) {
        if (confirm('Delete this comment?')) {
            accounts[currentAccount].chirps[chirpIndex].comments.splice(commentIndex, 1);
            updateChirps();
            updateUserChirps();
            saveUserData();
        }
    }

    function updateBookmarks() {
        const bookmarksContainer = document.getElementById('bookmarkedChirps');
        if (accounts[currentAccount].bookmarks.length) {
            bookmarksContainer.innerHTML = accounts[currentAccount].bookmarks.map((bookmark, index) => `
                <div class="chirp">
                    <div class="chirp-header">
                        <img src="${bookmark.user.avatar}" alt="Profile Picture" class="chirp-avatar">
                        <div class="chirp-user">
                            <span class="chirp-name">${bookmark.user.name}</span>
                            <span class="chirp-username">${bookmark.user.username}</span>
                            <span class="chirp-time">· ${formatTime(bookmark.timestamp)}</span>
                        </div>
                    </div>
                    <div class="chirp-content">${bookmark.text}</div>
                    ${bookmark.image ? `<img src="${bookmark.image}" alt="Chirp image" class="chirp-image">` : ''}
                    <button class="remove-bookmark-btn" onclick="removeBookmark(${index})">Remove Bookmark</button>
                </div>
            `).join('');
        } else {
            bookmarksContainer.innerHTML = '<div class="empty-state">No bookmarks saved yet.</div>';
        }
    }

    function removeBookmark(index) {
        if (confirm('Remove this bookmark?')) {
            accounts[currentAccount].bookmarks.splice(index, 1);
            updateBookmarks();
            saveUserData();
        }
    }

   
    function changeLanguage() {
        const language = document.getElementById('language').value;
        alert(`Language changed to: ${language}`);
        saveUserData();
    }

    function changeUsername() {
        const newUsername = document.getElementById('username').value;
        if (newUsername) {
            accounts[currentAccount].profile.username = newUsername;
            document.getElementById('profileUsername').innerText = `@${newUsername}`;
            saveUserData();
        }
    }

    function changeBio() {
        const newBio = document.getElementById('bio').value;
        if (newBio) {
            accounts[currentAccount].profile.bio = newBio;
            document.getElementById('profileBio').innerText = newBio;
            saveUserData();
        }
    }

    function changeProfilePic() {
        const file = document.getElementById('profilePicInput').files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                accounts[currentAccount].profile.profilePic = e.target.result;
                document.getElementById('profilePic').src = e.target.result;
                document.getElementById('chirpProfilePic').src = e.target.result;
                saveUserData();
            };
            reader.readAsDataURL(file);
        }
    }

    function editProfile() {
        const currentName = accounts[currentAccount].profile.name;
        const currentBio = accounts[currentAccount].profile.bio;
        
        const newName = prompt('Enter your new name:', currentName);
        const newBio = prompt('Enter your new bio:', currentBio);
        
        if (newName !== null) {
            accounts[currentAccount].profile.name = newName;
            document.getElementById('profileName').innerText = newName;
        }
        if (newBio !== null) {
            accounts[currentAccount].profile.bio = newBio;
            document.getElementById('profileBio').innerText = newBio;
        }
        
        saveUserData();
    }

    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));

            sections.forEach(section => section.style.display = 'none');
            target.style.display = 'block';
        });
    });

   
    document.getElementById('logoutBtn').addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to log out?')) {
            window.location.href = 'index.php'; 
        }
    });
    document.querySelectorAll('aside a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                
               
                document.querySelectorAll('main section').forEach(section => {
                    section.style.display = 'none';
                });
                
                
                document.getElementById(targetId).style.display = 'block';
                
                
                document.querySelectorAll('aside a').forEach(a => {
                    a.classList.remove('active');
                });
                this.classList.add('active');
            }
        });
    });
    
   
    document.getElementById('settingsForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to update profile'));
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });

    function editProfile() {
        document.querySelector('aside a[href="#settings"]').click();
    }

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
    
