<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("controller/cDonDatSan.php");

// Kiểm tra sự tồn tại của tham số 'id' trong URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $maDonDatSan = intval($_GET['id']);
} else {
    echo "Không có mã đơn đặt sân!";
    exit();
}

$p = new cDonDatSan();
$kq = $p->getALLChiTietDonByMaDonDatSan($maDonDatSan);

if ($kq && mysqli_num_rows($kq) > 0) {
    echo "<div class='table-container'>";
    echo "<table class='order-table'>";
    echo "<thead>
            <tr>
                <h1>Chi tiết đơn đặt sân</h1>
            </tr>
          </thead>";
    echo "<tbody>";
    
    // Duyệt qua kết quả và hiển thị chi tiết
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<tr><td><strong>Mã đơn</strong></td><td>" . $r["MaDonDatSan"] . "</td></tr>";
        echo "<tr><td><strong>Tên khách hàng</strong></td><td>" . $r["TenKhachHang"] . "</td></tr>";
        echo "<tr><td><strong>Số điện thoại</strong></td><td>" . $r["SDT"] . "</td></tr>";
        echo "<tr><td><strong>Email</strong></td><td>" . $r["Email"] . "</td></tr>";
        echo "<tr><td><strong>Tên sân</strong></td><td>" . $r["TenSanBong"] . "</td></tr>";
        echo "<tr><td><strong>Địa chỉ sân</strong></td><td>" . $r["DiaChi"] . "</td></tr>";
        echo "<tr><td><strong>Ngày nhận sân</strong></td><td>" . $r["NgayNhanSan"] . "</td></tr>";
        echo "<tr><td><strong>Thời gian bắt đầu</strong></td><td>" . $r["ThoiGianBatDau"] . "</td></tr>";
        echo "<tr><td><strong>Thời gian kết thúc</strong></td><td>" . $r["ThoiGianKetThuc"] . "</td></tr>";
        echo "<tr><td><strong>Tổng tiền</strong></td><td>" . number_format($r["TongTien"], 0, ',', '.') . " VNĐ</td></tr>";
        echo "<tr><td><strong>Trạng thái</strong></td><td>" . $r["TrangThai"] . "</td></tr>";
    }
    
    echo "</tbody></table></div>";
    echo "<div class='back-button-container'><a href='javascript:history.back()' class='back-button'>Quay lại</a></div>";
} else {
    echo "Không có dữ liệu đơn đặt sân cho khách hàng này.";
}
?>
    <link rel="stylesheet" href="css/css_viewDetail.css">
