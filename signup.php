<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["signUp"])) {
    $firstName = trim($_POST["fName"]);
    $lastName = trim($_POST["lName"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $_SESSION['error'] = "Email already registered. Try logging in.";
            $_SESSION['signup_error'] = true; 
            header("Location: index.php");
            exit();
        }
        
        $fullName = $firstName . " " . $lastName;
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullName, $email, $password);

        if ($stmt->execute()) {
            $newUserId = $stmt->insert_id;
            session_regenerate_id(true);
            $_SESSION['user_id'] = $newUserId;
            header("Location: homepage.php");
            exit();
        } else {
            $_SESSION['error'] = "Error creating account. Please try again.";
            $_SESSION['signup_error'] = true;
            header("Location: index.php");
            exit();
        }
    } catch (Exception $e) {
        error_log("Signup error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred during registration";
        $_SESSION['signup_error'] = true;
        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>
