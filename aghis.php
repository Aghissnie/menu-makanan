//Aghis pw:123
//Deril pw:911
//Udin pw:456
//admin pw:111

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $raw_nama = trim($_POST['nama'] ?? '');
    $nama     = strtolower($raw_nama);
    $pass     = trim($_POST['pass'] ?? '');

    // Aghis → Menu Makanan
    if ($nama === "aghis" && $pass === "123") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Aghis';
        $_SESSION['role']     = 'user';
        header("Location: menu.html");
        exit();
    }

    // Deril → Rumus Hitung Luas Persegi Panjang
    elseif ($nama === "deril" && $pass === "911") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Deril';
        $_SESSION['role']     = 'user';
        header("Location: MTK.php");
        exit();
    }

    // Udin → Menu Makanan
    elseif ($nama === "udin" && $pass === "456") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Udin';
        $_SESSION['role']     = 'user';
        header("Location: menu.html");
        exit();
    }

    // Admin → Dashboard Nilai
    elseif ($nama === "admin" && $pass === "111") {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama']     = 'Admin';
        $_SESSION['role']     = 'admin';
        header("Location: admin.php");
        exit();
    }

    // Salah login
    else {
        echo "<script>
                alert('Salah login bg 😅\\nPeriksa kembali username dan password Anda!');
                window.location='login.html';
              </script>";
        exit();
    }
} else {
    // Jika diakses langsung tanpa POST
    header("Location: login.html");
    exit();
}
?>
