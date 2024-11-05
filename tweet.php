<?php

if (isset($_POST['posting'])) {
    $content = $_POST['content'];


    // JIKA GAMBAR MAU DI UBAH
    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = $_FILES['foto']['name'];
        $ukuran_foto = $_FILES['foto']['size'];

        // png, jpg, jpeg
        $ext = array('png', 'jpg', 'jpeg');
        $extFoto = pathinfo($nama_foto, PATHINFO_EXTENSION);

        // JIKA EXTENSI FOTO TIDAK ADA EXT YANG TERDAFTAR DI ARRAY EXT
        if (!in_array($extFoto, $ext)) {
            echo "Extension tidak ditemukan";
            die;
        } else {
            // pindahkan gambar dari tmp folder ke folder yang sudah kita buat
            // unlink() : mendelete file
            unlink('upload/' . $rowTweet['foto']);
            move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/' . $nama_foto);

            $insert = mysqli_query($koneksi, "INSERT INTO tweet (content, foto, id_user) VALUES ('$content','$nama_foto','$id_user')");
        }
    } else {
        // GAMBAR TIDAK MAU DI UBAH
        $insert = mysqli_query($koneksi, "INSERT INTO tweet (content, id_user) VALUES ('$content','$id_user')");
    }
    header('location:?pg=profil&tweet=berhasil');
}

$queryPosting = mysqli_query($koneksi, "SELECT * FROM tweet WHERE id_user='$id_user'");


?>

<div class="row">
    <div class="col-sm-12" align="right">
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal1">Tweet</button>
    </div>
    <div class="col-sm-12 mt-3">
        <?php while ($rowPosting = mysqli_fetch_array($queryPosting)) { ?>
            <div class="d-flex ">
                <div class="flex-shrink-0 d-flex gap-3">
                    <img src="upload/<?php echo !empty($rowUser['foto']) ? $rowUser['foto'] : 'https://placehold.co/800x200' ?>" alt="..." class="rounded-circle border border-2" height="50" width="50">
                </div>
                <div class="flex-grow-1 ms-3" style="max-width:500px;">
                    <div class="d-flex gap-3">
                        <p><?php echo $rowUser['nama_lengkap'] ?></p>
                        <p><i></i>(<?php echo $rowUser['nama_pengguna'] ?>)</i></p>
                    </div>
                    <div class="d-flex">
                        <?php if (!empty($rowPosting['foto'])): ?>
                            <img class="rounded" src="upload/<?php echo $rowPosting['foto'] ?>" height="250" width="250" alt="">
                        <?php endif ?>
                        <div class="">
                            <?php echo $rowPosting['content']; ?>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <form action="add_comment.php" id="comment-form" method="post">
                        <input type="text" name="status_id" value="<?php echo $rowPosting['id'] ?>">
                        <input type="text" name="user_id" value="<?php echo $rowPosting['id_user'] ?>">

                        <textarea name="comment_text" class="form-control" id="comment_text" cols="5" rows="5" placeholder="Tulis Balasan Anda ... "></textarea>
                        <button class="btn btn-primary btn-sm mt-2" type="submit">Kirim Balasan</button>
                    </form>

                    <div class="alert mt-2" id="comment-alert" style="display: none;"></div>
                    <div class="mt-1">
                        <?php
                        if (isset($rowPosting['comment_text'])) {
                            $idStatus = $rowPosting['status_id'];
                            $userId = $rowPosting['user_id'];
                            $queryComment = mysqli_query($koneksi, "SELECT * FROM comments WHERE ststus_id = $idStatus AND user_id = $userId");
                            $rowCounts = mysqli_fetch_all($queryComment, MYSQLI_ASSOC);

                            foreach ($rowCounts as $rowCount) {
                        ?>
                                <span>
                                    <pre>Komentar : <?php echo $rowCount['comment_text'] ?></pre>
                                </span>
                                <!-- <div class="d-flex gap-3">
                                    <p><?php echo $rowComment['comment_text'] ?></p>
                                    <p><i></i>(<?php echo $rowComment['nama_lengkap'] ?>)</p>
                                    <p><i></i>(<?php echo $rowComment['nama_pengguna'] ?>)</p>
                                    <p><small><?php echo $rowComment['tanggal'] ?></small></p>
                                </div> -->
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php } ?>
    </div>
</div>

<!-- MODAL TWEET -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tweet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea name="content" id="summernote" class="form-control">Apa Yang Sedang Anda Pikirkan?</textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="posting" class="btn btn-primary">Tweet</button>
                </div>
            </form>
        </div>
    </div>
</div>