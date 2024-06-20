<?php
// Oturum kontrolünü yap
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: giris.php');
    exit;
}
?>
<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <li class="label">Anasayfa</li>
                <li><a href="menu.php"><i class="ti-home"></i> Anasayfa </a></li>

                <?php
                if ($_SESSION['user']['user_level'] == 1) {
                    echo '<li class="label">Ürün İşlemleri</li>';
                    echo '<li><a class="sidebar-sub-toggle"><i class="ti-package"></i> Ürünler <span class="badge badge-primary"></span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>';
                    echo '<ul>';
                    echo '<li><a href="urun_goruntule.php">Ürün Görüntüle</a></li>';
                    echo '<li><a href="urun_duzenle.php">Ürün Düzenle</a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>

                <li class="label">Satış işlemleri</li>
                <li><a class="sidebar-sub-toggle"><i class="ti-money"></i> Satışlar <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="satis_yap.php">Satış yap</a></li>
                        <li><a href="satislariyonet.php">Satışları yönet</a></li>
                    </ul>
                </li>
                </li>
                <li class="label">Siparişler</li>
                <li><a class="sidebar-sub-toggle"><i class="ti-truck"></i> Sipariş Takip <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="siparis_et.php">Sipariş et</a></li>
                    </ul>
                    <ul>
                        <li><a href="order_list.php">Aktif Siparişleri görüntüle</a></li>
                    </ul>
                    <ul>
                        <li><a href="history_order_list.php">Geçmiş Siparişleri görüntüle</a></li>
                    </ul>
                </li>

                <?php
                if ($_SESSION['user']['user_level'] == 1) {
                    echo '<li class="label">Tedarikçiler</li>';
                    echo '<li><a class="sidebar-sub-toggle"><i class="ti-id-badge"></i> Tedarikçi Takip <span class="sidebar-collapse-icon ti-angle-down"></span></a>';
                    echo '<ul>';
                    echo '<li><a href="tedarikci_goruntule.php">Tedarikçi Görüntüle</a></li>';
                    echo '<li><a href="tedarikci_duzenle.php">Tedarikçi Düzenle</a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>
                <li class="label">Stok</li>
                <li><a class="sidebar-sub-toggle"><i class="ti-harddrives"></i> Stok Takip <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="stok_goruntuleme.php">Stok görüntüle</a></li>
                        <li><a href="stok_duzenle.php">Stok düzenle</a></li>
                    </ul>
                </li>

                <li class="label">Raporlar</li>
                <li><a class="sidebar-sub-toggle"><i class="ti-printer"></i>Raporlar <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="urun_rapor.php">Ürün raporları</a></li>
                        <li><a href="satis_rapor.php">Satış raporları</a></li>
                    </ul>
                </li>

                <?php
                if ($_SESSION['user']['user_level'] == 1) {
                    echo '<li class="label">Kullanıcı İşlemleri</li>';
                    echo '<li><a class="sidebar-sub-toggle"><i class="ti-user"></i>Kullanıcı İşlemleri <span class="sidebar-collapse-icon ti-angle-down"></span></a>';
                    echo '<ul>';
                    echo '<li><a href="kullanici_listesi.php">Kullanıcılar</a></li>';
                    echo '<li><a href="kullanici_ekleme.php">Kullanıcı Ekle</a></li>';
                    echo '<li><a href="kullanici_duzenle.php">Kullanıcı Düzenle</a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<!-- HEADER KISMI -->
<div class="header">
    <div class="pull-left">
        <div class="logo"><a href="menu.php"><img src="assets/images/logo.png" alt="" width="25" height="25"/><span>Yönetici Panel</span></a></div>
        <div class="hamburger sidebar-toggle">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>
    <div class="pull-right p-r-15">
        <ul>
            <li class="header-icon dib">
                <?php echo '<img class="avatar-img" src="' . $_SESSION['user']['pp_img_url'] . '" alt="Profil Resmi" />'; ?>
                <span class="user-avatar"><?php echo $_SESSION['user']['name']; ?> <i class="ti-angle-down f-s-10"></i></span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-heading"></div>
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="profil.php"><i class="ti-user"></i> <span>Profil</span></a></li>
                            <li><a href="inbox.php"><i class="ti-email"></i> <span>Bildirimler</span></a></li>
                            <li><a href="cıkıs.php"><i class="ti-power-off"></i> <span>Çıkış</span></a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>