<?php
session_start();

$errorMessage = '';
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="signup.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fName">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
        <?php if ($errorMessage): ?>
          <p class="error" style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      <p class="or">
        ----------or--------
      </p>
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Already Have Account?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="login.php">  
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
          <?php if ($errorMessage): ?>
            <p class="error" style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
          <?php endif; ?>
          <p class="recover">
            <a href="#">Recover Password</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">
          ----------or--------
        </p>
        <div class="icons">
          <i class="fab fa-google"></i>
          <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
          <p>Don't have an account yet?</p>
          <button id="signUpButton">Sign Up</button>
        </div>
      </div>

      <script>
      document.addEventListener('DOMContentLoaded', function() {
    const signUpBtn = document.getElementById('signUpButton');
    const signInBtn = document.getElementById('signInButton');
    const signInForm = document.getElementById('signIn');
    const signUpForm = document.getElementById('signup');
    
    
    <?php if (isset($_SESSION['signup_error'])): ?>
        signInForm.style.display = 'none';
        signUpForm.style.display = 'block';
        <?php unset($_SESSION['signup_error']); ?>
    <?php endif; ?>
    
    if (signUpBtn) {
        signUpBtn.addEventListener('click', function(e) {
            e.preventDefault();
            signInForm.style.display = 'none';
            signUpForm.style.display = 'block';
            
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
        });
    }
    
    if (signInBtn) {
        signInBtn.addEventListener('click', function(e) {
            e.preventDefault();
            signUpForm.style.display = 'none';
            signInForm.style.display = 'block';
            
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
        });
    }
});
      </script>
</body>
</html>
