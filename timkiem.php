<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        #search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        select, input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 200px;
            background-color: #fff;
            color: #333;
        }

        .search-btn {
            padding: 10px 20px;
            background-color: #f4b400;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: #e69100;
        }

        .search-title {
            color: #555;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Header Section -->
        <div id="header">
            <div class="logo">
            <img src="img/logo.png" alt="Sport Logo" width="100px">
            </div>
            <ul id="menu">
            <li class="item active"><a href="trangchu.php" id="trangchu">Trang Chủ</a></li>
                <li class="item"><a href="San.php">Danh sách sân</a></li>
                <?php
                    if(isset($_SESSION['MaNhanVien']) || isset($_SESSION['MaChuSan']) || isset($_SESSION['MaQuanTri']))
                    echo '<li class="item"><a href="admin.php">Quản lý</a></li>';
                ?>
                <!-- <li class="item"><a href="admin.php">Quản lý</a></li> -->
                <li class="item"><a href="timkiem.php">Tìm Kiếm</a></li>
            </ul>
            <div id="actions">
            <?php
                 if(isset($_SESSION["dangnhap"])){
                    // var_dump($_SESSION["hoten"]);
                    if( isset($_SESSION['loaiNguoiDung']) && $_SESSION['loaiNguoiDung'] == 'khachhang'){
                        echo '<button class="btn-login"><a style="color: white;" href="?lichsudatsan">Danh sách đơn đặt sân</a></button>';
                    }
                    echo '<button class="btn-login"><a style="color: white;" href="view/userDetail.php"><i style="font-size:24px" class="fa">&#xf007;</i> '.$_SESSION["hoten"].'</a></button>';
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangxuat.php">Đăng xuất</a></button>';
                 }else{
                    echo '<button class="btn-register"><a style="color: white;" href="view/dangki.php">Đăng ký</a></button>';
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangnhap.php">Đăng nhập</a></button>';
                 }
            ?>
            </div>
        </div>

        <?php
    if (isset($_REQUEST["lichsudatsan"])) {
        if (isset($_SESSION['loaiNguoiDung']) && $_SESSION['loaiNguoiDung'] == 'khachhang') {
            include_once("View/listDonDatSan.php");
        }
    }else{
        echo '<div id="search-bar">
            <div class="search-container">
                <form action="#" method="get">
                    <input type="text" name="txtTuKhoa" placeholder="Tên sân">
                    <input type="text" name="txtTuKhoa1" placeholder="Địa Chỉ">
                    <input type="submit" class="search-btn" name="btnTim" value="Tìm">
                </form>
            </div>
        </div>';
    }
     ?>

        

        <div class="search-container">
        <?php
            include_once("controller/cSan.php");
            $p = new cSan();

            $kq = null; // Khởi tạo giá trị mặc định

            if (isset($_REQUEST['btnTim'])) {
                $tuKhoa = isset($_REQUEST['txtTuKhoa']) ? trim($_REQUEST['txtTuKhoa']) : '';
                $diaChi = isset($_REQUEST['txtTuKhoa1']) ? trim($_REQUEST['txtTuKhoa1']) : '';
                $kq = $p->GetSanByNameAndAddress($tuKhoa, $diaChi);
            }

            if ($kq && mysqli_num_rows($kq) > 0) {
                echo "<h2 class='search-result-title'>Kết quả tìm kiếm</h2>";
                echo "<table>";
                echo "<tr>";
                $dem = 0;

                while ($r = mysqli_fetch_assoc($kq)) {
                    echo "<td>";
                    echo "<div class='product-item'>";
                    echo "<img src='img/SanBong/".$r['HinhAnh']."' width='200px' height='120px'/><br>";
                    echo "<a href='?idsan=" . $r["MaSanBong"] . "'>" . $r["TenSanBong"] . "</a><br>";
                    echo $r["TenLoai"] . "<br>";
                    echo "<button class='btn-book'><a style='color: white;' href='San.php?idsan=".$r["MaSanBong"]."'>Xem chi tiết</a></button>";
                    echo "</div>";
                    echo "</td>";
                    $dem++;

                    if ($dem % 5 == 0) {
                        echo "</tr><tr>";
                    }
                }
                echo "</tr>";
                echo "</table>";
            } elseif (isset($_REQUEST['btnTim'])) {
                echo "<p>Không tìm thấy sân bóng phù hợp với từ khóa.</p>";
            } else {
                // echo "<p>Vui lòng nhập từ khóa và nhấn tìm kiếm.</p>";
            }
            ?>

        </div>

        <div id="footer">
            <div class="box">
                <h3>GIỚI THIỆU</h3>
                <div class="logo">
                    <img src="assets/logo.png" alt="">
                </div>
                <p>Cung cấp một nền tảng tiện lợi, giúp người dùng dễ dàng tìm kiếm, đặt chỗ và quản lý việc thuê sân bóng</p>
            </div>
            <div class="box">
                <h3>NỘI DUNG</h3>
                <ul class="quick-menu">
                    <div class="item">
                        <a href="index.php">Trang chủ</a>
                    </div>
                    <div class="item">
                        <a href="dssan.php">Danh sách sân</a>
                    </div>
                    <div class="item">
                        <a href="">Dịch vụ</a>
                    </div>
                    <div class="item">
                        <a href="https://www.facebook.com/chuyen.cho.thue.san.bong/">Liên hệ</a>
                    </div>
                </ul>
            </div>
            <div class="box">
                <h3>Thông tin</h3>
                <div class="item">
                    <p><strong>Website đặt sân trực tuyến</strong></p>
                    <p>Email: <a href="mailto:contact@datsan247.com">contac@datsan.com</a></p>
                    <p>Địa chỉ: Nguyễn Văn Bảo, Phường 14, Gò Vấp</p>
                    <p>Điện thoại: <a href="tel:+84355193363">0355193363</a></p>
                </div>
            </div>
            
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>