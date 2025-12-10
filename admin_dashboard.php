<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Akses ditolak!";
    exit();
}

// Ambil produk
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Ambil transaksi semua user
$transactions = $conn->query("
    SELECT t.*, u.username, p.name as product_name
    FROM transactions t
    JOIN users u ON t.user_id = u.id
    JOIN products p ON t.product_id = p.id
    ORDER BY t.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<style>
body { font-family: Arial; background:#f4f4f4; padding:20px; }
.box { background:white; padding:20px; margin-bottom:20px; border-radius:10px; }
table { width:100%; border-collapse:collapse; margin-top:10px; }
th, td { padding:10px; border-bottom:1px solid #ddd; }
th { background:#333; color:white; }
.btn { padding:5px 10px; background:#3498db; color:white; border-radius:5px; text-decoration:none; }
.btn-del { background:#e74c3c; }
</style>
</head>
<body>

<h1>Admin Dashboard</h1>
<a href="menu.php" class="btn">← Kembali</a>

<div class="box">
<h2>Kelola Produk</h2>
<a href="produk_tambah.php" class="btn">Tambah Produk</a>

<table>
<tr>
    <th>ID</th><th>Nama</th><th>Harga</th><th>Aksi</th>
</tr>

<?php foreach($products as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['name'] ?></td>
    <td>Rp <?= number_format($p['price']) ?></td>
    <td>
        <a href="produk_edit.php?id=<?= $p['id'] ?>" class="btn">Edit</a>
        <a href="produk_hapus.php?id=<?= $p['id'] ?>" class="btn btn-del" onclick="return confirm('Hapus produk ini?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div class="box">
<h2>Riwayat Semua User</h2>

<table>
<tr>
    <th>User</th><th>Produk</th><th>Qty</th><th>Total</th><th>Tanggal</th><th>Aksi</th>
</tr>

<?php foreach($transactions as $t): ?>
<tr>
    <td><?= $t['username'] ?></td>
    <td><?= $t['product_name'] ?></td>
    <td><?= $t['quantity'] ?></td>
    <td>Rp <?= number_format($t['total_price']) ?></td>
    <td><?= $t['created_at'] ?></td>
    <td>
        <a href="transaksi_hapus.php?id=<?= $t['id'] ?>" class="btn btn-del"
           onclick="return confirm('Hapus riwayat ini?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>

</body>
</html>
