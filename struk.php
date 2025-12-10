<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil ID transaksi
$id = $_GET['id'] ?? 0;

// Ambil data transaksi
$stmt = $conn->prepare("SELECT * FROM transactions WHERE id = ?");
$stmt->execute([$id]);
$transaksi = $stmt->fetch();

if (!$transaksi) {
    die("Transaksi tidak ditemukan!");
}

// Ambil detail item dari transaction_items
$stmt2 = $conn->prepare("
    SELECT ti.*, p.name, p.price
    FROM transaction_items ti
    JOIN products p ON p.id = ti.product_id
    WHERE ti.transaction_id = ?
");
$stmt2->execute([$id]);
$items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; padding:30px; }
        .struk {
            max-width: 350px;
            margin: auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        h2 { text-align:center; margin-bottom:5px; }
        .line { border-bottom:1px dashed #333; margin:10px 0; }
        table { width:100%; font-size:14px; }
        td { padding:4px 0; }
        .total { font-weight:bold; font-size:16px; }
        .btn {
            display:block;
            margin-top:20px;
            text-align:center;
            padding:10px;
            background:#27ae60;
            color:white;
            border-radius:5px;
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="struk">
    <h2>KANTIN SEHAT</h2>
    <p style="text-align:center; font-size:13px;">Struk Pembelian</p>
    <div class="line"></div>

    <p>
        Pembeli: <b><?php echo $_SESSION['username']; ?></b><br>
        Tanggal: <?= date('d/m/Y H:i', strtotime($transaksi['created_at'])) ?>
    </p>

    <div class="line"></div>

    <table>
        <?php foreach($items as $item): ?>
        <tr>
            <td><?= $item['name'] ?> x<?= $item['quantity'] ?></td>
            <td style="text-align:right;">
                Rp <?= number_format($item['total_price'], 0, ',', '.') ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="line"></div>

    <p class="total">
        Total: Rp <?= number_format($transaksi['total_all'], 0, ',', '.') ?>
    </p>

    <a href="#" onclick="window.print()" class="btn">Cetak Struk</a>
    <a href="menu.php" class="btn" style="background:#3498db; margin-top:10px;">Kembali</a>
</div>

</body>
</html>
