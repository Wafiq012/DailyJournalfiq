<?php
session_start();
include "koneksi.php"; // Pastikan file ini menghubungkan ke database Anda

// Fungsi untuk mengambil data pengguna berdasarkan username
function getUserData($username)
{
    global $conn;

    $query = "SELECT * FROM username WHERE username = ?"; // Menyesuaikan dengan nama tabel 'user'
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);  // Mengikat parameter username
    $stmt->execute();
    $result = $stmt->get_result();

    // Mengembalikan data pengguna jika ditemukan
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Mengembalikan data pengguna dalam bentuk array asosiatif
    } else {
        return null; // Tidak ada pengguna yang ditemukan
    }
}

// Cek jika pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// Ambil data pengguna berdasarkan username yang ada di session
$user_data = getUserData($_SESSION['username']);

if ($user_data === null) {
    echo "Data pengguna tidak ditemukan untuk username yang diberikan.";
    exit;
}

// Menangani form untuk memperbarui profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'] ?? '';  // Ambil password baru jika ada
    $new_foto = $_FILES['foto'] ?? null;  // Ambil file foto jika ada

    // Memperbarui password jika ada
    if (!empty($new_password)) {
        $hashed_password = md5($new_password); // Meng-hash password menggunakan MD5
        $query = "UPDATE username SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $hashed_password, $_SESSION['username']);
        $stmt->execute();
    }

    // Memperbarui foto profil jika ada
    if ($new_foto && $new_foto['error'] == 0) {
        // Proses upload file foto
        $target_dir = "img/";
        $target_file = $target_dir . basename($new_foto['name']);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memeriksa apakah file yang di-upload adalah gambar
        if (getimagesize($new_foto['tmp_name'])) {
            if (move_uploaded_file($new_foto['tmp_name'], $target_file)) {
                // Memperbarui foto profil di database
                $query = "UPDATE username SET foto = ? WHERE username = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $new_foto['name'], $_SESSION['username']);
                $stmt->execute();
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file Anda.";
            }
        } else {
            echo "File yang di-upload bukan gambar.";
        }
    }

    // Redirect setelah pemrosesan selesai
    header("Location: profileadmin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile Admin | My Daily Journal</title>
    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- nav begin -->
    <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top bg-danger-subtle">
        <div class="container">
            <a class="navbar-brand" href="">My Daily Journal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=article">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="index.php">Homepage</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['username'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profileadmin.php"><?= $_SESSION['username'] ?></a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- nav end -->

    <!-- profile admin begin -->
    <div class="container mt-5">
        <h2 class="text-center">Profil</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="password" class="form-label">Ganti Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Ganti Foto Profil</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <small class="form-text text-muted">Foto Profil Saat Ini:</small>
                <div class="d-flex justify-content-start">
                    <div class="img-thumbnail" style="width: 100px;">
                        <img src="<?= !empty($user_data['foto']) ? 'img/' . htmlspecialchars($user_data['foto']) : 'img/default-profile.png' ?>"
                            alt="Current Profile Photo" class="img-fluid">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <!-- profile admin end -->

    <!-- footer begin -->
    <footer id="footer" class="text-center p-5 bg-danger-subtle mt-auto">
        <div>
            <div>
        <a href="https://www.instagram.com/udinusofficial">
            <i class="bi bi-instagram h2 p-2 text-dark"></i>
        </a>
        <a href="https://twitter.com/udinusofficial">
            <i class="bi bi-twitter h2 p-2 text-dark"></i>
        </a>
        <a href="https://wa.me/+62812685577">
            <i class="bi bi-whatsapp h2 p-2 text-dark"></i>
        </a>
    </div>
    <div>Wafiq Febrian Prayitno &copy; 2022</div>
    </footer>
    <!-- footer end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
