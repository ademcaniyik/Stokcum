<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: giris.php');
    exit;
}

include('database/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $user_level = isset($_POST['user_level']) ? $_POST['user_level'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : ''; // E-mail'i de al
    $phone = isset($_POST['phone']) ? $_POST['phone'] : ''; // Telefon numarasını al
    $address = isset($_POST['address']) ? $_POST['address'] : ''; // Adresi al
    $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : ''; // Doğum gününü al

    // Resim yüklenmişse ve kaydedilecek bir dosya varsa
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $temp_name = $_FILES['image']['tmp_name'];
        $image_type = mime_content_type($temp_name);
        $allowed_types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];

        if (array_key_exists($image_type, $allowed_types)) {
            $extension = $allowed_types[$image_type];
            $dosyaAdi = strtolower(str_replace(' ', '_', $username)) . '.' . $extension;
            $target_dir = "profilresimleri/";
            $image_path = $target_dir . $dosyaAdi;

            if (!move_uploaded_file($temp_name, $image_path)) {
                echo "Resim yüklenirken bir hata oluştu.";
                exit;
            }
        } else {
            echo "Geçersiz dosya türü. Lütfen jpg, png veya gif dosyası yükleyin.";
            exit;
        }
    }

    // Veritabanına kullanıcı ekleme işlemi
    $sql = "INSERT INTO users (name, username, password, user_level, pp_img_url, status, email, phone, address, birthday) 
            VALUES (:name, :username, :password, :user_level, :pp_img_url, :status, :email, :phone, :address, :birthday)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':user_level', $user_level);
    $stmt->bindParam(':pp_img_url', $image_path);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':email', $email); // E-mail'i de bağla
    $stmt->bindParam(':phone', $phone); // Telefon numarasını bağla
    $stmt->bindParam(':address', $address); // Adresi bağla
    $stmt->bindParam(':birthday', $birthday); // Doğum gününü bağla

    if ($stmt->execute()) {
        // Kullanıcı başarıyla eklenirse
        header('Location: kullanici_ekleme.php');
        exit;
    } else {
        // Kullanıcı eklenemediyse
        echo "Kullanıcı eklenirken bir hata oluştu.";
    }
}
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
<?php
include "sidebar.php";
?>
<div class="content-wrap">
    <div id="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>Kullanıcı ekleme</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Kullanıcı ekleme</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card alert">
                        <div class="card-body">
                            <h4 class="card-title">Kullanıcı Ekle</h4>
                            <form action="kullanici_ekleme.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="name">Ad Soyad</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Şifre</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" required> <!-- E-mail alanı eklendi -->
                                </div>
                                <div class="form-group">
                                    <label for="user_level">Kullanıcı Yetkisi</label>
                                    <select class="form-control" id="user_level" name="user_level" required>
                                        <option value="1">Admin</option>
                                        <option value="2">Normal Kullanıcı</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Telefon Numarası</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Adres</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label for="birthday">Doğum Günü</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Profil Resmi</label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                </div>

                                <button type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
