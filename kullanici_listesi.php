<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: giris.php');
    exit;
}

$user = $_SESSION['user'];
?>
<?php
include "database/connection.php";
$sql = "SELECT name, username, user_level, pp_img_url, email, phone, address, birthday FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcılar</title>
    <link href="assets/css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="assets/css/lib/weather-icons.css" rel="stylesheet" />
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Kullanıcılar</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content">
                <div class="row">
                    <?php foreach ($users as $user) : ?>
                        <div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-body">
                                    <div class="user-profile">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <?php
                                                $userName = htmlspecialchars($user['name']);
                                                $userImageUrl = $user['pp_img_url'] ? htmlspecialchars($user['pp_img_url']) : "profilresimleri/default_user.jpg";
                                                ?>
                                                <img class="img-responsive" src="<?php echo $userImageUrl; ?>" alt="<?php echo $userName; ?>" width="250" height="250">
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="user-profile-name"><?php echo $userName; ?></div>
                                                <div class="user-Location"><i class="ti-user"></i> <?php echo htmlspecialchars($user['username']); ?></div>
                                                <div class="user-job-title">Kullanıcı Seviyesi: <?php echo htmlspecialchars($user['user_level']); ?></div>
                                                <div class="custom-tab user-profile-tab">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Hakkında</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="1">
                                                            <div class="contact-information">
                                                                <h4>İletişim bilgileri</h4>
                                                                <div class="address-content">
                                                                    <span class="contact-title">Email:</span>
                                                                    <span class="mail-address"><?php echo htmlspecialchars($user['email']); ?></span>
                                                                </div>
                                                                <div class="address-content">
                                                                    <span class="contact-title">Telefon:</span>
                                                                    <span class="mail-address"><?php echo htmlspecialchars($user['phone']); ?></span>
                                                                </div>
                                                                <div class="address-content">
                                                                    <span class="contact-title">Adres:</span>
                                                                    <span class="mail-address"><?php echo htmlspecialchars($user['address']); ?></span>
                                                                </div>
                                                                <div class="address-content">
                                                                    <span class="contact-title">Doğum Günü:</span>
                                                                    <span class="mail-address"><?php echo htmlspecialchars($user['birthday']); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
