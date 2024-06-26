<?php
// Pastikan sudah diinclude database.php
include "database.php";
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}

// Memproses penambahan kegiatan baru
if (isset($_POST['submit'])) {
    $textlist = $_POST['textList'];

    if ($textlist != "") {
        // Mencegah SQL Injection
        $textlist = $db->real_escape_string($textlist);

        // Mendapatkan user_id dari sesi
        $user_id = $_SESSION['user_id'];

        // Menyiapkan pernyataan SQL menggunakan prepared statements
        $sql = "INSERT INTO daftar_kegiatan (kegiatan, status, id_user) VALUES (?, 'simpan', ?)";
        $stmt = $db->prepare($sql);

        // Membuat parameter binding
        $stmt->bind_param("si", $textlist, $user_id);

        // Menjalankan pernyataan
        $stmt->execute();

        // Menutup pernyataan
        $stmt->close();
    } else {
        echo "<script>alert('Isi dulu dong');</script>";
    }
}

// Memproses penghapusan kegiatan
if (isset($_POST['haps'])) {
    $listDel = $_POST['listdel'];

    // Mencegah SQL Injection
    $listDel = $db->real_escape_string($listDel);

    $sql = "DELETE FROM daftar_kegiatan WHERE id_list = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $listDel);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}

// Memproses tanda kegiatan sebagai selesai
if (isset($_POST['selesai'])) {
    $listDel = $_POST['listdel'];

    // Mencegah SQL Injection
    $listDel = $db->real_escape_string($listDel);

    $sql = "UPDATE daftar_kegiatan SET status = 'Selesai' WHERE id_list = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $listDel);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>To Do List</title>
</head>

<header class="bg-dark py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center mb-md-0 mb-3">
                <img src="foto/pp.jpg" alt="Foto Anda" class="rounded-circle img-fluid" style="max-width: 200px;">
            </div>
            <div class="col-md-8 text-md-left text-center">
                <h3 class="text-light mb-0">Lodevic Terunas Nomensen</h3>
                <h3 class="text-light mb-0">225314005</h3>
            </div>
        </div>
    </div>
</header>
<style>
    #listpg {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Menengahkan secara horizontal */
        justify-content: center;
        /* Menengahkan secara vertikal */
        margin-top: 50px;
        /* Atur jarak dari bagian atas */
    }

    .listdaftar {
        width: 300px;
        /* Atur lebar daftar */
        margin-top: 20px;
        /* Atur jarak antara daftar dan form input */
        text-align: center;
        /* Menengahkan teks di dalam daftar */
    }

    a {
        margin-top: 20px;
        /* Atur jarak antara link Logout dan daftar */
    }

    .logout-link {
        display: block;
        text-align: center;
    }


    #page {
        max-width: 600px;
        margin: 0 auto;
    }


    .bungkus {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    #daftar {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #daftar del {
        color: #888;
    }

    .logout-link {
        margin-top: 20px;
        display: block;
        text-align: center;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-primary,
    .btn-danger {
        margin-left: 5px;
    }
</style>

<body>
    <section id='todo-page'>
        <div id="page">
            <div id="listpg">
                <h1 class="text-center">To Do List</h1>
                <form action="index.php" method="post">
                    <div class="input-group mb-2 mt-2">
                        <input type="text" class="form-control" placeholder="Masukan To Do List" name="textList">
                        <button type="submit" class="btn btn-primary ml-2" name="submit">Submit</button>
                    </div>
                </form>


                <div class="listdaftar">
                    <?php
                    // Memilih kegiatan dari database sesuai user yang sedang login
                    $sql = "SELECT id_list, kegiatan, status FROM daftar_kegiatan WHERE id_user = '{$_SESSION['user_id']}'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="bungkus" id="bungkus_' . $row["id_list"] . '">';
                            if ($row['status'] == 'simpan') {
                                echo '<div id="daftar">' . $row["kegiatan"] . '</div>';
                                echo '<form action="index.php" method="post">';
                                echo '<input type="hidden" name="listdel" value="' . $row['id_list'] . '">';
                                echo '<button type="submit" class="btn btn-primary ml-2" name="selesai">Selesai</button>';
                                echo '<button type="submit" class="btn btn-primary ml-2" name="haps">Hapus</button>';
                                echo '</form>';
                            } else if ($row['status'] == 'Selesai') {
                                echo '<div id="daftar"><del>' . $row["kegiatan"] . '</del></div>';
                                echo '<form action="index.php" method="post">';
                                echo '<input type="hidden" name="listdel" value="' . $row['id_list'] . '">';
                                echo '<button type="submit" class="btn btn-primary ml-2" name="haps">Hapus</button>';
                                echo '</form>';
                            }
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <a href="#" onclick="logout()">Logout</a>

                <script>
                    function logout() {
                        // Redirect ke logout.php saat tautan logout ditekan
                        window.location.href = "logout.php";
                    }
                </script>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>

</html>