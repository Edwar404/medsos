<?php

ob_start();
ob_clean();
session_start();
include 'koneksi.php';

// empty() : kosong
if (empty($_SESSION['NAMA'])) {
    header("location:login.php?access=failed");
}

// include 'function/helper.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="shortcut icon" href="assets/logo.jpeg" type="image/x-icon">

    <!-- BOOTSTRAP & CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">

    <!-- CHELSEA FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chelsea+Market&display=swap" rel="stylesheet">

    <!--FEATHER ICON -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- SUMMERNOTE -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .cover {
            height: 200px;
        }

        .cover img {
            background-size: cover;
            background-position: center;
        }
    </style>

</head>

<body>
    <?php
    include_once 'inc/navbar.php';
    ?>

    <div class="content">
        <?php
        if (isset($_GET['pg'])) {
            if (file_exists('content/' . $_GET['pg'] . '.php')) {
                include 'content/' . $_GET['pg'] . '.php';
            }
        } else {
            include 'content/dashboard.php';
        }
        ?>
    </div>


    <?php
    include_once 'inc/footer.php';
    ?>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/moment.js"></script>
    <script>
        feather.replace();
    </script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
    <script src="app.js"></script>
    <!-- SUMMERNOTE -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
    <script>
        $("#id_peminjaman").change(function() {
            let no_peminjaman = $(this).find('option:selected').val();
            let tbody = $('tbody'),
                newRow = "";
            $.ajax({
                url: "ajax/getPeminjam.php?no_peminjaman=" + no_peminjaman,
                type: "get",
                dataType: "json",
                success: function(res) {
                    $('#no_pinjam').val(res.data.no_peminjaman);
                    $('#tgl_peminjaman').val(res.data.tgl_peminjaman);
                    $('#tgl_pengembalian').val(res.data.tgl_pengembalian);
                    $('#nama_anggota').val(res.data.nama_anggota);

                    let tanggal_kembali = new moment(res.data.tgl_pengembalian);
                    let current_date = new Date().toJSON().slice(0, 10);
                    let tanggal_di_kembalikan = new moment(current_date);
                    let selisih = tanggal_di_kembalikan.diff(tanggal_kembali, "days");
                    if (selisih < 0) {
                        selisih = 0;
                    }
                    let biaya_denda = 100000;
                    let totalDenda = selisih * biaya_denda;
                    $('#denda').val(totalDenda);

                    $.each(res.detail_peminjaman, function(key, val) {
                        newRow += "<tr>";
                        newRow += "<td>" + val.nama_buku + "</td>";
                        newRow += "</tr>";
                    });
                    tbody.html(newRow);

                }
            });
        });
    </script>
</body>

</html>