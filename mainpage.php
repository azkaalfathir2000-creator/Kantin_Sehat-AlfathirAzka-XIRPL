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

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
  margin: 0;
}

/* Sidenav jadi flex column */
.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #111;
  padding-top: 20px;
  
  display: flex;
  flex-direction: column;
}

.sidenav a {
  padding: 10px 20px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

/* Buat Transaksi turun ke bawah */
.transaksi {
  margin-top: auto;
  margin-bottom: 30px;
}

.main {
  margin-left: 200px;
  padding: 20px;
}

</style>
</head>
<body>

<div class="sidenav">
  <a href="#">Menu</a>
  <a href="#">Transaksi</a>

  <!-- Transaksi pindah ke bawah -->
  <a href="#" class="transaksi">Logout</a>
</div>

<div class="main">
  <h2>Sidenav Example</h2>
  <p>This sidenav is always shown.</p>
</div>


   
</body>
</html>