<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: MTK.php");
    exit();
}

$panjang = isset($_POST['panjang']) ? (float)$_POST['panjang'] : 0;  
$lebar   = isset($_POST['lebar'])   ? (float)$_POST['lebar']   : 0;

if ($panjang <= 0 || $lebar <= 0) {
    die("<script>alert('Input tidak valid! Nilai panjang dan lebar harus lebih dari 0.'); window.location='MTK.php';</script>");
}

$hasil = $panjang * $lebar;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Komputasi Geometri - Luas Persegi Panjang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #07090e;
            --bg-card: rgba(16, 22, 36, 0.75);
            --border-gold: rgba(229, 185, 95, 0.22);
            --gold-primary: #dfa240;
            --gold-light: #fbeed2;
            --gold-gradient: linear-gradient(135deg, #fcebc0 0%, #dfa240 50%, #996e18 100%);
            --gold-glow: rgba(223, 162, 64, 0.25);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --font-sans: 'Plus Jakarta Sans', -apple-system, sans-serif;
            --font-serif: 'Playfair Display', Georgia, serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: var(--font-sans);
        }

        body {
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(at 0% 0%, rgba(223, 162, 64, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(15, 23, 42, 0.6) 0px, transparent 100%);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        .ambient-glow {
            position: absolute;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(223, 162, 64, 0.12) 0%, rgba(0,0,0,0) 70%);
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        .result-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-gold);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 
                0 30px 70px rgba(0, 0, 0, 0.65),
                0 0 35px rgba(223, 162, 64, 0.08);
            max-width: 460px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .badge-header {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold-primary);
            padding: 4px 14px;
            border-radius: 30px;
            background: rgba(223, 162, 64, 0.1);
            border: 1px solid rgba(223, 162, 64, 0.25);
            margin-bottom: 14px;
            display: inline-block;
        }

        .result-title {
            font-family: var(--font-serif);
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 25px;
        }

        .computation-box {
            background: rgba(11, 15, 25, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: left;
        }

        .param-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 14px;
            color: var(--text-muted);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .param-row:last-of-type {
            border-bottom: none;
        }

        .param-row strong {
            color: #ffffff;
            font-size: 15px;
        }

        .formula-card {
            background: rgba(223, 162, 64, 0.08);
            border: 1px solid rgba(223, 162, 64, 0.25);
            border-radius: 14px;
            padding: 18px;
            margin-top: 15px;
            text-align: center;
        }

        .formula-title {
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--gold-light);
            margin-bottom: 6px;
            font-weight: 600;
        }

        .hasil-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--gold-primary);
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-grid {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn-again {
            flex: 1;
            padding: 14px 20px;
            background: var(--gold-gradient);
            border-radius: 12px;
            color: #1a1202;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px rgba(223, 162, 64, 0.3);
            display: inline-block;
        }

        .btn-again:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(223, 162, 64, 0.45);
        }

        .btn-logout {
            padding: 14px 22px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.25s ease;
            display: inline-block;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <div class="result-card">
        <span class="badge-header">HASIL KOMPUTASI</span>
        <h2 class="result-title">Luas Persegi Panjang</h2>

        <div class="computation-box">
            <div class="param-row">
                <span>Panjang (p)</span>
                <strong><?= htmlspecialchars((string)$panjang) ?></strong>
            </div>
            <div class="param-row">
                <span>Lebar (l)</span>
                <strong><?= htmlspecialchars((string)$lebar) ?></strong>
            </div>
            <div class="param-row">
                <span>Formula</span>
                <code>Luas = p &times; l</code>
            </div>

            <div class="formula-card">
                <div class="formula-title">Total Luas Bangun Datar</div>
                <div class="hasil-value"><?= htmlspecialchars((string)$hasil) ?></div>
            </div>
        </div>

        <div class="action-grid">
            <a href="MTK.php" class="btn-again">🔄 Hitung Ulang</a>
            <a href="logout.php" class="btn-logout">Keluar</a>
        </div>
    </div>
</body>
</html>
