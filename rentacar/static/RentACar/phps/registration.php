<?php
require_once('connectdb.php');

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if either username or email is already taken
    $sql = "SELECT * FROM tbluser WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // Check which field is taken (username or email) and display an appropriate message
        if ($existingUser['username'] === $username) {
            echo '<script>alert("Username is already taken. Please choose a different one.");</script>';
        } else {
            echo '<script>alert("Email is already used. Please use a different email.");</script>';
        }
    } else {
        // Both username and email are unique, insert the user into the database
        $insertSql = "INSERT INTO tbluser (fname, lname, email, username, password) VALUES (:fname, :lname, :email, :username, :password)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->bindParam(':fname', $fname, PDO::PARAM_STR);
        $insertStmt->bindParam(':lname', $lname, PDO::PARAM_STR);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertStmt->bindParam(':password', $password, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            echo '<script>alert("Registration successful.");</script>';
        } else {
            echo '<script>alert("Registration failed. Please try again later.");</script>';
        }
    }
}
?>
