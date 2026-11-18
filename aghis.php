<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $raw_nama = trim($_POST['nama'] ?? '');
    $nama     = strtolower($raw_nama);
    $pass     = trim($_POST['pass'] ?? '');

    // 1. User Aghis → Menu Makanan
    if ($nama === "aghis" && $pass === "123") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Aghis';
        $_SESSION['role']     = 'user';
        header("Location: menu.html");
        exit();
    }

    // 2. User Deril → Rumus Hitung Luas Persegi Panjang
    elseif ($nama === "deril" && $pass === "911") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Deril';
        $_SESSION['role']     = 'user';
        header("Location: MTK.html");
        exit();
    }

    // 3. User Udin → Struktur Tabel Colspan & Rowspan
    elseif ($nama === "udin" && $pass === "456") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Udin';
        $_SESSION['role']     = 'user';
        header("Location: table.html");
        exit();
    }

    // 4. User Admin → Dashboard Evaluasi Nilai
    elseif ($nama === "admin" && $pass === "111") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Admin';
        $_SESSION['role']     = 'admin';
        header("Location: admin.html");
        exit();
    }

    // Salah login
    else {
        echo "<script>
                alert('Salah login bg 😅\\nPeriksa kembali username dan password Anda!');
                window.location='index.html';
              </script>";
        exit();
    }
} else {
    header("Location: index.html");
    exit();
}
?>
