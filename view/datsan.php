
<?php
session_start();
ob_start();
$masan = isset($_REQUEST["idSan"]) ? $_REQUEST["idSan"] : null;
$maloaisan = isset($_REQUEST["mals"]) ? $_REQUEST["mals"] : null;

include_once("../controller/cDonDatSan.php");

// Định nghĩa bảng giá cho từng mã loại sân
$bangGia = [
    1 => ['sang' => 100000, 'chieu' => 120000], // Mã 1
    2 => ['sang' => 150000, 'chieu' => 170000], // Mã 2
    3 => ['sang' => 200000, 'chieu' => 250000]  // Mã 3
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Sân Bóng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('../img/pexels-photo-61135.jpeg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        margin: 20px auto;
        background-color: rgba(255, 255, 255, 0.85);
        padding: 30px;
        border-radius: 15px;
        width: 80%;
        max-width: 800px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    h1 {
        text-align: center;
        font-size: 32px;
        color: #0062E6;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        margin: auto;
        border-collapse: collapse;
    }

    td {
        padding: 12px 15px;
        font-size: 16px;
        color: #333;
    }

    td:first-child {
        text-align: right;
        font-weight: bold;
        color: #0062E6;
    }

    td:last-child {
        text-align: left;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"],
    select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 8px 0;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="time"]:focus,
    select:focus {
        border-color: #0062E6;
        outline: none;
    }

    input[type="submit"],
    input[type="reset"] {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 10px;
    }

    input[type="submit"] {
        background-color: #0062E6;
        color: #fff;
    }

    input[type="reset"] {
        background-color: #f44336;
        color: #fff;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    input[type="reset"]:hover {
        background-color: #d32f2f;
    }

    .info-box {
        text-align: center;
        margin-top: 20px;
        padding: 20px;
        background-color: rgba(0, 98, 230, 0.1);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .info-box h3 {
        font-size: 24px;
        color: #0062E6;
        margin-bottom: 10px;
    }

    .info-box p {
        font-size: 16px;
        color: #333;
        margin: 5px 0;
    }

    .btn-view {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-view:hover {
        background-color: #0056b3;
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 25px;
        color: #333;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #ff4d4d;
    }

    @media (max-width: 768px) {
        .container {
            width: 90%;
        }

        td {
            display: block;
            text-align: left;
        }

        .info-box {
            padding: 10px;
        }
    }
    </style>
</head>
<body>
<div class="container">
    <button class="close-btn" onclick="window.history.back();">&times;</button>
    <form action="#" method="POST">
        <h1>Đặt sân</h1>
        <table>
            <tr>
                <td>Số điện thoại</td>
                <td><input type="text" name="txtSDT" value="<?php echo $_POST['txtSDT'] ?? ''; ?>" required></td>
            </tr>
            <tr>
                <td>Ngày đặt</td>
                <td><input type="date" name="txtNgayDat" value="<?php echo $_POST['txtNgayDat'] ?? ''; ?>" required></td>
            </tr>
            <tr>
                <td>Giờ bắt đầu</td>
                <td><input type="time" name="txtGioBatDau" value="<?php echo $_POST['txtGioBatDau'] ?? ''; ?>" required></td>
            </tr>
            <tr>
                <td>Giờ kết thúc</td>
                <td><input type="time" name="txtGioKetThuc" value="<?php echo $_POST['txtGioKetThuc'] ?? ''; ?>" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" value="Đặt sân" name="btnDat">
                    <input type="reset" value="Nhập lại">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($_POST['btnDat'])) {
        $p = new cDonDatSan();

        // Kiểm tra số điện thoại có tồn tại không
        $tblktds = $p->getKiemTraSDT($_POST['txtSDT']);
        
        if ($tblktds) {
            $ngayDat = $_POST['txtNgayDat'];
            $gioBatDau = $_POST['txtGioBatDau'];
            $gioKetThuc = $_POST['txtGioKetThuc'];

            // Kiểm tra nếu mã loại sân không hợp lệ
            if (!isset($bangGia[$maloaisan])) {
                echo "<p style='color: red; text-align: center;'>Mã loại sân không hợp lệ!</p>";
                exit();
            }

            // Kiểm tra giờ bắt đầu phải nhỏ hơn giờ kết thúc
            if (strtotime($gioBatDau) >= strtotime($gioKetThuc)) {
                echo "<p style='color: red; text-align: center;'>Giờ bắt đầu phải nhỏ hơn giờ kết thúc!</p>";
                exit();
            }

            // Kiểm tra trùng giờ
            $kiemtratrung = $p->getKiemTraTrungGio($ngayDat);
            $isTrung = false;

            if ($kiemtratrung) {
                while ($r = $kiemtratrung->fetch_assoc()) {
                    $rgiobatdau = $r['GioBatDau'];
                    $rgioketthuc = $r['GioKetThuc'];
                    $rtrangthai = $r['TrangThai'];

                    if ((strtotime($gioBatDau) < strtotime($rgioketthuc) && strtotime($gioKetThuc) > strtotime($rgiobatdau)) && $rtrangthai === "Đã đặt") {
                        $isTrung = true;
                        break;
                    }
                }
            }

            if ($isTrung) {
                echo "<p style='color: red; text-align: center;'>Khoảng thời gian đã có người đặt!</p>";
            } else {
                // Tính tổng tiền
                $giaSang = $bangGia[$maloaisan]['sang'];
                $giaChieu = $bangGia[$maloaisan]['chieu'];

                $thoiGianBatDau = strtotime($gioBatDau);
                $thoiGianKetThuc = strtotime($gioKetThuc);
                $tongTien = 0;

                while ($thoiGianBatDau < $thoiGianKetThuc) {
                    $gioHienTai = (int)date("H", $thoiGianBatDau);
                    if ($gioHienTai >= 6 && $gioHienTai < 12) {
                        $tongTien += $giaSang / 60; // Giá mỗi phút
                    } elseif ($gioHienTai >= 13 && $gioHienTai < 23) {
                        $tongTien += $giaChieu / 60; // Giá mỗi phút
                    }
                    $thoiGianBatDau += 60; // Cộng thêm 1 phút
                }

                // Hiển thị thông tin đặt sân
                echo "<div class='info-box'><form method='post'>";
                echo "<h3>Thông tin đặt sân:</h3>";
                echo "<p><strong>Số điện thoại:</strong> {$_POST['txtSDT']}</p>";
                echo "<p><strong>Ngày đặt:</strong> $ngayDat</p>";
                echo "<p><strong>Giờ bắt đầu:</strong> $gioBatDau</p>";
                echo "<p><strong>Giờ kết thúc:</strong> $gioKetThuc</p>";
                echo "<p><strong>Tổng tiền:</strong> " . number_format($tongTien, 0, ',', '.') . " VNĐ</p>";
                echo "<button type='submit' name='subds' class='btn-view'>Xác nhận đặt sân</button>";
                echo "</form></div>";

                $_SESSION['txtSDT'] = $_POST['txtSDT'];
                $_SESSION['txtNgayDat'] = $ngayDat;
                $_SESSION['txtGioBatDau'] = $gioBatDau;
                $_SESSION['txtGioKetThuc'] = $gioKetThuc;
                $_SESSION['total'] = $tongTien;
            }
        } 
    }

    // Xử lý xác nhận đặt sân
    if (isset($_POST['subds'])) {
        $p = new cDonDatSan();
        $result = $p->getinsertDatSan($masan, $_SESSION['MaKH'], $_SESSION['txtNgayDat'], $_SESSION['txtGioBatDau'] , $_SESSION['txtGioKetThuc'] , $_SESSION['total'],$_SESSION['TenKH']);
        if ($result) {
            echo "<script>alert('Đặt sân thành công!');</script>";
            header("refresh: 0; url='../admin.php?dondat'");
             exit();
        } else {
            echo "<p style='color: red; text-align: center;'>Đặt sân thất bại, vui lòng thử lại!</p>";
        }
    }
    ?>
</div>
</body>
</html>
