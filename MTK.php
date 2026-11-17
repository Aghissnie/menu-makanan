<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geometric Studio - Hitung Luas Persegi Panjang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #07090e;
            --bg-card: rgba(16, 22, 36, 0.75);
            --border-gold: rgba(229, 185, 95, 0.22);
            --border-gold-hover: rgba(229, 185, 95, 0.45);
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px;
            color: var(--text-main);
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

        .mtk-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-gold);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 
                0 30px 70px rgba(0, 0, 0, 0.65),
                0 0 35px rgba(223, 162, 64, 0.08);
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .badge-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold-primary);
            padding: 4px 14px;
            border-radius: 30px;
            background: rgba(223, 162, 64, 0.1);
            border: 1px solid rgba(223, 162, 64, 0.25);
            margin-bottom: 12px;
        }

        .card-title {
            font-family: var(--font-serif);
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .user-greeting {
            color: var(--text-muted);
            font-size: 13px;
        }

        .user-greeting b {
            color: var(--gold-light);
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--gold-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 14px;
        }

        input[type="number"] {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: rgba(11, 15, 25, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: all 0.25s ease;
        }

        input[type="number"]:focus {
            border-color: var(--gold-primary);
            box-shadow: 0 0 0 3px var(--gold-glow);
            background: rgba(15, 23, 42, 0.85);
        }

        .btn-calc-luxury {
            width: 100%;
            padding: 16px;
            background: var(--gold-gradient);
            border: none;
            border-radius: 12px;
            color: #1a1202;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 10px 25px rgba(223, 162, 64, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-calc-luxury:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(223, 162, 64, 0.5);
        }

        .footer-action {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
            display: inline-block;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.35);
            color: #fca5a5;
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <div class="mtk-card">
        <div class="header-section">
            <span class="badge-tag">GEOMETRIC COMPUTATION</span>
            <h1 class="card-title">Hitung Luas Bangun</h1>
            <div class="user-greeting">
                <?php if (isset($_SESSION['nama'])): ?>
                    Akses pengguna: <b><?= htmlspecialchars($_SESSION['nama']) ?></b>
                <?php else: ?>
                    Perhitungan Luas Persegi Panjang
                <?php endif; ?>
            </div>
        </div>

        <form action="balok.php" method="post">
            <div class="form-group">
                <label for="panjang">Panjang (p)</label>
                <div class="input-wrapper">
                    <span class="input-icon">📏</span>
                    <input id="panjang" name="panjang" type="number" step="any" placeholder="Masukkan nilai panjang" min="0.001" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="lebar">Lebar (l)</label>
                <div class="input-wrapper">
                    <span class="input-icon">📐</span>
                    <input id="lebar" name="lebar" type="number" step="any" placeholder="Masukkan nilai lebar" min="0.001" required>
                </div>
            </div>

            <button type="submit" class="btn-calc-luxury">
                <span>Kalkulasi Luas Sekarang</span>
                <span>✦</span>
            </button>
        </form>

        <div class="footer-action">
            <a href="logout.php" class="btn-logout">🚪 Keluar (Logout)</a>
        </div>
    </div>
</body>
</html>
