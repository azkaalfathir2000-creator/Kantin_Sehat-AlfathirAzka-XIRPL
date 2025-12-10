<?php
// riwayat.php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambri riwayat transaksi user
$stmt = $conn->prepare("
    SELECT t.*, p.name as product_name 
    FROM transactions t 
    JOIN products p ON t.product_id = p.id 
    WHERE t.user_id = ? 
    ORDER BY t.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Kantin Sehat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #2c3e50; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #27ae60; color: white; }
        .btn { background: #3498db; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; }
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Riwayat Transaksi</h1>
        <a href="menu.php" class="btn">Kembali ke Menu</a>
        
        <?php if(count($transactions) > 0): ?>
        <table>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
            <?php foreach($transactions as $index => $transaction): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $transaction['product_name']; ?></td>
                <td><?php echo $transaction['quantity']; ?></td>
                <td>Rp <?php echo number_format($transaction['total_price'], 0, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($transaction['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p style="text-align:center; margin-top:30px;">Belum ada transaksi.</p>
        <?php endif; ?>
    </div>
</body>
</html>