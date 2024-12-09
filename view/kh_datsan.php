<?php
session_start();
include_once("../controller/ckh_DatSan.php");
include_once("../controller/cSan.php");

$idsan = $_GET['idsan'];

$cSan = new cSan();
$sanBong = $cSan->Get1San($idsan);

if ($sanBong && $sanBong->num_rows > 0) {
    $thongTinSan = mysqli_fetch_assoc($sanBong);
} else {
    die("Không tìm thấy thông tin sân bóng hoặc lỗi trong truy vấn.");
}

$bangGiaLoaiSan = [
    1 => ['sang' => 100000, 'chieu' => 120000],
    2 => ['sang' => 150000, 'chieu' => 170000],
    3 => ['sang' => 200000, 'chieu' => 250000]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cDatSan = new cDatSan(); 
    $maSanBong = $_POST['maSanBong'];
    $maKhachHang = $_SESSION['dangnhap'];
    $ngayDat = $_POST['ngayNhanSan'];
    $gioBatDau = $_POST['gioBatDau'];
    $gioKetThuc = $_POST['gioKetThuc'];
    $tongTien = str_replace(['.',',', ' VNĐ'], '', $_POST['tongTien']);

    if ($cDatSan->kiemTraLichTrung($maSanBong, $ngayDat, $gioBatDau, $gioKetThuc)) {
        echo "<script>alert('Lịch đặt sân đã trùng. Vui lòng chọn thời gian khác!');</script>";
    } else {
        $ketQua = $cDatSan->datSan($maSanBong, $maKhachHang, $ngayDat, $gioBatDau, $gioKetThuc, $tongTien);
        if ($ketQua) {
            echo "<script>alert('Đặt sân thành công!');</script>";
            header("refresh: 0; url='../San.php'");
        } else {
            echo "<script>alert('Đặt sân thất bại. Vui lòng thử lại!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt sân</title>
    <link rel="stylesheet" href="../css/css_datsan.css">
</head>
<body>
    <div class="container">
        <button style="width: 50px;" class="close-btn" onclick="window.history.back();">&times;</button>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Đặt sân </h2>
                <form action="" method="post" id="datSanForm">
                    <div class="mb-3">
                        <h3>Tên sân: <?php echo $thongTinSan['TenSanBong']; ?></h3>
                        <input type="hidden" name="maSanBong" id="maSanBong" value="<?php echo $thongTinSan['MaSanBong']; ?>">
                    </div>  
                    <div class="mb-3">
                        <label for="ngayDat">Ngày nhận sân:</label>
                        <input type="date" id="ngayNhanSan" name="ngayNhanSan" required>
                    </div>       
                    <div class="mb-3">
                        <label for="gioBatDau">Thời gian bắt đầu:</label>
                        <input type="time" id="gioBatDau" name="gioBatDau" required>
                    </div>  
                    <div class="mb-3">
                        <label for="gioKetThuc">Thời gian kết thúc:</label>
                        <input type="time" id="gioKetThuc" name="gioKetThuc" required>
                    </div>  
                    <div class="mb-3">
                        <label for="tongTien">Tổng tiền:</label>
                        <input type="text" id="tongTien" name="tongTien" readonly>
                    </div>
                    <button type="submit">Đặt sân</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    const bangGiaLoaiSan = <?php echo json_encode($bangGiaLoaiSan); ?>;
    const maLoaiSan = <?php echo json_encode($thongTinSan['MaLoaiSan']); ?>;

    console.log("Bảng giá loại sân:", bangGiaLoaiSan);
    console.log("Mã loại sân:", maLoaiSan);

    function tinhTongTien() {
        const gioBatDau = document.getElementById("gioBatDau").value;
        const gioKetThuc = document.getElementById("gioKetThuc").value;
        console.log("Tính toán tổng tiền cho:", gioBatDau, "đến", gioKetThuc);

        if (gioBatDau && gioKetThuc) {
            let tongTien = 0;
            let thoiGianBatDau = new Date("2000-01-01T" + gioBatDau);
            const thoiGianKetThuc = new Date("2000-01-01T" + gioKetThuc);

            console.log("Thời gian bắt đầu:", thoiGianBatDau);
            console.log("Thời gian kết thúc:", thoiGianKetThuc);

            if (!bangGiaLoaiSan[maLoaiSan]) {
                console.error("Không tìm thấy bảng giá cho mã loại sân:", maLoaiSan);
                return;
            }

            while (thoiGianBatDau < thoiGianKetThuc) {
                const gioHienTai = thoiGianBatDau.getHours();
                if (gioHienTai >= 6 && gioHienTai < 12) {
                    tongTien += bangGiaLoaiSan[maLoaiSan].sang / 60;
                } else if (gioHienTai >= 13 && gioHienTai < 23) {
                    tongTien += bangGiaLoaiSan[maLoaiSan].chieu / 60;
                }
                thoiGianBatDau.setMinutes(thoiGianBatDau.getMinutes() + 1);
            }

            console.log("Tổng tiền tính được:", tongTien);
            document.getElementById("tongTien").value = Math.round(tongTien).toLocaleString('vi-VN') + ' VNĐ';
        }
    }

    document.getElementById("gioBatDau").addEventListener("input", tinhTongTien);
    document.getElementById("gioKetThuc").addEventListener("input", tinhTongTien);

    window.onload = function() {
        if (document.getElementById("gioBatDau").value && document.getElementById("gioKetThuc").value) {
            tinhTongTien();
        }
    };

    document.getElementById("datSanForm").addEventListener("submit", function (e) {
        const startTime = document.getElementById("gioBatDau").value;
        const endTime = document.getElementById("gioKetThuc").value;
        const ngayDat = document.getElementById("ngayNhanSan").value;
        const today = new Date().toISOString().split('T')[0];

        if (ngayNhanSan < today) {
            e.preventDefault();
            alert("Không thể đặt sân vào ngày đã qua.");
            return;
        }

        if (startTime >= endTime) {
            e.preventDefault();
            alert("Giờ kết thúc phải lớn hơn giờ bắt đầu.");
            return;
        }

        const startHour = parseInt(startTime.split(':')[0]);
        const endHour = parseInt(endTime.split(':')[0]);
        if (startHour < 6 || endHour > 23 || (endHour === 23 && endTime.split(':')[1] !== '00')) {
            e.preventDefault();
            alert("Giờ đặt sân phải nằm trong khoảng 6:00 - 23:00.");
            return;
        }
    });
    </script>
</body>
</html>

