<?php
include_once("Controller/cDonDatSan.php");
include_once("Controller/cSan.php");

$psan = new cSan();
$controller = new cDonDatSan();

// Lấy chi tiết đơn đặt sân nếu 'id' được cung cấp
if (isset($_GET["id"])) {
    $maDonDatSan = intval($_GET["id"]); // Làm sạch dữ liệu đầu vào
    $donDatSan = mysqli_fetch_assoc($controller->GetDonDatSanById($maDonDatSan));
}

// Xử lý khi submit form
if (isset($_POST["btnSave"])) {
    $maDonDatSan = intval($_POST["maDonDatSan"]);
    $maSanBong = intval($_POST['maSan']);
    $maKhachHang = intval($_POST['maKhach']);
    $ngayNhanSan = htmlspecialchars($_POST["ngayDat"]);
    $gioBatDau = htmlspecialchars($_POST["gioBatDau"]);
    $gioKetThuc = htmlspecialchars($_POST["gioKetThuc"]);
    $trangThai = htmlspecialchars($_POST["trangThai"]);
    $tongTien = floatval(str_replace(['.', ' VNĐ'], '', $_POST["tongTien"])); // Loại bỏ định dạng trước khi chuyển đổi
    $tongTien = floatval($_POST["tongTienThuc"]); // Giá trị thực tế từ trường ẩn

    $tenKhachHang = htmlspecialchars($_POST['tenKH']);

    // Kiểm tra thời gian trùng
    $kiemtratrung = $controller->getKiemTraTrungGio($ngayNhanSan);
    $isTrung = false;

    if ($kiemtratrung) {
        while ($r = $kiemtratrung->fetch_assoc()) {
            $thoiGianBatDauDaDat = strtotime($r['ThoiGianBatDau']);
            $thoiGianKetThucDaDat = strtotime($r['ThoiGianKetThuc']);
            $trangThaiS = $r['TrangThai'];
            $maSanBong1 = $r['MaSanBong'];

            if (
                $maSanBong == $maSanBong1 &&
                $trangThaiS === "Đã đặt" &&
                strtotime($gioBatDau) < $thoiGianKetThucDaDat &&
                strtotime($gioKetThuc) > $thoiGianBatDauDaDat
            ) {
                $isTrung = true;
                break;
            }
        }

        if ($isTrung) {
            echo "<script>alert('Đã có người đặt vào khoảng thời gian này, vui lòng chọn thời gian khác!'); window.history.back();</script>";
            exit();
        }
    }

    // Kiểm tra thời gian trong khung giờ hoạt động
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

    // Cập nhật đơn đặt sân
    $result = $controller->UpDonDatSan(
        $maDonDatSan,
        $maSanBong,
        $maKhachHang,
        $ngayNhanSan,
        $gioBatDau,
        $gioKetThuc,
        $tongTien,
        $tenKhachHang
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
       
           // echo "<option value='{$donDatSan['MaSanBong']}' data-loai='{$donDatSan['MaLoaiSan']}' selected>{$donDatSan['TenSanBong']}</option>";

        // Hiển thị sân đã được chọn trước đó (mặc định)
        
        
        // Lấy danh sách sân bóng theo mã chủ sân
        $kqnv = $psan->getAllSanBongByMaChuSan($_SESSION['MaChuSan']);

        if ($kqnv ) {
            while ($row = mysqli_fetch_assoc($kqnv)) {
                $selected = ($row['MaSanBong'] == $maSanBong) ? "selected" : "";
                // Tránh hiển thị lại sân đã đặt trước đó
                if ($row['MaSanBong'] != $donDatSan['MaSanBong']) {
                    echo "<option value='{$row['MaSanBong']}' data-loai='{$row['MaLoaiSan']}'>{$row['TenSanBong']}</option>";
                }
            }
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
        <input type="hidden" id="tongTienThuc" name="tongTienThuc" value="<?= $donDatSan['TongTien'] ?>">


        <button type="submit" name="btnSave">Lưu</button>
        <a href="admin.php?dondat">Quay lại</a>
    </form>

    <script>
        // Mảng giá của các loại sân bóng
const bangGia = {
    1: { sang: 100000, chieu: 120000 },
    2: { sang: 150000, chieu: 170000 },
    3: { sang: 200000, chieu: 250000 },
};

// Hàm tính tổng tiền
// Hàm tính tổng tiền
function tinhTongTien() {
    const gioBatDau = document.getElementById("gioBatDau").value;
    const gioKetThuc = document.getElementById("gioKetThuc").value;
    const selectedOption = document.getElementById("maSan").selectedOptions[0];
    const maLoaiSan = selectedOption.getAttribute("data-loai");

    if (gioBatDau && gioKetThuc && maLoaiSan) {
        const giaSan = bangGia[maLoaiSan];
        const thoiGianBatDau = new Date(`2000-01-01T${gioBatDau}`);
        const thoiGianKetThuc = new Date(`2000-01-01T${gioKetThuc}`);

        if (thoiGianBatDau >= thoiGianKetThuc) {
            alert("Giờ bắt đầu phải sớm hơn giờ kết thúc!");
            document.getElementById("tongTien").value = "0 VNĐ";
            document.getElementById("tongTienThuc").value = 0;
            return;
        }

        let tongTien = 0;
        while (thoiGianBatDau < thoiGianKetThuc) {
            const gio = thoiGianBatDau.getHours();

            if (gio >= 6 && gio < 16) {
                tongTien += giaSan.sang / 60;
            } else if (gio >= 16 && gio < 23) {
                tongTien += giaSan.chieu / 60;
            } else {
                alert("Thời gian đặt sân phải nằm trong khoảng 6:00 - 23:00!");
                document.getElementById("tongTien").value = "0 VNĐ";
                document.getElementById("tongTienThuc").value = 0;
                return;
            }

            thoiGianBatDau.setMinutes(thoiGianBatDau.getMinutes() + 1);
        }

        document.getElementById("tongTien").value = Math.round(tongTien).toLocaleString() + " VNĐ";
        document.getElementById("tongTienThuc").value = Math.round(tongTien);
    } else {
        document.getElementById("tongTien").value = "0 VNĐ";
        document.getElementById("tongTienThuc").value = 0;
    }
}



document.getElementById("maSan").addEventListener("change", tinhTongTien);
document.getElementById("gioBatDau").addEventListener("input", tinhTongTien);
document.getElementById("gioKetThuc").addEventListener("input", tinhTongTien);

document.getElementById("maSan").addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const maLoaiSan = selectedOption.getAttribute("data-loai");
    tinhTongTien();
});

// Giữ giá trị mặc định nếu không thay đổi
window.addEventListener("load", function () {
    tinhTongTien(); // Tính lại tổng tiền theo giá trị mặc định
});


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