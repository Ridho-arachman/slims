<?php
// Aktifkan error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Header JSON
header('Content-Type: application/json');

// Konfigurasi koneksi database (ubah sesuai milikmu)
$host = 'localhost';
$dbname = 'uas_slims'; // ganti sesuai nama database SLiMS kamu
$username = 'root';
$password = ''; // sesuaikan password MySQL kamu

try {
    $dbs = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Koneksi gagal: ' . $e->getMessage()]);
    exit;
}

// Ambil parameter bulan & tahun dari URL atau default
$bulan = isset($_GET['bulan']) ? (int) $_GET['bulan'] : (int) date('m');
$tahun = isset($_GET['tahun']) ? (int) $_GET['tahun'] : (int) date('Y');

// Fungsi bantu hitung jumlah
function getCount($dbs, $sql, $params = [])
{
    try {
        $stmt = $dbs->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

// Hitung statistik
$jmlPinjam = getCount(
    $dbs,
    "SELECT COUNT(*) FROM loan WHERE MONTH(loan_date) = ? AND YEAR(loan_date) = ?",
    [$bulan, $tahun]
);

$jmlKembali = getCount(
    $dbs,
    "SELECT COUNT(*) FROM loan WHERE is_return = 1 AND MONTH(return_date) = ? AND YEAR(return_date) = ?",
    [$bulan, $tahun]
);

$jmlTerlambat = getCount(
    $dbs,
    "SELECT COUNT(*) FROM loan WHERE is_late = 1 AND MONTH(loan_date) = ? AND YEAR(loan_date) = ?",
    [$bulan, $tahun]
);

// Kembalikan hasil sebagai JSON
echo json_encode([
    'pinjam' => $jmlPinjam,
    'kembali' => $jmlKembali,
    'terlambat' => $jmlTerlambat
]);
