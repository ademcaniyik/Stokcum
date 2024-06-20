<!DOCTYPE html>
<html lang="en" class="dark">
<body>
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
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stokcum</title>
    <!-- Styles -->
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
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Mailler</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Mail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-body">
                                <div class="compose-email">
                                    <div class="mail-box">
                                        <aside class="sm-side">
                                            <div class="user-head">
                                                <a class="inbox-avatar" href="javascript:;">
                                                    <?php echo '<img class="avatar-img" src="' . $_SESSION['user']['pp_img_url'] . '" alt="Profil Resmi" />'; ?>
                                                </a>
                                                <div class="">
                                                    <div class="user-profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
                                                    <span class=""><?php echo htmlspecialchars($user['email']); ?></span>
                                                </div>
                                            </div>
                                            <div class="inbox-body text-center">
                                                <a href="#myModal" data-toggle="modal" title="Compose" class="btn btn-compose"> Mail gönder</a>
                                                <!-- Modal -->
                                                <div aria-hidden="true" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content text-left">
                                                            <div class="modal-header">
                                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="ti-close"></i></button>
                                                                <h4 class="modal-title">oluştur</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal">
                                                                    <div class="form-group">
                                                                        <label class="col-lg-2 control-label">Kime</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" placeholder="" id="inputEmail1" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-2 control-label">Ayrıca ilet</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" placeholder="" id="cc" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-2 control-label">Konu</label>
                                                                        <div class="col-lg-10">
                                                                            <input type="text" placeholder="" id="inputPassword1" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-lg-2 control-label">Mesaj</label>
                                                                        <div class="col-lg-10">
                                                                            <textarea rows="10" cols="30" class="form-control" id="texarea1" name="texarea"></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="col-lg-offset-2 col-lg-10">
                                                                                <span class="btn green fileinput-button"><i class="fa fa-plus fa fa-white"></i>
																	<span>Ek</span>
                                                                                <input type="file" name="files[]" multiple="">
                                                                                </span>
                                                                            <button class="btn btn-primary" type="submit">Gönder</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                            </div>

                                        </aside>
                                        <aside class="lg-side">
                                            <div class="inbox-head">
                                                <h3 class="input-text">Gelen kutusu</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-inbox table-hover table-responsive">
                                                    <tbody>

                                                    <tr class="">
                                                        <td class="view-message dont-show">Kimden geldi</td>
                                                        <td class="view-message view-message">Konu</td>
                                                        <td class="view-message text-right">TARİH</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </aside>
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
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/jquery.nicescroll.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>