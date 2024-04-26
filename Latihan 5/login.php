<?php
// Include database connection and start session
include "database.php";
session_start();

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query database untuk mencari username
    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = $db->query($sql);

    // Jika hasil query mengembalikan satu baris
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['ID'];

            // Redirect ke halaman index setelah login berhasil
            header('location: index.php');
            exit;
        } else {
            echo 'Password salah';
        }
    } else {
        echo 'Username tidak ditemukan';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>

    <style>
        #link-forgot:hover {
            color: rgb(185, 146, 209);
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="login-page">
                <input type="text" placeholder="Email" id="username" name='username'>
                <div class="username-message"></div>
                <input type="password" placeholder="Password" id="password" name='password'>
                <div class="password-message"></div>
                <button id="button-submit" name='login' style="margin-top: -10px;">Login</button>
                <a id="link-forgot" href="signUP.php">
                    <h5>Sign Up</h5>
                </a>
            </div>
        </form>
    </div>
</body>

</html>
