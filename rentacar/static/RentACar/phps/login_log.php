<?php
require_once('connectdb.php');

session_start(); // Start a new or resume an existing session

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Query to fetch user by username
        $sql = "SELECT * FROM tbluser WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Username found, now verify the password
            if (password_verify($password, $user['password'])) {
                // Password matches, set session variable and redirect to index.php
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit(); // Make sure to exit after the redirection
            } else {
                // Password does not match
                echo '<script>alert("Incorrect password. Please try again.");</script>';
            }
        } else {
            // Username not found
            echo '<script>alert("Username not found. Please check your username.");</script>';
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo 'Database error: ' . $e->getMessage();
    }
}
?>
