<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Konfigurasi Database Hosting Anda
$host = "localhost";
$user = "username_db_anda";
$pass = "password_db_anda";
$db   = "nama_db_anda";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $nama      = $conn->real_escape_string($data['nama']);
    $absen     = $conn->real_escape_string($data['absen']);
    $nilai     = intval($data['nilai']);
    $device_id = $conn->real_escape_string($data['device_id']);
    $waktu     = $conn->real_escape_string($data['waktu']);

    $sql = "INSERT INTO nilai_cbt_bahasa (nama, absen, nilai, device_id, waktu) VALUES ('$nama', '$absen', $nilai, '$device_id', '$waktu')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Nilai berhasil disimpan otomatis"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data kosong"]);
}

$conn->close();
?>