<?php
include_once("mKetNoi.php");

class mDatSan {
    private $ketNoi;

    public function __construct() {
        $this->ketNoi = new mKetNoi();
    }

    public function kiemTraNgayNhanSan($ngayNhanSan) {
        $today = date("Y-m-d"); 
        if ($ngayNhanSan < $today) {
            return false; 
        }
        return true; 
    }

    public function getTenKhachHang($maKhachHang) {
        $con = $this->ketNoi->moKetNoi();
        $sql = "SELECT TenKhachHang FROM khachhang WHERE MaKhachHang = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $maKhachHang);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $this->ketNoi->dongKetNoi($con);
        return $row ? $row['TenKhachHang'] : null;
    }

    public function datSan($maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien) {
        $con = $this->ketNoi->moKetNoi();

        // Thêm log để debug
        error_log("Debug: maSanBong=$maSanBong, maKhachHang=$maKhachHang, ngayNhanSan=$ngayNhanSan, gioBatDau=$gioBatDau, gioKetThuc=$gioKetThuc, tongTien=$tongTien");

        if (empty($gioBatDau) || empty($gioKetThuc) || empty($tongTien)) {
            error_log("Error: Missing required fields");
            return false;
        }

        if (!$this->kiemTraNgayNhanSan($ngayNhanSan)) {
            return false; 
        }

        $tenKhachHang = $this->getTenKhachHang($maKhachHang);
        if (!$tenKhachHang) {
            return false; // Customer not found
        }

        $ngayDat = date("Y-m-d"); // Current date
        $trangThai = 'Chờ duyệt';
        $sqlDatSan = "INSERT INTO dondatsan1 (MaKhachHang, TenKhachHang, MaSanBong, NgayDat, TongTien, TrangThai) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sqlDatSan);
        $stmt->bind_param("isisds", $maKhachHang, $tenKhachHang, $maSanBong, $ngayDat, $tongTien, $trangThai);
        $ketQua = $stmt->execute();

        if ($ketQua) {
            $maDonDatSan = $stmt->insert_id;
            $sqlChiTiet = "INSERT INTO chitietdondatsan (MaDonDatSan, NgayNhanSan, ThoiGianBatDau, ThoiGianKetThuc, MaSanBong, DonGia) 
                       VALUES (?, ?, ?, ?, ?, ?)";
            $stmtChiTiet = $con->prepare($sqlChiTiet);
            $stmtChiTiet->bind_param("isssid", $maDonDatSan, $ngayNhanSan, $gioBatDau, $gioKetThuc, $maSanBong, $tongTien);
            $ketQuaChiTiet = $stmtChiTiet->execute();
            
            if (!$ketQuaChiTiet) {
                error_log("Error inserting into chitietdondatsan: " . $stmtChiTiet->error);
                // Xóa đơn đặt sân chính nếu không thể thêm chi tiết
                $sqlDeleteOrder = "DELETE FROM dondatsan1 WHERE MaDonDatSan = ?";
                $stmtDeleteOrder = $con->prepare($sqlDeleteOrder);
                $stmtDeleteOrder->bind_param("i", $maDonDatSan);
                $stmtDeleteOrder->execute();
                $ketQua = false;
            }
        } else {
            error_log("Error inserting into dondatsan1: " . $stmt->error);
        }

        $this->ketNoi->dongKetNoi($con);
        return $ketQua;
    }

    public function kiemTraTrungLich($maSanBong, $ngayNhanSan, $gioBatDau, $gioKetThuc) {
        $con = $this->ketNoi->moKetNoi();
        $sql = "SELECT COUNT(*) as count FROM chitietdondatsan
            WHERE MaSanBong = ? AND NgayNhanSan = ? AND
            ((ThoiGianBatDau <= ? AND ThoiGianKetThuc > ?) OR
            (ThoiGianBatDau < ? AND ThoiGianKetThuc >= ?))";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isssss", $maSanBong, $ngayNhanSan, $gioBatDau, $gioBatDau, $gioKetThuc, $gioKetThuc);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $this->ketNoi->dongKetNoi($con);
        return $row['count'] > 0;
    }

    public function getChiTietDonDatSan($maDonDatSan) {
        $con = $this->ketNoi->moKetNoi();
        $sql = "SELECT dondatsan1.*, sanbong.TenSanBong, khachhang.TenKhachHang, khachhang.SDT, khachhang.Email, khachhang.DiaChi
                FROM dondatsan1
                LEFT JOIN sanbong ON dondatsan1.MaSanBong = sanbong.MaSanBong 
                LEFT JOIN khachhang ON dondatsan1.MaKhachHang = khachhang.MaKhachHang
                WHERE dondatsan1.MaDonDatSan = ?";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $maDonDatSan);
        $stmt->execute();
        $result = $stmt->get_result();
        $chiTietDonDatSan = $result->fetch_assoc();
        
        $this->ketNoi->dongKetNoi($con);
        return $chiTietDonDatSan;
    }
}
?>

