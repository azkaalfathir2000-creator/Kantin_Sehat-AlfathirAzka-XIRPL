<?php
// riwayat.php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil riwayat transaksi user
$stmt = $conn->prepare("
    SELECT * FROM transactions
    WHERE user_id = ?
    ORDER BY created_at DESC
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

        <?php if (count($transactions) > 0): ?>
        <table>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Total Harga</th>
                <th>Waktu</th>
            </tr>

            <?php foreach($transactions as $index => $t): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td>
                    <?php
                    $items = $conn->prepare("
                        SELECT ti.*, p.name 
                        FROM transaction_items ti
                        JOIN products p ON ti.product_id = p.id
                        WHERE ti.transaction_id = ?
                    ");
                    $items->execute([$t['id']]);
                    $items = $items->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($items as $i) {
                        echo "- {$i['name']} (x{$i['quantity']})<br>";
                    }
                    ?>
                </td>

                <td>Rp <?php echo number_format($t['total_all'], 0, ',', '.'); ?></td>

                <td><?php echo date('d/m/Y H:i', strtotime($t['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <?php else: ?>
        <p style="text-align:center; margin-top:30px;">Belum ada transaksi.</p>
        <?php endif; ?>
    </div>
</body>
</html>
