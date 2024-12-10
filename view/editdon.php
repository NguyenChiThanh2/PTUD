<?php

include_once("Controller/cDonDatSan.php");

$controller = new cDonDatSan();

// Lấy thông tin chi tiết đơn đặt sân
if (isset($_GET["id"])) {
    $maDonDatSan = $_GET["id"];
    $donDatSan = mysqli_fetch_assoc($controller->GetDonDatSanById($maDonDatSan)); 
}

// Xử lý form khi người dùng nhấn "Lưu"
if (isset($_POST["btnSave"])) {
    $maDonDatSan = $_POST["maDonDatSan"];
    $maKH = $_POST["tenKH"];
    $ngayNhanSan = $_POST["ngayDat"];
    $gioBatDau = $_POST["gioBatDau"];
    $gioKetThuc = $_POST["gioKetThuc"]; 
    $tongTien = $_POST["tongTien"];
    $trangThai = $_POST["trangThai"];
    $maSanBong =$_POST['maSan'];
    $maKhachHang = $_POST['maKhach'];
    $tenKhachHang =$_POST['tenKH'];

    if (strtotime($gioBatDau) >= strtotime($gioKetThuc)) {
        echo "<p style='color: red; text-align: center;'>Giờ bắt đầu phải nhỏ hơn giờ kết thúc!</p>";
        exit();
    }

  

$tongTien = $_POST["tongTien"]; // Hoặc bạn tính toán lại nếu cần
$cattien = explode(" ", $tongTien);
$result = $controller->UpDonDatSan($maDonDatSan, $maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien, $tenKhachHang);

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
    margin-top: 15px;
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
</head>
<body>
    <h1>Sửa Đơn Đặt Sân</h1>

    <form method="POST" action="#">
        <input type="hidden" name="maDonDatSan" value="<?= $donDatSan['MaDonDatSan'] ?>">
        <input type="hidden" name="maKhach" id="maKhach" value="<?= $donDatSan['MaKhachHang'] ?>">
         <label for="maSan">Mã sân:</label>
    <select id="maSan" name="maSan" required>
        <option value="1" <?= $donDatSan['MaDonDatSan'] == 1 ? 'selected' : '' ?>>Sân 1</option>
        <option value="2" <?= $donDatSan['MaDonDatSan'] == 2 ? 'selected' : '' ?>>Sân 2</option>
        <option value="3" <?= $donDatSan['MaDonDatSan'] == 3 ? 'selected' : '' ?>>Sân 3</option>
    </select>

        <label for="tenKH">Tên khách hàng:</label>
        <input type="text" id="tenKH" name="tenKH" value="<?= $donDatSan['TenKhachHang'] ?>" required>

        <label for="ngayDat">Ngày đặt:</label>
        <input type="date" id="ngayDat" name="ngayDat" value="<?= $donDatSan['NgayNhanSan'] ?>" required>

        <label for="gioBatDau">Giờ bắt đầu:</label>
        <input type="time" id="gioBatDau" name="gioBatDau" value="<?= $donDatSan['ThoiGianBatDau'] ?>" required>

        <label for="gioKetThuc">Giờ kết thúc:</label>
        <input type="time" id="gioKetThuc" name="gioKetThuc" value="<?= $donDatSan['ThoiGianKetThuc'] ?>" required>

        <label for="trangThai">Trạng thái:</label>
        <select id="trangThai" name="trangThai" required>
            <option value="Chờ duyệt" <?= $donDatSan['TrangThai'] == 'Chờ duyệt' ? 'selected' : '' ?>>Chờ duyệt</option>
            <option value="Đã đặt" <?= $donDatSan['TrangThai'] == 'Đã đặt' ? 'selected' : '' ?>>Đã đặt</option>
            <option value="Hủy" <?= $donDatSan['TrangThai'] == 'Hủy' ? 'selected' : '' ?>>Hủy</option>
        </select>
           <input type="hidden" id="tongTienBanDau" value="<?= $donDatSan['TongTien'] ?>">

        <label for="tongTien">Tổng tiền:</label>
        <input type="text" id="tongTien" name="tongTien" value="<?= $donDatSan['TongTien'] ?>" readonly>

        <button type="submit" name="btnSave">Lưu</button>
        <a href="admin.php?dondat">Quay lại</a>
    </form>

    <script>
    // Bảng giá
    var bangGia = {
        1: { 'sang': 100000, 'chieu': 120000 },
        2: { 'sang': 150000, 'chieu': 170000 },
        3: { 'sang': 200000, 'chieu': 250000 }
    };

    function calculatePrice() {
    // Lấy giá trị từ form
    var maSan = document.getElementById("maSan").value; // Mã sân
    var gioBatDau = document.getElementById("gioBatDau").value; // Giờ bắt đầu
    var gioKetThuc = document.getElementById("gioKetThuc").value; // Giờ kết thúc

    if (!maSan || !gioBatDau || !gioKetThuc) {
        alert("Vui lòng chọn mã sân và nhập giờ đầy đủ!");
        return;
    }

    var thoiGianBatDau = new Date("1970-01-01T" + gioBatDau + ":00");
    var thoiGianKetThuc = new Date("1970-01-01T" + gioKetThuc + ":00");

    if (thoiGianBatDau >= thoiGianKetThuc) {
        alert("Giờ bắt đầu phải nhỏ hơn giờ kết thúc!");
        return;
    }

    var tongTien = 0;

    // Tách thời gian ra thành các khung giờ
    while (thoiGianBatDau < thoiGianKetThuc) {
        var gioHienTai = thoiGianBatDau.getHours();
        var phutHienTai = thoiGianBatDau.getMinutes();

        // Khung giờ sáng (6:00 - 12:00)
        if (gioHienTai >= 6 && gioHienTai < 12) {
            tongTien += bangGia[maSan]['sang'] / 60; // Giá mỗi phút
        }
        // Khung giờ chiều (13:00 - 23:00)
        else if (gioHienTai >= 13 && gioHienTai < 23) {
            tongTien += bangGia[maSan]['chieu'] / 60;
        }
        // Tăng thêm 1 phút
        thoiGianBatDau.setMinutes(phutHienTai + 1);
    }

    // Làm tròn số tiền
    tongTien = Math.round(tongTien);

    // Hiển thị tổng tiền (nếu người dùng thay đổi giờ hoặc sân)
    document.getElementById("tongTien").value = tongTien + " VNĐ";
}


    // Gọi hàm tính giá khi thay đổi giờ hoặc sân
    document.getElementById("gioBatDau").addEventListener("change", calculatePrice);
    document.getElementById("gioKetThuc").addEventListener("change", calculatePrice);
    document.getElementById("maSan").addEventListener("change", calculatePrice);

    // Giữ nguyên giá tiền ban đầu khi tải trang
    window.onload = function () {
        var tongTienBanDau = document.getElementById("tongTienBanDau").value;
        document.getElementById("tongTien").value = tongTienBanDau;
    };
</script>
</body>
</html>