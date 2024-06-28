<?php


$conn = mysqli_connect('localhost', 'root', '','webspp');
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}


?>