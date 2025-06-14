<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

define('INDEX_AUTH', '1');
require '../../../sysconfig.inc.php';

if (!defined('SENAYAN_BASE_DIR')) {
    define('SENAYAN_BASE_DIR', realpath(__DIR__ . '/../../../') . DIRECTORY_SEPARATOR);
}

require SENAYAN_BASE_DIR . 'admin/default/session.inc.php';

header('Content-Type: application/json');

// if (!isset($_SESSION['mid'])) {
//     echo json_encode(['success' => false, 'message' => 'Akses hanya untuk member yang login.']);
//     exit;
// }

$biblio_id = (int) ($_POST['biblio_id'] ?? 0);
$rating = (int) ($_POST['rating'] ?? 0);
$member_id = (int) $_SESSION['mid'];

if ($biblio_id <= 0 || $rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid.']);
    exit;
}

if (!isset($dbs)) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal.']);
    exit;
}

// Cek apakah rating sudah ada
$check = $dbs->query("SELECT id FROM biblio_rating WHERE biblio_id=$biblio_id AND member_id=$member_id");

if ($check && $check->num_rows > 0) {
    // Update rating, created_at tetap (tidak diubah)
    $dbs->query("UPDATE biblio_rating SET rating=$rating WHERE biblio_id=$biblio_id AND member_id=$member_id");
} else {
    // Insert rating baru
    // Cari id max dulu karena tidak auto_increment
    $result = $dbs->query("SELECT MAX(id) AS max_id FROM biblio_rating");
    $row = $result->fetch_assoc();
    $new_id = ($row['max_id'] ?? 0) + 1;

    $dbs->query("INSERT INTO biblio_rating (id, biblio_id, member_id, rating) VALUES ($new_id, $biblio_id, $member_id, $rating)");
}

echo json_encode(['success' => true, 'message' => 'Rating berhasil disimpan.']);
exit;
