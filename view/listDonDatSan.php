<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    include_once("controller/ckh_DonDatSan.php");
    $p = new cDonDatSan();
    $maKhachHang = $_SESSION['dangnhap'];
    $kq = $p->getALLDonByMaKhachHang($maKhachHang);

if($kq && mysqli_num_rows($kq) > 0){
    echo "<div class='header-container'>
            <h1>Lịch sử đặt sân</h1>
        </div>";
    echo "<table>";
    echo "<tr><th>Mã đơn</th><th>Tên khách hàng</th><th>Tên sân</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th>Hành động</th></tr>";
    while($r = mysqli_fetch_assoc($kq)){
        echo "<tr>";
        echo "<td>".$r["MaDonDatSan"]."</td>";
        echo "<td>".$r["TenKhachHang"]."</td>";
        echo "<td>".$r["TenSanBong"]."</td>";
        echo "<td>".$r["NgayDat"]."</td>";
        echo "<td>".number_format($r["TongTien"], 0, ',', '.')." VNĐ</td>";
        echo "<td>".$r["TrangThai"]."</td>";
        echo "<td><a href='?viewDetail&id=".$r["MaDonDatSan"]."'>Chi tiết</a>";
        if($r["TrangThai"] == "Chờ duyệt") {
            echo " | <a href='?huyDonDatSan&id=".$r["MaDonDatSan"]."'
                    onclick='return confirm(\"Bạn có chắc muốn hủy đơn đặt sân này?\")'>Hủy đơn</a>";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu đơn đặt sân cho khách hàng này.";
}
?>