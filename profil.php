<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: giris.php');
    exit;
}
$user = $_SESSION['user'];
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
    <title>Profil</title>
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
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Profil</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Profil</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card alert">
                            <div class="card-body">
                                <div class="user-profile">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?php
                                            // Kullanıcının profil resmini kontrol et
                                            if (!empty($user['pp_img_url'])) {
                                                echo '<img class="img-responsive" src="' . $user['pp_img_url'] . '" alt="Profil Resmi">';
                                            } else {
                                                // Varsayılan bir resim göstermek için:
                                                echo '<img class="img-responsive" src="assets/images/default_user.jpg" alt="Varsayılan Profil Resmi" width="500" height="500">';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="user-profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
                                            <div class="user-Location"><i class="ti-location-pin"></i> <?php echo htmlspecialchars($user['address']); ?></div>
                                            <div class="user-job-title">
                                                <?php
                                                // Kullanıcı düzeyine göre görev belirle
                                                if ($user['user_level'] == 1) {
                                                    echo 'Yönetici';
                                                } elseif ($user['user_level'] == 2) {
                                                    echo 'Çalışan';
                                                }
                                                ?>
                                            </div>
                                            <div class="custom-tab user-profile-tab">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Hakkında</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="1">
                                                        <div class="contact-information">
                                                            <h4>İletişim bilgileri</h4>
                                                            <div class="phone-content">
                                                                <span class="contact-title">Telefon:</span>
                                                                <span class="phone-number"><?php echo htmlspecialchars($user['phone']); ?></span>
                                                            </div>
                                                            <div class="address-content">
                                                                <div class="mail-address">
                                                                    <span class="contact-title">Adres:</span>
                                                                    <span><?php echo htmlspecialchars($user['address']); ?></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title">Email:</span>
                                                                    <span><?php echo htmlspecialchars($user['email']); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="birthday-content">
                                                                <span class="contact-title">Doğum tarihi:</span>
                                                                <span><?php echo htmlspecialchars($user['birthday']); ?></span>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include JS files -->
<script src="assets/js/lib/calendar-2/moment.latest.min.js"></script>
<script src="assets/js/lib/calendar-2/semantic.ui.min.js"></script>
<script src="assets/js/lib/calendar-2/prism.min.js"></script>
<script src="assets/js/lib/calendar-2/pignose.calendar.min.js"></script>
<script src="assets/js/lib/calendar-2/pignose.init.js"></script>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
