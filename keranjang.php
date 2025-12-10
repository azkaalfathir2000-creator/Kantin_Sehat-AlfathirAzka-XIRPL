<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

   
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product) {
       
        if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $qty;
} else {
    $_SESSION['cart'][$product_id] = [
        'id' => $product_id,
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $qty
    ];
}

    }
}


if (isset($_GET['hapus'])) {
    $hapus = $_GET['hapus'];
    unset($_SESSION['cart'][$hapus]);
}
if (isset($_POST['checkout'])) {

    // 1. Hitung total keseluruhan
    $total_all = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_all += $item['price'] * $item['quantity'];
    }

    // 2. Insert ke tabel TRANSACTIONS (tanpa kolom items)
    $stmt = $conn->prepare("
        INSERT INTO transactions (user_id, total_all)
        VALUES (?, ?)
    ");
    $stmt->execute([$_SESSION['user_id'], $total_all]);

    // 3. Ambil ID transaksi
    $transaction_id = $conn->lastInsertId();

    // 4. Insert item satu per satu ke TRANSACTION_ITEMS
    foreach ($_SESSION['cart'] as $item) {
        $total = $item['price'] * $item['quantity'];

        $stmt = $conn->prepare("
            INSERT INTO transaction_items (transaction_id, product_id, quantity, total_price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $transaction_id,
            $item['id'],
            $item['quantity'],
            $total
        ]);
    }

    // 5. Kosongkan keranjang
    $_SESSION['cart'] = [];

    // 6. Redirect ke halaman struk
    header("Location: struk.php?id=" . $transaction_id);
    exit();
}


?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Kantin Sehat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; }
       table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    text-align: center;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

        th { background: #27ae60; color: white; }
        .btn { padding: 8px 12px; border-radius: 5px; text-decoration: none; background: #27ae60; color: white;}
        .btn-hapus { background: #e74c3c; color: white; text-decoration: none; padding: 8px 12px;}
        .btn-checkout { background: #3498db; color: white; margin-top: 20px; display:block; text-align:center; padding:10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Keranjang Belanja</h2>

    <a href="menu.php" class="btn">← Kembali</a>

    <?php if(empty($_SESSION['cart'])): ?>
        <p style="text-align:center; margin-top:20px;">Keranjang masih kosong.</p>
    <?php else: ?>

    <table>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php foreach($_SESSION['cart'] as $item): ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td>Rp <?php echo number_format($item['price']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>Rp <?php echo number_format($item['price'] * $item['quantity']); ?></td>
            <td><a href="keranjang.php?hapus=<?php echo $item['id']; ?>" class="btn-hapus">Hapus</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form method="POST">
        <button type="submit" name="checkout" class="btn-checkout">Checkout</button>
    </form>

    <?php endif; ?>

</div>

</body>
</html>
