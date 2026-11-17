<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["order"])) {
    header("Location: menu.html");
    exit();
}

$menu_data = [
    'pecel' => ['nama' => 'Nasi Pecel Komplit', 'harga' => 10000, 'icon' => '🥗'],
    'rawon' => ['nama' => 'Rawon Daging Istimewa', 'harga' => 15000, 'icon' => '🍲'],
    'esteh' => ['nama' => 'Es Teh Jumbo', 'harga' => 5000, 'icon' => '🧊'],
    'kopi'  => ['nama' => 'Kopi Tubruk Robusta', 'harga' => 5000, 'icon' => '☕'],
];

$items_ordered = [];
$total_bayar = 0;

if (isset($_POST["menu"]) && is_array($_POST["menu"])) {
    foreach ($_POST["menu"] as $menu_key) {
        if (isset($menu_data[$menu_key])) {
            $porsi_key = "porsi_" . $menu_key;
            $porsi = isset($_POST[$porsi_key]) ? max(1, (int)$_POST[$porsi_key]) : 1;
            $harga = $menu_data[$menu_key]['harga'];
            $subtotal = $harga * $porsi;
            $total_bayar += $subtotal;

            $items_ordered[] = [
                'nama'     => $menu_data[$menu_key]['nama'],
                'icon'     => $menu_data[$menu_key]['icon'],
                'harga'    => $harga,
                'porsi'    => $porsi,
                'subtotal' => $subtotal
            ];
        }
    }
}

$invoice_id = "INV-" . date("Ymd") . "-" . strtoupper(substr(md5(uniqid()), 0, 4));
$user_name  = $_SESSION['nama'] ?? 'Pelanggan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Struk Pesanan - RM Etan Kuburan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Oswald:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=sangar_20261117">
</head>
<body>
    <div class="receipt-wrapper">
        <div class="receipt-card">
            <!-- Receipt Header -->
            <div class="receipt-header">
                <h1 class="receipt-brand">RM ETAN <span class="accent-red">KUBURAN</span></h1>
                <p class="receipt-subtitle">STRUK PESANAN RESMI</p>
            </div>

            <div class="invoice-meta">
                <div class="meta-row">
                    <span>No. Transaksi</span>
                    <strong><?= $invoice_id ?></strong>
                </div>
                <div class="meta-row">
                    <span>Nama Pemesan</span>
                    <strong><?= htmlspecialchars($user_name) ?></strong>
                </div>
                <div class="meta-row">
                    <span>Waktu Pemesanan</span>
                    <span><?= date("d M Y &bull; H:i") ?> WIB</span>
                </div>
            </div>

            <?php if (empty($items_ordered)): ?>
                <div class="empty-receipt-alert">
                    <div class="alert-icon">⚠️</div>
                    <h3>Tidak Ada Menu yang Dipilih</h3>
                    <p>Mohon centang menu yang ingin dipesan terlebih dahulu sebelum mengonfirmasi order.</p>
                    <a href="menu.html" class="btn-return-menu">Kembali ke Daftar Menu</a>
                </div>
            <?php else: ?>
                <!-- Items Table -->
                <div class="table-wrapper">
                    <table class="receipt-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="col-center">Qty</th>
                                <th class="col-right">Harga</th>
                                <th class="col-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items_ordered as $item): ?>
                                <tr>
                                    <td>
                                        <div class="receipt-item-title">
                                          <span><?= $item['icon'] ?></span>
                                          <b><?= htmlspecialchars($item['nama']) ?></b>
                                        </div>
                                    </td>
                                    <td class="col-center"><?= $item['porsi'] ?>x</td>
                                    <td class="col-right">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                    <td class="col-right" style="font-weight: 700; color: #D62828;">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Total Summary Card -->
                <div class="receipt-total-box">
                    <div class="total-label">Total Pembayaran</div>
                    <div class="total-amount">Rp <?= number_format($total_bayar, 0, ',', '.') ?></div>
                    <div class="total-status">
                        <span class="status-badge">Menunggu Pembayaran di Kasir</span>
                    </div>
                </div>

                <!-- Navigation Actions -->
                <div class="receipt-actions">
                    <a href="menu.html" class="btn-return-menu">
                        &larr; Pesan Menu Lain
                    </a>
                    <a href="logout.php" class="btn-logout-receipt">
                        Keluar
                    </a>
                </div>
            <?php endif; ?>

            <div class="receipt-footer">
                <p>Terima kasih atas kunjungan Anda di <strong>RM Etan Kuburan</strong>.</p>
                <small>Sensasi kuliner tradisional dengan cita rasa berkelas.</small>
            </div>
        </div>
    </div>
</body>
</html>
