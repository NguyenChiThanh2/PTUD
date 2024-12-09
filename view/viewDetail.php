<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("controller/ckh_DonDatSan.php");
$maDonDatSan = intval($_GET['id']);
$p = new cDonDatSan();
$kq = $p->getALLChiTietDonByMaKhachHang($maDonDatSan);

if ($kq && mysqli_num_rows($kq) > 0) {
    
    echo "<div class='table-container'>";
    echo "<table class='order-table'>";
    echo "<thead>
            <tr>
                <h1>Chi tiết đơn đặt sân</h1>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<tr>";
        echo "<td><strong>Mã đơn</strong></td>";
        echo "<td>" . $r["MaDonDatSan"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Tên khách hàng</strong></td>";
        echo "<td>" . $r["TenKhachHang"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Số điện thoại</strong></td>";
        echo "<td>" . $r["SDT"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Email</strong></td>";
        echo "<td>" . $r["Email"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Tên sân</strong></td>";
        echo "<td>" . $r["TenSanBong"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Địa chỉ sân</strong></td>";
        echo "<td>" . $r["DiaChi"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Ngày nhận sân</strong></td>";
        echo "<td>" . $r["NgayNhanSan"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Thời gian bắt đầu</strong></td>";
        echo "<td>" . $r["ThoiGianBatDau"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Thời gian kết thúc</strong></td>";
        echo "<td>" . $r["ThoiGianKetThuc"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Tổng tiền</strong></td>";
        echo "<td>" . number_format($r["TongTien"], 0, ',', '.') . " VNĐ</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Trạng thái</strong></td>";
        echo "<td>" . $r["TrangThai"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<div class='back-button-container'>
    <a href='javascript:history.back()' class='back-button'>Quay lại</a>
</div>
";
} else {
    echo "Không có dữ liệu đơn đặt sân cho khách hàng này.";
}
?>

<link rel="stylesheet" href="css/css_viewDetail.css">