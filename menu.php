<?php
// menu.php
include 'config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil produk
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kantin Sehat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #ecf0f1; margin: 0; padding: 20px; }
        .header {
    background: #27ae60;
    color: white;
    padding: 30px;
    margin-bottom: 30px;
    align-content:  center;
}

.header-top {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.header a {
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    font-weight: bold;
}

.btn-keranjang { background: #f1c40f; color: black; }
.btn-keranjang:hover { background: #d4ac0d; }

.btn-riwayat { background: #8e44ad; }
.btn-riwayat:hover { background: #732d91; }

.logout { background: #e74c3c; }
.logout:hover { background: #c0392b; }

.menu-grid { display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
        gap: 20px; 
}
 .card {
    background: white;
    border-radius: 10px; 
    padding: 20px; 
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-name { color: #2c3e50; 
        font-size: 20px; margin-bottom: 10px; 
}
.product-price { color: #e74c3c; 
        font-size: 18px; 
        font-weight: bold; 
}
.product-size { color: #7f8c8d; 
}
.btn-pilih { background: #3498db; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px; }
.btn-pilih:hover { background: #2980b9; }
.logout { float: right; background: #e74c3c; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; }
.logout:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="header">
    <div class="header-top">
        <a href="keranjang.php" class="btn-keranjang">Keranjang</a>
        <a href="riwayat.php" class="btn-riwayat">Riwayat</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <h1>Menu Kantin Sehat</h1>
    <p>Halo, <?php echo $_SESSION['username']; ?>!</p>
</div>

    
    <div class="menu-grid">
        <?php foreach($products as $product): ?>
        <div class="card">
            <div class="product-name"><?php echo $product['name']; ?></div>
            <div class="product-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
            <div class="product-size">Ukuran: <?php echo $product['size']; ?></div>
            <p><?php echo $product['description']; ?></p>
            <form action="keranjang.php" method="POST" style="margin-top: 10px;">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

    <label>Qty:</label>
    <input type="number" name="quantity" value="1" min="1" style="width:60px; padding:5px;">

    <button type="submit" class="btn-pilih">Tambah</button>
</form>
        
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>