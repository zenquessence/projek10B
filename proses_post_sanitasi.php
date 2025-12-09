<?php

// Fungsi sanitasi
function bersihkan($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

$nim            = bersihkan($_POST['nim']);
$nama           = bersihkan($_POST['nama']);
$umur           = bersihkan($_POST['umur']);
$tempat_lahir   = bersihkan($_POST['tempat_lahir']);
$tanggal_lahir  = bersihkan($_POST['tanggal_lahir']);
$no_hp          = bersihkan($_POST['no_hp']);
$alamat         = bersihkan($_POST['alamat']);
$email          = bersihkan($_POST['email']);

// Sanitasi kota
$kota = bersihkan($_POST['kota']);

// Sanitasi jenis kelamin (radio)
$jk = isset($_POST['jk']) ? bersihkan($_POST['jk']) : "-";

// Sanitasi status kawin
$status = isset($_POST['status']) ? bersihkan($_POST['status']) : "-";

// Sanitasi checkbox hobi
$hobi_list = [];
if (!empty($_POST['hobi'])) {
    foreach ($_POST['hobi'] as $h) {
        $hobi_list[] = bersihkan($h);
    }
}
$hobi_output = implode(", ", $hobi_list);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Input Data Mahasiswa</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --border-color: #e0e0e0;
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
            max-width: 900px;
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
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .data-container {
            display: flex;
            margin-bottom: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-label {
            width: 200px;
            font-weight: 600;
            color: var(--secondary-color);
            flex-shrink: 0;
        }
        
        .data-value {
            flex: 1;
            word-break: break-word;
        }
        
        .data-value ul, .data-value ol {
            margin: 5px 0 5px 20px;
        }
        
        .btn-back {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        
        .btn-back:hover {
            background-color: #2980b9;
        }
        
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .data-container {
                flex-direction: column;
            }
            
            .data-label {
                width: 100%;
                margin-bottom: 5px;
                font-weight: 600;
            }
            
            .container {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Data Mahasiswa</h2>

    <div class="data-container">
        <span class="data-label">NIM:</span>
        <span class="data-value"><?= $nim ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Nama:</span>
        <span class="data-value"><?= $nama ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Umur:</span>
        <span class="data-value"><?= $umur ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Tempat Lahir:</span>
        <span class="data-value"><?= $tempat_lahir ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Tanggal Lahir:</span>
        <span class="data-value"><?= $tanggal_lahir ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">No HP:</span>
        <span class="data-value"><?= $no_hp ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Alamat:</span>
        <span class="data-value"><?= $alamat ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Kota:</span>
        <span class="data-value">
            <?php
            if ($kota == "Semarang") echo "Semarang";
            elseif ($kota == "Solo") echo "Solo";
            elseif ($kota == "Brebes") echo "Brebes";
            elseif ($kota == "Kudus") echo "Kudus";
            elseif ($kota == "Demak") echo "Demak";
            else echo "Salatiga";
            ?>
        </span>
    </div>

    <div class="data-container">
        <span class="data-label">Jenis Kelamin:</span>
        <span class="data-value"><?= $jk ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Status:</span>
        <span class="data-value"><?= $status ?></span>
    </div>

    <div class="data-container">
        <span class="data-label">Hobi:</span>
        <span class="data-value">
            <?php 
            if (!empty($hobi_list)) {
                echo '<ul><li>' . implode('</li><li>', $hobi_list) . '</li></ul>';
            }
            ?>
        </span>
    </div>

    <div class="data-container">
        <span class="data-label">Email:</span>
        <span class="data-value"><?= $email ?></span>
    </div>

    <div class="button-container">
        <a href="F_POST.php" class="btn-back">Kembali ke Form</a>
    </div>
</div>

</body>
</html>
