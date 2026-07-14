<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM dealer_motor ORDER BY nama_dealer");
    $dealers = $stmt->fetchAll();
    $out = array_map(fn($d) => [
        'id'          => $d['id'],
        'nama_dealer' => $d['nama_dealer'],
        'marka'       => $d['marka'],
        'alamat'      => $d['alamat'],
        'latitude'    => floatval($d['latitude']),
        'longitude'   => floatval($d['longitude']),
        'jam_buka'    => $d['jam_buka'],
        'telepon'     => $d['telepon'],
        'deskripsi'   => $d['deskripsi'],
        'foto'        => $d['foto'],
        'presu'       => floatval($d['presu']),
    ], $dealers);
    echo json_encode($out);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
