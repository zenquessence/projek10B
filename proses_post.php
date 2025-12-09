<?php
// Memulai session untuk mendapatkan data form
session_start();

// Memeriksa apakah data form ada dalam session
if (!isset($_SESSION['formData'])) {
    
    header('Location: F_POST.php');
    exit();
}

// Mengambil data dari session
$formData = $_SESSION['formData'];

// Menghapus data dari session setelah diambil
unset($_SESSION['formData']);

// Fungsi untuk menampilkan data dengan aman
function safeDisplay($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Input POST</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        .data-container { margin-bottom: 15px; }
        .data-label { font-weight: bold; display: inline-block; width: 150px; }
        .data-value { display: inline-block; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
    </style>
</head>
<body>

<h2>Data yang Dikirim dengan Metode POST</h2>

<div class="data-container">
    <span class="data-label">NIM:</span>
    <span class="data-value"><?php echo safeDisplay($formData['nim']); ?></span>
</div>

<div class="data-container">
    <span class="data-label">Nama:</span>
    <span class="data-value"><?php echo safeDisplay($formData['nama']); ?></span>
</div>

<div class="data-container">
    <span class="data-label">Tempat Lahir:</span>
    <span class="data-value"><?php echo safeDisplay($formData['tempat_lahir']); ?></span>
</div>

<div class="data-container">
    <span class="data-label">Tanggal Lahir:</span>
    <span class="data-value"><?php echo !empty($formData['tanggal_lahir']) ? safeDisplay($formData['tanggal_lahir']) : '-'; ?></span>
</div>

<div class="data-container">
    <span class="data-label">Alamat:</span>
    <span class="data-value"><?php echo nl2br(safeDisplay($formData['alamat'])); ?></span>
</div>

<div class="data-container">
    <span class="data-label">Kota:</span>
    <span class="data-value"><?php echo safeDisplay($formData['kota']); ?></span>
</div>

<div class="data-container">
    <span class="data-label">Jenis Kelamin:</span>
    <span class="data-value"><?php echo !empty($formData['jk']) ? safeDisplay($formData['jk']) : '-'; ?></span>
</div>

<div class="data-container">
    <span class="data-label">Email:</span>
    <span class="data-value"><?php echo !empty($formData['email']) ? safeDisplay($formData['email']) : '-'; ?></span>
</div>

<div class="data-container">
    <span class="data-label">No HP:</span>
    <span class="data-value"><?php echo !empty($formData['no_hp']) ? safeDisplay($formData['no_hp']) : '-'; ?></span>
</div>

<div class="data-container">
    <span class="data-label">Umur:</span>
    <span class="data-value"><?php echo !empty($formData['umur']) ? safeDisplay($formData['umur']) . ' tahun' : '-'; ?></span>
</div>

<div class="data-container">
    <span class="data-label">Status:</span>
    <span class="data-value"><?php echo !empty($formData['status']) ? safeDisplay($formData['status']) : '-'; ?></span>
</div>

<div class="data-container">
    <span class="data-label">Hobi:</span>
    <span class="data-value">
        <?php 
        if (!empty($formData['hobi']) && is_array($formData['hobi'])) {
            echo implode(', ', array_map('safeDisplay', $formData['hobi']));
        } else {
            echo '-';
        }
        ?>
    </span>
</div>

<p style="margin-top: 30px;">
    <a href="F_POST.php">Kembali ke Form</a>
</p>

</body>
</html>
