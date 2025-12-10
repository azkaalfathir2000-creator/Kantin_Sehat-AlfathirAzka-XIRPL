<?php
// transaksi.php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil data produk
$product_id = $_GET['product_id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("Produk tidak ditemukan!");
}

// Proses transaksi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = $_POST['quantity'];
    $total_price = $quantity * $product['price'];
    
    // Simpan transaksi
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $product_id, $quantity, $total_price]);
    
    header('Location: riwayat.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Kantin Sehat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; display: flex; justify-content: center; padding: 50px; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; }
        h2 { color: #2c3e50; text-align: center; }
        .product-info { background: #ecf0f1; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; width: 100%; }
        .btn:hover { background: #219653; }
        .back { display: block; text-align: center; margin-top: 15px; color: #3498db; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Transaksi Pembelian</h2>
        
        <div class="product-info">
            <h3><?php echo $product['name']; ?></h3>
            <p>Harga: Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
            <p>Ukuran: <?php echo $product['size']; ?></p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>Jumlah Pembelian</label>
                <input type="number" name="quantity" min="1" max="10" value="1" required>
            </div>
            
            <button type="submit" class="btn">Proses Transaksi</button>
        </form>
        
        <a href="menu.php" class="back">← Kembali ke Menu</a>
    </div>
</body>
</html>