<?php
include "database.php";


if (isset($_POST['signup'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $konpassword = $_POST['konpassword'];


    if ($username == '' || $password == '' || $konpassword == '') {
        echo "<script> 
        alert('Username, password, or confirmation password cannot be empty.');
        </script>";
    } else if ($password !== $konpassword) {
        echo "<script> 
        alert('Password and confirmation password do not match.');
        </script>";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO login (ID,username, password) VALUES (NULL,'$username', '$password')";

        if ($db->query($sql) === TRUE) {
            header('location: login.php');
            exit;
        } else {
            echo 'Error: ' . $sql . '<br>' . $db->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>

    <style>
        .Sign-up-container {
            margin: 200px auto;
            width: 300px;
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(10px);
            border-radius: 10%;
            box-shadow: 8px 10px 30px rgb(40, 39, 39);
        }
    </style>
</head>

<body>
    <div class="Sign-up-container">
        <h1>Sign Up</h1>
        <form action="signUP.php" method="post">
            <div class="login-page">
                <input type="text" placeholder="Email" id="username" name='username'>
                <div class="username-message"></div>
                <input type="password" placeholder="Password" id="password" name='password'>
                <div class="password-message"></div>
                <input type="password" placeholder="Konfirmasi Password" id="password" name='konpassword'>
                
                <button id="button-submit" name='signup'>Sign Up</button>

            </div>
        </form>
    </div>




</body>

</html>