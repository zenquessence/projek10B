<!DOCTYPE html>
<html>
<head>
    <title>Form Data (POST)</title>
    <style>
        .error { color: red; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 120px; }
    </style>
</head>
<body>

<h2>Form Input Data Mahasiswa - POST</h2>
<?php

$errors = [];
$formData = [
    'nim' => '',
    'nama' => '',
    'tempat_lahir' => '',
    'tanggal_lahir' => '',
    'alamat' => '',
    'kota' => 'Semarang',
    'jk' => '',
    'email' => '',
    'no_hp' => '',
    'umur' => '',
    'status' => '',
    'hobi' => []
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $formData['nim'] = trim($_POST['nim'] ?? '');
    $formData['nama'] = trim($_POST['nama'] ?? '');
    $formData['tempat_lahir'] = trim($_POST['tempat_lahir'] ?? '');
    $formData['tanggal_lahir'] = $_POST['tanggal_lahir'] ?? '';
    $formData['alamat'] = trim($_POST['alamat'] ?? '');
    $formData['kota'] = $_POST['kota'] ?? 'Semarang';
    $formData['jk'] = $_POST['jk'] ?? '';
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['no_hp'] = trim($_POST['no_hp'] ?? '');
    $formData['umur'] = trim($_POST['umur'] ?? '');
    $formData['status'] = $_POST['status'] ?? '';
    $formData['hobi'] = $_POST['hobi'] ?? [];

    // Validasi NIM (format: A12.2024.07263)
    if (empty($formData['nim'])) {
        $errors['nim'] = 'NIM tidak boleh kosong';
    } elseif (!preg_match('/^[A-Z]\d{2}\.\d{4}\.\d{5}$/', $formData['nim'])) {
        $errors['nim'] = 'Format NIM tidak valid. Contoh: A12.2024.07263';
    }

    // Validasi Nama
    if (empty($formData['nama'])) {
        $errors['nama'] = 'Nama tidak boleh kosong';
    }

    // Validasi Tempat Lahir
    if (empty($formData['tempat_lahir'])) {
        $errors['tempat_lahir'] = 'Tempat lahir tidak boleh kosong';
    }

    // Validasi Umur (numeric and max 3 digits)
    if (empty($formData['umur'])) {
        $errors['umur'] = 'Umur tidak boleh kosong';
    } elseif (!is_numeric($formData['umur'])) {
        $errors['umur'] = 'Umur harus berupa angka';
    } elseif ($formData['umur'] < 0 || $formData['umur'] > 999) {
        $errors['umur'] = 'Umur harus antara 0-999';
    }

    
    if (empty($errors)) {
        
        session_start();
        $_SESSION['formData'] = $formData;
        header('Location: proses_post.php');
        exit();
    }
}
?>

