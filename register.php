<?php
// register.php
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek username sudah ada atau belum
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Insert user baru
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        // Auto login
        $newUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $newUser->execute([$username]);
        $userData = $newUser->fetch();

        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['username'] = $userData['username'];

        header("Location: menu.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kantin Sehat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; 
               display: flex; justify-content: center; align-items: center; 
               height: 100vh; margin:0; }
        .register-container { background: white; padding: 30px; border-radius: 10px;
               box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #2c3e50; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #3498db; color: white;
                 border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #2980b9; }
        .error { color: #e74c3c; text-align: center; margin-top: 10px; font-size:14px; }
        .success { color: #27ae60; text-align: center; margin-top: 10px; font-size:14px; }
        .login-link { text-align:center; margin-top:15px; }
        .login-link a { color:#27ae60; text-decoration:none; font-weight:bold; }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Buat Akun Baru</h2>

        <?php if($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <a href="login.php">Login</a>
        </div>
    </div>

</body>
</html>
