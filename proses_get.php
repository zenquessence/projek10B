<!DOCTYPE html>
<html>
<head>
    <title>Hasil Input GET</title>
</head>
<body>

<h2>Data yang Dikirim dengan Metode GET</h2>

<?php
echo "NIM : " . $_GET['nim'] . "<br>";
echo "Nama : " . $_GET['nama'] . "<br>";
echo "Tempat Lahir : " . $_GET['tempat_lahir'] . "<br>";
echo "Tanggal Lahir : " . $_GET['tanggal_lahir'] . "<br>";
echo "Alamat : " . $_GET['alamat'] . "<br>";

/* ---- Menampilkan Kota menggunakan IF ---- */
$kota = $_GET['kota'];

if ($kota == "Semarang") {
    echo "Kota : Semarang<br>";
} elseif ($kota == "Solo") {
    echo "Kota : Solo<br>";
} elseif ($kota == "Salatiga") {
    echo "Kota : Salatiga<br>";
} elseif ($kota == "Kudus") {
    echo "Kota : Kudus<br>";
} else {
    echo "Kota : Pekalongan<br>";
}

/* ---- Menampilkan Jenis Kelamin menggunakan IF ---- */
$jk = $_GET['jk'];

if ($jk == "Laki-laki") {
    echo "Jenis Kelamin : Laki-laki<br>";
} else {
    echo "Jenis Kelamin : Perempuan<br>";
}

echo "Email : " . $_GET['email'] . "<br>";

// Menampilkan No HP
echo "No HP : " . $_GET['no_hp'] . "<br>";

// Menampilkan Umur
echo "Umur : " . $_GET['umur'] . " tahun<br>";

// Menampilkan Status
$status = $_GET['status'] ?? '';
if ($status === 'Kawin') {
    echo "Status : Kawin<br>";
} else {
    echo "Status : Belum Kawin<br>";
}

// Menampilkan Hobi
echo "Hobi : ";
if (!empty($_GET['hobi'])) {
    echo $_GET['hobi'];
} else {
    echo "Tidak ada hobi yang dipilih";
}
echo "<br>";
?>

</body>
</html>
