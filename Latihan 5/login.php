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
            background-image: url('foto/wplogin.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            /* Menghapus margin default dari body */
            padding: 0;
            /* Menghapus padding default dari body */
        }

        #link-forgot:hover {
            color: rgb(185, 146, 209);
            text-decoration: none;
        }


        .login-container {
            margin: 200px auto;
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .login-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-container .error-message {
            color: #ff0000;
            margin-bottom: 10px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #d2b48c;
            color: white;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #c39b77;
        }

        #link-forgot {
            text-decoration: none;
            color: #666;

            margin-top: 10px;
        }

        #link-forgot:hover {
            color: #222;
        }
    </style>

</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="login-page">
                <?php if (isset($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <input type="text" placeholder="Username" id="username" name='username'>
                <div class="username-message"></div>
                <input type="password" placeholder="Password" id="password" name='password'>
                <div class="password-message"></div>
                <button id="button-submit" name='login' ">Login</button>
                <a id=" link-forgot" href="signUP.php">
                    <h5>Sign Up</h5>
                    </a>
            </div>
        </form>
    </div>
</body>

</html>