<?php
include_once("../model/mkh_DatSan.php");

class cDatSan {
    private $mDatSan;

    public function __construct() {
        $this->mDatSan = new mDatSan();
    }

    public function kiemTraLichTrung($maSanBong, $ngayNhanSan, $gioBatDau, $gioKetThuc) {
        return $this->mDatSan->kiemTraTrungLich($maSanBong, $ngayNhanSan, $gioBatDau, $gioKetThuc);
    }

    public function datSan($maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien) {
        $ketQua = $this->mDatSan->datSan($maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien);
        return $ketQua;
    }

    public function layChiTietDonDatSan($maDonDatSan) {
        return $this->mDatSan->getChiTietDonDatSan($maDonDatSan);
    }
}
?>

