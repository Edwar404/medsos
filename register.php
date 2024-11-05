<?php

include 'koneksi.php';
// JIKA BUTTON DAFTAR DI KLIK ATAU DI TEKAN
if (isset($_POST['daftar'])) {
    $email   = $_POST['email'];
    $password = $_POST['password'];
    $nama_lengkap  = $_POST['nama_lengkap'];
    $nama_pengguna   = $_POST['nama_pengguna'];

    // MASUKKAN DATA KE DALAM TABLE USER KOLOM KOLOM TABLE USER () DAN NILAINYA DI AMBIL DARI INPUTAN SESUAI DENGAN URUTAN KOLOMNYA
    mysqli_query($koneksi, "INSERT INTO user (email, password, nama_lengkap, nama_pengguna) VALUES ('$email','$password','$nama_lengkap','$nama_pengguna')");

    // MELEMPAR KE HALAMAN LOGIN.PHP
    header("location:login.php?register=berhasil");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link rel="stylesheet" href="assets/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 mx-auto my-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h5>Medsos Akal-Akalan</h5>
                            </div>
                            <form action="" method="post">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Email : </label>
                                    <input type="email" name="email" placeholder="Masukkan Email Anda" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Password : </label>
                                    <input type="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Nama Lengkap : </label>
                                    <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap Anda" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Nama Pengguna : </label>
                                    <input type="text" name="nama_pengguna" placeholder="Masukkan Nama Pengguna" class="form-control">
                                </div>
                                <div class="form-group mb-3 d-grid">
                                    <button type="submit" name="daftar" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- <div class="card mt-3">
                        <div class="card-body">
                            <p>Sudah Punya Akun??</p>
                            <a href="register.php" class="text-secondary">Buat Akun</a>
                            <-- <div class="card-title">
                                <h5>Belum Punya Akun? Silahkan Daftar</h5>
                                <p>Silahkan Daftar Dengan Akun Anda</p>
                            </div>
                            <form action="actionRegister.php" method="post">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Nama : </label>
                                    <input type="text" name="nama" placeholder="Masukkan Nama Anda" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Email : </label>
                                    <input type="email" name="email" placeholder="Masukkan Email Anda" class="form-control">
                                </div>
                                <div class="form ->
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
</body>

</html>