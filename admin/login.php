<?php
session_start();

$admin_username = "admin";
$admin_password = "12345";

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        $_SESSION['logged_in'] = true;
        header("Location: panel.php");
        exit;
    } else {
        $error = "Hatalı kullanıcı adı veya şifre!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Giriş</title>
</head>
<body>
    <h2>Admin Giriş</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required><br><br>
        <input type="password" name="password" placeholder="Şifre" required><br><br>
        <button type="submit">Giriş Yap</button>
    </form>
</body>
</html>
