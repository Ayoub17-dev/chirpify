<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Check if email exists using prepared statement
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $checkEmail->bindParam(':email', $email);
    $checkEmail->execute();
    
    if($checkEmail->rowCount() > 0){
        echo "Email Address Already Exists !";
    }
    else{
        // Insert new user using prepared statement
        $insertQuery = $conn->prepare("INSERT INTO users(firstName, lastName, email, password)
                       VALUES (:firstName, :lastName, :email, :password)");
        $insertQuery->bindParam(':firstName', $firstName);
        $insertQuery->bindParam(':lastName', $lastName);
        $insertQuery->bindParam(':email', $email);
        $insertQuery->bindParam(':password', $password);
        
        if($insertQuery->execute()){
            header("location: index.php");
            exit();
        }
        else{
            echo "Error: " . implode(" ", $insertQuery->errorInfo());
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    // Check credentials using prepared statement
    $sql = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $sql->bindParam(':email', $email);
    $sql->bindParam(':password', $password);
    $sql->execute();
    
    if($sql->rowCount() > 0){
        session_start();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $_SESSION['email'] = $row['email'];
        header("Location: homepage.php");
        exit();
    }
    else{
        echo "Not Found, Incorrect Email or Password";
    }
}
?>
