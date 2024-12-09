<?php
include_once("controller/ckh_DonDatSan.php");

if(isset($_GET['id'])) {
    $maDonDatSan = intval($_GET['id']);
    $p = new cDonDatSan();
    $result = $p->huyDonDatSan($maDonDatSan);
    if($result) {
        echo "<script>alert('Đã hủy đơn đặt sân thành công!'); window.location.href='San.php?lichsudatsan';</script>";
    } else {
        echo "<script>alert('Không thể hủy đơn đặt sân. Vui lòng thử lại!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy mã đơn đặt sân!'); window.history.back();</script>";
}
?>
