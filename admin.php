<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$grade = '';
$keterangan = '';

if (isset($_POST['nilai'])) {
    $raw_val = $_POST['nilai'];
    if ($raw_val !== '' && is_numeric($raw_val)) {
        $nilai = (float)$raw_val;
        if ($nilai >= 90 && $nilai <= 100) {
            $grade = 'A';
            $keterangan = 'Istimewa / Sangat Memuaskan (High Distinction)';
        } elseif ($nilai >= 80 && $nilai < 90) {
            $grade = 'B';
            $keterangan = 'Memuaskan / Sangat Baik (Distinction)';
        } elseif ($nilai >= 70 && $nilai < 80) {
            $grade = 'C';
            $keterangan = 'Cukup / Baik (Credit)';
        } elseif ($nilai >= 60 && $nilai < 70) {
            $grade = 'D';
            $keterangan = 'Kurang / Perlu Bimbingan (Pass)';
        } elseif ($nilai >= 0 && $nilai < 60) {
            $grade = 'E';
            $keterangan = 'Tidak Lulus / Mengulang (Failure)';
        } else {
            $keterangan = 'Nilai harus dalam rentang 0 sampai 100!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Executive Dashboard - Penilaian Akademik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Oswald:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_dash.css?v=sangar_20261117">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Top Executive Header -->
        <header class="admin-nav">
            <div class="brand-box">
                <span class="brand-title">EXECUTIVE ADMIN CONSOLE</span>
            </div>
            <div class="user-profile">
                <span class="admin-name"><?= htmlspecialchars($_SESSION['nama'] ?? 'Administrator') ?></span>
                <a href="logout.php" class="btn-admin-logout">Keluar</a>
            </div>
        </header>

        <!-- Main Dashboard Card -->
        <main class="dashboard-container">
            <div class="card-header">
                <span class="section-tag">EVALUASI AKADEMIK</span>
                <h1 class="dashboard-title">Dashboard Akreditasi Nilai</h1>
                <p class="dashboard-desc">Sistem kalkulasi dan standarisasi predikat nilai akademik berstandar modern.</p>
            </div>

            <form method="post" class="grade-form">
                <div class="input-field-group">
                    <label for="nilai">Masukkan Nilai Siswa (Skala 0 - 100)</label>
                    <div class="input-with-button">
                        <input type="number" id="nilai" name="nilai" placeholder="Contoh: 88.5" max="100" min="0" step="any" value="<?= isset($_POST['nilai']) ? htmlspecialchars((string)$_POST['nilai']) : '' ?>" required autofocus>
                        <input type="submit" value="Evaluasi Nilai" class="btn-submit-eval">
                    </div>
                </div>
            </form>

            <?php if ($grade !== ''): ?>
                <div class="result-card">
                    <div class="result-badge-container">
                        <div class="grade-label">Predikat Akreditasi</div>
                        <div class="grade-letter"><?= $grade ?></div>
                    </div>
                    <div class="result-info">
                        <div class="keterangan-text"><?= $keterangan ?></div>
                        <div class="score-summary">Nilai yang diuji: <b><?= htmlspecialchars((string)$_POST['nilai']) ?></b> / 100</div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Grading Scale Standard Reference -->
            <div class="grading-reference">
                <div class="ref-title">Standar Skala Penilaian:</div>
                <div class="ref-grid">
                    <div class="ref-pill"><b>A</b> 90 - 100</div>
                    <div class="ref-pill"><b>B</b> 80 - 89</div>
                    <div class="ref-pill"><b>C</b> 70 - 79</div>
                    <div class="ref-pill"><b>D</b> 60 - 69</div>
                    <div class="ref-pill"><b>E</b> &lt; 60</div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
