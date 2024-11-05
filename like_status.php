<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $status_id = $_POST['status_id'];
    $user_id = $_POST['user_id'];

    // CEK STATUS
    $selectCheck = mysqli_query($koneksi, "SELECT * FROM likes WHERE status_id = '$status_id' AND user_id = '$user_id'");

    if (mysqli_num_rows($selectCheck) > 0) {
        #JIKA SUDA LIKE, MELAKUKAN UNLIKE
        $qUnlike = mysqli_query($koneksi, "DELETE FROM likes WHERE status_id = '$status_id' AND user_id = '$user_id'");
        if ($qUnlike) {
            # SUKSES
            $response = [
                'status' => 'unliked'
            ];
        } else {
            // GAGAL UNLIKE
            $response = [
                'status' => 'error',
                'message' => 'GAGAL MENG-UNLIKE.'
            ];
        }
    } else {
        #JIKA BELUM LIKE, LAKUKAN LIKE
        $queryLike = mysqli_query($koneksi, "INSERT INTO likes (user_id, status_id) VALUES ('$user_id', '$status_id')");

        if ($queryLike) {
            # SUKSES
            $response = [
                'status' => 'like'
            ];
        } else {
            // GAGAL UNLIKE
            $response = [
                'status' => 'error',
                'message' => 'GAGAL LIKE.'
            ];
        }
    }
    // KIRIM RESPONSE
    header('Content-Type: application/json');
    echo json_encode($response);
}
