<?php
// Include database connection and start session
include "database.php";
session_start();

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Query database menggunakan prepared statement
        $sql = "SELECT ID, username, password FROM login WHERE username = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika hasil query mengembalikan satu baris
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Verifikasi password
            if (password_verify($password, $row['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $row['ID']; // Simpan ID pengguna ke dalam sesi

                // Redirect ke halaman index setelah login berhasil
                header('location: index.php');
                exit;
            } else {
                $error_message = 'Password salah';
            }
        } else {
            $error_message = 'Username tidak ditemukan';
        }
    } else {
        $error_message = 'Username dan password harus diisi';
    }
}

// Proses logout
if (isset($_GET['logout'])) {
    session_unset();     // Menghapus semua variabel session
    session_destroy();   // Menghapus sesi
    header('location: login.php');
    exit;
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
        body {
            background-image: url('foto/wplogin.jpg'); /* Ganti 'background.jpg' dengan nama file gambar Anda */
            background-size: cover;
            background-position: center;
            margin: 0; /* Menghapus margin default dari body */
            padding: 0; /* Menghapus padding default dari body */
        }

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
                <?php if (isset($error_message)) : ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <input type="text" placeholder="Username" id="username" name='username'>
                <div class="username-message"></div>
                <input type="password" placeholder="Password" id="password" name='password'>
                <div class="password-message"></div>
                <button id="button-submit" name='login' ">Login</button>
                <a id="link-forgot" href="signUP.php">
                    <h5>Sign Up</h5>
                </a>
            </div>
        </form>
    </div>
</body>

</html>
