<?php
// Start session at the very beginning
session_start();

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
    } elseif (preg_match('/\d/', $formData['nama'])) {
        $errors['nama'] = 'Nama tidak boleh mengandung angka';
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
        $_SESSION['formData'] = $formData;
        header('Location: proses_post.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa (POST)</title>
    <style>
        :root {
            --primary-color: #3498db;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --border-color: #ddd;
            --text-color: #333;
            --bg-color: #f9f9f9;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        
        label {
            width: 150px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        input[type="tel"],
        select,
        textarea {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        
        .radio-group, .checkbox-group {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .radio-option, .checkbox-option {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        
        .radio-option input, .checkbox-option input {
            width: auto;
            margin-right: 5px;
        }
        
        .radio-option label, .checkbox-option label {
            width: auto;
            font-weight: normal;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.85em;
            margin-top: 5px;
            width: 100%;
            padding-left: 165px;
        }
        
        .error {
            background-color: #fde8e8;
            border-left: 4px solid var(--error-color);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0 4px 4px 0;
        }
        
        .error h3 {
            margin-top: 0;
            color: var(--error-color);
        }
        
        .error ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        
        button[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        button[type="submit"]:hover {
            background-color: #2980b9;
        }
        
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }
            
            label {
                width: 100%;
                margin-bottom: 5px;
            }
            
            input[type="text"],
            input[type="email"],
            input[type="date"],
            input[type="number"],
            input[type="tel"],
            select,
            textarea {
                width: 100%;
            }
            
            .error-message {
                padding-left: 0;
            }
            
            .button-container {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<h2>Form Input Data Mahasiswa - POST</h2>

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

<form id="mahasiswaForm" action="F_POST.php" method="POST" novalidate onsubmit="return validateForm()">
    <div class="form-group">
        <label for="nim">NIM <span class="required">*</span>:</label>
        <input type="text" id="nim" name="nim" 
               value="<?php echo htmlspecialchars($formData['nim']); ?>"
               pattern="[A-Z]\d{2}\.\d{4}\.\d{5}"
               title="Format NIM: A12.2024.07263"
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
        <label for="nama">Nama <span class="required">*</span>:</label>
        <input type="text" id="nama" name="nama" 
               value="<?php echo htmlspecialchars($formData['nama']); ?>"
               oninput="validateName(this)">
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
        <label for="umur">Umur <span class="required">*</span>:</label>
        <input type="number" id="umur" name="umur" 
               min="1" max="999"
               value="<?php echo htmlspecialchars($formData['umur']); ?>"
               oninput="validateAge(this)">
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

<script>
    // Validasi form sebelum submit
    function validateForm() {
        let isValid = true;
        const form = document.getElementById('mahasiswaForm');
        
        // Validasi Nama
        const nama = document.getElementById('nama');
        if (!validateName(nama)) {
            isValid = false;
        }
        
        // Validasi Umur
        const umur = document.getElementById('umur');
        if (!validateAge(umur)) {
            isValid = false;
        }
        
        return isValid;
    }
    
    // Validasi Nama (hanya huruf dan spasi)
    function validateName(input) {
        const value = input.value.trim();
        const errorElement = document.getElementById('namaError') || createErrorElement(input, 'namaError');
        
        if (value === '') {
            showError(input, errorElement, 'Nama tidak boleh kosong');
            return false;
        } else if (/\d/.test(value)) {
            showError(input, errorElement, 'Nama tidak boleh mengandung angka');
            return false;
        } else if (!/^[a-zA-Z\s]*$/.test(value)) {
            showError(input, errorElement, 'Nama hanya boleh berisi huruf dan spasi');
            return false;
        } else {
            removeError(input, errorElement);
            return true;
        }
    }
    
    // Validasi Umur (hanya angka)
    function validateAge(input) {
        const value = input.value.trim();
        const errorElement = document.getElementById('umurError') || createErrorElement(input, 'umurError');
        
        if (value === '') {
            showError(input, errorElement, 'Umur tidak boleh kosong');
            return false;
        } else if (isNaN(value)) {
            showError(input, errorElement, 'Umur harus berupa angka');
            return false;
        } else if (value < 1 || value > 999) {
            showError(input, errorElement, 'Umur harus antara 1-999');
            return false;
        } else {
            removeError(input, errorElement);
            return true;
        }
    }
    
    // Fungsi bantuan untuk menampilkan pesan error
    function showError(input, errorElement, message) {
        input.style.borderColor = '#e74c3c';
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    // Fungsi bantuan untuk menghapus pesan error
    function removeError(input, errorElement) {
        input.style.borderColor = '';
        errorElement.style.display = 'none';
    }
    
    // Fungsi untuk membuat elemen error jika belum ada
    function createErrorElement(input, id) {
        const errorElement = document.createElement('div');
        errorElement.id = id;
        errorElement.className = 'error-message';
        errorElement.style.display = 'none';
        input.parentNode.insertBefore(errorElement, input.nextSibling);
        return errorElement;
    }
    
    // Inisialisasi error elements untuk validasi server-side
    document.addEventListener('DOMContentLoaded', function() {
        const nama = document.getElementById('nama');
        const umur = document.getElementById('umur');
        
        if (nama) {
            createErrorElement(nama, 'namaError');
            nama.addEventListener('blur', function() { validateName(this); });
        }
        
        if (umur) {
            createErrorElement(umur, 'umurError');
            umur.addEventListener('blur', function() { validateAge(this); });
        }
    });
</script>

</body>
</html>