<?php if (!empty($errors)): ?>
    <div class="error">
        <h3>Kesalahan:</h3>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="F_POST.php" method="POST" novalidate>
    <div class="form-group">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" 
               value="<?php echo htmlspecialchars($formData['nim']); ?>"
               placeholder="A11.1111.11111"
               pattern="[A-Za-z]\d{2}\.\d{4}\.\d{5}" 
               title="Contoh: A11.1111.11111 (1 huruf, 2 angka, titik, 4 angka, titik, 5 angka)"
               style="width: 200px;">
        <script>
        function formatNIM(input) {
            // Hapus semua karakter non-angka dan non-huruf
            let value = input.value.replace(/[^A-Z0-9]/g, '');
            
            // Format NIM: A12.2024.07263
            if (value.length > 1) {
                value = value[0] + (value.substring(1, 3) || '') + '.' + 
                        (value.substring(3, 7) || '') + '.' + 
                        (value.substring(7, 12) || '');
            }
            
            // Update nilai input
            input.value = value;
        }
        </script>
        <?php if (isset($errors['nim'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['nim']); ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" 
               value="<?php echo htmlspecialchars($formData['nama']); ?>">
        <?php if (isset($errors['nama'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['nama']); ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="tempat_lahir">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" 
               value="<?php echo htmlspecialchars($formData['tempat_lahir']); ?>">
        <?php if (isset($errors['tempat_lahir'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['tempat_lahir']); ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
               value="<?php echo htmlspecialchars($formData['tanggal_lahir']); ?>">
    </div>

    <div class="form-group">
        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" rows="4" cols="30"><?php 
            echo htmlspecialchars($formData['alamat']); 
        ?></textarea>
    </div>

    <div class="form-group">
        <label for="kota">Kota:</label>
        <select id="kota" name="kota">
            <option value="Semarang" <?php echo $formData['kota'] === 'Semarang' ? 'selected' : ''; ?>>Semarang</option>
            <option value="Solo" <?php echo $formData['kota'] === 'Solo' ? 'selected' : ''; ?>>Solo</option>
            <option value="Salatiga" <?php echo $formData['kota'] === 'Salatiga' ? 'selected' : ''; ?>>Salatiga</option>
            <option value="Kudus" <?php echo $formData['kota'] === 'Kudus' ? 'selected' : ''; ?>>Kudus</option>
            <option value="Pekalongan" <?php echo $formData['kota'] === 'Pekalongan' ? 'selected' : ''; ?>>Pekalongan</option>
        </select>
    </div>

    <div class="form-group">
        <label>Jenis Kelamin:</label>
        <input type="radio" id="laki" name="jk" value="Laki-laki" 
               <?php echo $formData['jk'] === 'Laki-laki' ? 'checked' : ''; ?>>
        <label for="laki" style="width: auto;">Laki-laki</label>
        
        <input type="radio" id="perempuan" name="jk" value="Perempuan"
               <?php echo $formData['jk'] === 'Perempuan' ? 'checked' : ''; ?>>
        <label for="perempuan" style="width: auto;">Perempuan</label>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" 
               value="<?php echo htmlspecialchars($formData['email']); ?>">
    </div>

    <div class="form-group">
        <label for="no_hp">No HP:</label>
        <input type="text" id="no_hp" name="no_hp" 
               value="<?php echo htmlspecialchars($formData['no_hp']); ?>">
    </div>

    <div class="form-group">
        <label for="umur">Umur:</label>
        <input type="number" id="umur" name="umur" min="0" max="999"
               value="<?php echo htmlspecialchars($formData['umur']); ?>">
        <?php if (isset($errors['umur'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['umur']); ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Status:</label>
        <input type="radio" id="kawin" name="status" value="Kawin"
               <?php echo $formData['status'] === 'Kawin' ? 'checked' : ''; ?>>
        <label for="kawin" style="width: auto;">Kawin</label>
        
        <input type="radio" id="belum_kawin" name="status" value="Belum Kawin"
               <?php echo $formData['status'] === 'Belum Kawin' ? 'checked' : ''; ?>>
        <label for="belum_kawin" style="width: auto;">Belum Kawin</label>
    </div>

    <div class="form-group">
        <label>Hobi:</label><br>
        <input type="checkbox" id="hobi1" name="hobi[]" value="Membaca"
               <?php echo in_array('Membaca', $formData['hobi']) ? 'checked' : ''; ?>>
        <label for="hobi1" style="width: auto;">Membaca</label><br>
        
        <input type="checkbox" id="hobi2" name="hobi[]" value="Olah Raga"
               <?php echo in_array('Olah Raga', $formData['hobi']) ? 'checked' : ''; ?>>
        <label for="hobi2" style="width: auto;">Olah Raga</label><br>
        
        <input type="checkbox" id="hobi3" name="hobi[]" value="Musik"
               <?php echo in_array('Musik', $formData['hobi']) ? 'checked' : ''; ?>>
        <label for="hobi3" style="width: auto;">Musik</label><br>
        
        <input type="checkbox" id="hobi4" name="hobi[]" value="Traveling"
               <?php echo in_array('Traveling', $formData['hobi']) ? 'checked' : ''; ?>>
        <label for="hobi4" style="width: auto;">Traveling</label>
    </div>

    <div class="form-group">
        <input type="submit" value="Kirim">
    </div>
</form>

</body>
</html>
