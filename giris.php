<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: menu.php');
    exit;
}
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('database/connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hazırlanmış ifade kullanarak SQL enjeksiyondan korunma
    $query = 'SELECT * FROM users WHERE username = :email AND password = :sifre';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $username);
    $stmt->bindParam(':sifre', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetch();
        $user['phone'] = $user['phone'] ?? '';
        $user['address'] = $user['address'] ?? '';
        $user['email'] = $user['email'] ?? '';
        $user['birthday'] = $user['birthday'] ?? '';
        $user['pp_img_url'] = $user['pp_img_url'] ?? '';
        // Kullanıcı doğrulandı
        $_SESSION['user'] = $user;
        header('Location: menu.php');
        exit;
    } else {
        $error_message = "Lütfen kullanıcı adınızı ve şifrenizi doğru giriniz.";
    }
}

// Profil resmini gösterme
if (!empty($_SESSION['user']['pp_img_url'])) {
    echo '<img class="img-responsive" src="' . $_SESSION['user']['pp_img_url'] . '" alt="Profil Resmi">';
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş</title>
    <link rel="stylesheet" href="dist/css/login.css">
</head>
<body>

<div class="login-card">
    <div class="card-header">
        <h1>Giriş</h1>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı adınız</label>
                <input type="text" id="username" name="username" required="">
            </div>
            <div class="form-group">
                <label for="password">Şifreniz</label>
                <input type="password" id="password" name="password" required="">
            </div>
            <div class="form-group">
                <button type="submit" class="login-button">Giriş</button>
            </div>
            <div id="errorMessage">
                <?php if (!empty($error_message)) echo "<p>$error_message</p>"; ?>
            </div>
        </form>
    </div>
</div>
</body>
</html>
