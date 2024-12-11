<?php
include_once("Controller/cDonDatSan.php");
include_once("Controller/cSan.php");


$psan = new cSan();
$controller = new cDonDatSan();

// Fetch booking details if 'id' is provided
if (isset($_GET["id"])) {
    $maDonDatSan = intval($_GET["id"]); // Sanitize input
    $donDatSan = mysqli_fetch_assoc($controller->GetDonDatSanById($maDonDatSan));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnSave"])) {
    $maDonDatSan = intval($_POST["maDonDatSan"]);
    $maSanBong = intval($_POST['maSan']);
    $maKhachHang = intval($_POST['maKhach']);
    $ngayNhanSan = htmlspecialchars($_POST["ngayDat"]);
    $gioBatDau = htmlspecialchars($_POST["gioBatDau"]);
    $gioKetThuc = htmlspecialchars($_POST["gioKetThuc"]);
    $trangThai = htmlspecialchars($_POST["trangThai"]);
    $tongTien = str_replace(" VNĐ", "", str_replace(",", "", $_POST["tongTien"]));
    $tongTien = floatval($tongTien);

    // Validate and process working hours
    $thoigian = mysqli_fetch_assoc($psan->Get1San($maSanBong));
    $thoiGianHoatDong = $thoigian['ThoiGianHoatDong'];
    $catThoiGianHoatDong = explode(" - ", $thoiGianHoatDong);
    $gioMoCua = trim($catThoiGianHoatDong[0]);
    $gioDongCua = trim($catThoiGianHoatDong[1]);



    if (strtotime($gioBatDau) < strtotime($gioMoCua) || strtotime($gioKetThuc) > strtotime($gioDongCua)) {
        echo "<script>
                alert('Thời gian đặt sân phải nằm trong khung giờ hoạt động: $gioMoCua - $gioDongCua!');
                window.history.back();
              </script>";
        exit();
    }

    if (strtotime($gioBatDau) >= strtotime($gioKetThuc)) {
        echo "<script>
                alert('Giờ bắt đầu phải sớm hơn giờ kết thúc!');
                window.history.back();
              </script>";
        exit();
    }

    // Update booking
    $result = $controller->UpDonDatSan(
        $maDonDatSan,
        $maSanBong,
        $maKhachHang,
        $ngayNhanSan,
        $gioBatDau,
        $gioKetThuc,
        $tongTien,
        htmlspecialchars($_POST['tenKH'])
    );

    if ($result) {
        echo "<script>
                alert('Sửa đơn đặt sân thành công!');
                window.location.href = 'admin.php?dondat';
              </script>";
              
    } else {
        echo "<script>
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                window.history.back();
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Đơn Đặt Sân</title>
    <style>
        /* Your provided CSS styles */
    </style>
</head>
<body>
    <h1>Sửa Đơn Đặt Sân</h1>

    <form method="POST" action="#">
        <input type="hidden" name="maDonDatSan" value="<?= $donDatSan['MaDonDatSan'] ?>">
        <input type="hidden" name="maKhach" id="maKhach" value="<?= $donDatSan['MaKhachHang'] ?>">

        <label for="maSan">Mã sân:</label>
        <select id="maSan" name="maSan" required>
        <?php
            $kqnv = $psan->getAllSanBongByMaChuSan($_SESSION['MaChuSan']);
            
            if ($kqnv) {
                while ($row = mysqli_fetch_assoc($kqnv)) {
                    $selected = ($row['MaSanBong'] == $donDatSan['MaSanBong']) ? "selected" : "";
                    echo "<option value='{$row['MaSanBong']}' $selected>{$row['TenSanBong']}</option>";
                }
            } else {
                echo "<option value=''>Không có sân bóng nào</option>";
            }
        ?>
        </select>

        <label for="tenKH">Tên khách hàng:</label>
        <input type="text" id="tenKH" name="tenKH" value="<?= htmlspecialchars($donDatSan['TenKhachHang']) ?>" required>

        <label for="ngayDat">Ngày đặt:</label>
        <input type="date" id="ngayDat" name="ngayDat" value="<?= htmlspecialchars($donDatSan['NgayNhanSan']) ?>" required>

        <label for="gioBatDau">Giờ bắt đầu:</label>
        <input type="time" id="gioBatDau" name="gioBatDau" value="<?= htmlspecialchars($donDatSan['ThoiGianBatDau']) ?>" required>

        <label for="gioKetThuc">Giờ kết thúc:</label>
        <input type="time" id="gioKetThuc" name="gioKetThuc" value="<?= htmlspecialchars($donDatSan['ThoiGianKetThuc']) ?>" required>

        <label for="trangThai">Trạng thái:</label>
        <select id="trangThai" name="trangThai" required>
            <option value="Chờ duyệt" <?= $donDatSan['TrangThai'] == 'Chờ duyệt' ? 'selected' : '' ?>>Chờ duyệt</option>
            <option value="Đã đặt" <?= $donDatSan['TrangThai'] == 'Đã đặt' ? 'selected' : '' ?>>Đã đặt</option>
            <option value="Hủy" <?= $donDatSan['TrangThai'] == 'Hủy' ? 'selected' : '' ?>>Hủy</option>
        </select>

        <label for="tongTien">Tổng tiền:</label>
        <input type="text" id="tongTien" name="tongTien" value="<?= number_format($donDatSan['TongTien'], 0, ',', '.') ?> VNĐ" readonly>

        <button type="submit" name="btnSave">Lưu</button>
        <a href="admin.php?dondat">Quay lại</a>
    </form>

    <script>
        const bangGia = {
            1: { 'sang': 100000, 'chieu': 120000 },
            2: { 'sang': 150000, 'chieu': 170000 },
            3: { 'sang': 200000, 'chieu': 250000 }
        };

        function tinhTongTien() {
            const gioBatDau = document.getElementById("gioBatDau").value;
            const gioKetThuc = document.getElementById("gioKetThuc").value;

            if (gioBatDau && gioKetThuc) {
                const thoiGianBatDau = new Date(`2000-01-01T${gioBatDau}`);
                const thoiGianKetThuc = new Date(`2000-01-01T${gioKetThuc}`);
                let tongTien = 0;

                while (thoiGianBatDau < thoiGianKetThuc) {
                    const gio = thoiGianBatDau.getHours();
                    if (gio >= 6 && gio < 12) {
                        tongTien += bangGia[1].sang / 60;
                    } else if (gio >= 13 && gio < 23) {
                        tongTien += bangGia[1].chieu / 60;
                    }
                    thoiGianBatDau.setMinutes(thoiGianBatDau.getMinutes() + 1);
                }

                document.getElementById("tongTien").value = Math.round(tongTien).toLocaleString() + ' VNĐ';
            }
        }

        document.getElementById("gioBatDau").addEventListener("input", tinhTongTien);
        document.getElementById("gioKetThuc").addEventListener("input", tinhTongTien);

        window.onload = function() {
            tinhTongTien();
        };
    </script>
</body>
</html>




<style>
        /* Tổng thể form */
form {
    width: 60%;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Tiêu đề */
form h1 {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Các label */
label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    color: #555;
}

/* Các input và select */
input[type="text"],
input[type="date"],
input[type="time"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

/* Các input khi hover */
input[type="text"]:hover,
input[type="date"]:hover,
input[type="time"]:hover,
select:hover {
    border-color: #007bff;
}

/* Nút submit */
button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #218838;
}

/* Liên kết quay lại */
a {
    display: block;
    text-align: center;
    margin-top: 0px;
    font-size: 16px;
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Thông báo lỗi hoặc thành công */
p {
    text-align: center;
    font-size: 16px;
    color: #d9534f;
}

/* Responsive */
@media (max-width: 768px) {
    form {
        width: 90%;
    }

    button[type="submit"] {
        font-size: 16px;
    }
}
    </style>    