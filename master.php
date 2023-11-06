<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM destinasi";
        $stmt = $pdo->query($sql);
        $destinasi = $stmt->fetchAll();
        echo json_encode($destinasi);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama_destinasi) && isset($data->alamat) && isset($data->deskripsi) && isset($data->kategori)) {
            $sql = "INSERT INTO destinasi (nama_destinasi, alamat, deskripsi, kategori) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama_destinasi, $data->alamat, $data->deskripsi, $data->kategori]);
            echo json_encode(['message' => 'destinasi berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_destinasi) && isset($data->nama_destinasi) && isset($data->alamat) && isset($data->deskripsi) && isset($data->kategori)) {
            $sql = "UPDATE destinasi SET nama_destinasi=?, alamat=?, deskripsi=?, kategori=? WHERE id_destinasi=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama_destinasi, $data->alamat, $data->deskripsi, $data->kategori, $data->id_destinasi]);
            echo json_encode(['message' => 'destinasi berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_destinasi)) {
            $sql = "DELETE FROM destinasi WHERE id_destinasi=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id_destinasi]);
            echo json_encode(['message' => 'destinasi berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>
