<?php
include 'config.php';

if ($_SESSION['role'] != 'admin') { exit("Akses ditolak!"); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO products (name, price, size, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['size'], $_POST['description']]);

    header("Location: admin_dashboard.php");
    exit();
}
?>
<form method="POST">
Nama: <input type="text" name="name"><br>
Harga: <input type="number" name="price"><br>
Ukuran: <input type="text" name="size"><br>
Deskripsi: <textarea name="description"></textarea><br>
<button type="submit">Simpan</button>
</form>
