<?php
include_once("mKetNoi.php");

class mDonDatSan {
    // Lấy tất cả các đơn đặt sân
    public function GetALLDonDatSan() {
        $p = new mKetNoi();
        $con = $p->moKetNoi();

        if (!$con) {
            return false;  // Return false if connection fails
        }

        $sql = "SELECT * FROM DonDatSan1 dds join SanBong sb on dds.MaSanBong = sb.MaSanBong"; // Query to select all bookings
        $result = $con->query($sql); // Execute the query

        $p->dongKetNoi($con); // Close the connection

        return $result; // Return the result
    }

    // Thêm đơn đặt sân
    public function ThemDonDatSan($tenKH, $sdt, $ngayDat, $gioBatDau, $gioKetThuc, $tenSanBong) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
    
        if (!$con) {
            return false;
        }
    
        // Tìm mã khách hàng theo số điện thoại
        $sqlKH = "SELECT MaKhachHang FROM KhachHang WHERE SDT = ?";
        $stmtKH = $con->prepare($sqlKH);
        $stmtKH->bind_param("s", $sdt);
        $stmtKH->execute();
        $resultKH = $stmtKH->get_result();
    
        // Nếu không tìm thấy khách hàng, thêm mới
        if ($resultKH->num_rows == 0) {
            $sqlAddKH = "INSERT INTO KhachHang (TenKhachHang, SDT) VALUES (?, ?)";
            $stmtAddKH = $con->prepare($sqlAddKH);
            $stmtAddKH->bind_param("ss", $tenKH, $sdt);
            $stmtAddKH->execute();
            $maKhachHang = $con->insert_id; // Lấy mã khách hàng vừa thêm
        } else {
            $rowKH = $resultKH->fetch_assoc();
            $maKhachHang = $rowKH['MaKhachHang'];
        }
    
        // Tìm mã sân bóng theo tên sân
        $sqlSanBong = "SELECT MaSanBong FROM SanBong WHERE TenSanBong = ?";
        $stmtSanBong = $con->prepare($sqlSanBong);
        $stmtSanBong->bind_param("s", $tenSanBong);
        $stmtSanBong->execute();
        $resultSanBong = $stmtSanBong->get_result();
    
        // Nếu không tìm thấy sân bóng, trả về false
        if ($resultSanBong->num_rows == 0) {
            $p->dongKetNoi($con);
            return false; // Sân bóng không tồn tại
        }
    
        // Lấy mã sân bóng
        $rowSanBong = $resultSanBong->fetch_assoc();
        $maSanBong = $rowSanBong['MaSanBong'];
    
        // Tính tổng tiền (giả sử giá là cố định, bạn có thể thêm logic tính giá động ở đây)
        $giaThue = 120000; // Ví dụ giá thuê cố định
        $tongTien = $giaThue;
    
        // Thêm đơn đặt sân
        $sql = "INSERT INTO DonDatSan1 (MaKhachHang, TenKhachHang, MaSanBong, NgayDat, GioBatDau, GioKetThuc, TongTien, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Đã đặt sân')";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iissss", $maKhachHang, $tenKH, $maSanBong, $ngayDat, $gioBatDau, $gioKetThuc, $tongTien);
    
        $result = $stmt->execute();
    
        $p->dongKetNoi($con);
    
        return $result; // Trả về kết quả
    }

    // Phê duyệt đơn đặt sân
    public function PheDuyetDon($maDonDatSan) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();

        if (!$con) {
            return false; // Nếu không kết nối được cơ sở dữ liệu
        }

        // Cập nhật trạng thái đơn đặt sân thành "Đã phê duyệt"
        $sql = "UPDATE DonDatSan1 SET TrangThai = 'Đã phê duyệt' WHERE MaDonDatSan = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $maDonDatSan);

        $result = $stmt->execute();

        $p->dongKetNoi($con);

        return $result; // Trả về kết quả thực thi câu lệnh
    }

    public function insertDatSan($mkh,$tkh,$ms,$nd, $gbd,$gkt,$tt) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        $trangthai = "Chờ duyệt";
        // Cập nhật trạng thái đơn đặt sân thành "Đã phê duyệt"
        $sql = "INSERT INTO dondatsan1(MaKhachHang, TenKhachHang, MaSanBong, NgayDat, GioBatDau, GioKetThuc, TongTien, TrangThai) 
                VALUES ('$mkh','$tkh','$ms','$nd','$gbd','$gkt','$tt','$trangthai')";
        $kq = $con->query($sql);
        $p->dongKetNoi($con);
        if($kq){
            return $kq;
        }else{
            return false;
        }
    }

    public function KiemTraSDT($sdt) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        // Cập nhật trạng thái đơn đặt sân thành "Đã phê duyệt"
        $sql = "SELECT * FROM khachhang where SDT = '$sdt'";
        $kq = $con->query($sql);
        $p->dongKetNoi($con);
        if($kq){
            return $kq;
        }else{
            return false;
        }
    }

    public function getinsertDatSan($maKH, $tenKH, $idSan, $ngayDat, $gioBatDau, $gioKetThuc, $tongTien) {
        $db = new Database();
        $sql = "INSERT INTO dondatsan1 (maKH, tenKH, idSan, ngayDat, gioBatDau, gioKetThuc, tongTien)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$maKH, $tenKH, $idSan, $ngayDat, $gioBatDau, $gioKetThuc, $tongTien];
        return $db->execute($sql, $params); // Trả về true nếu thành công
    }
    

    public function InsertDonDatSan($maSan, $tenKH, $sdt, $ngayDat, $gioBatDau, $gioKetThuc) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
    
        // Thêm đơn đặt sân vào cơ sở dữ liệu
        $sql = "INSERT INTO dondatsan1 (MaSan, TenKhachHang, SDT, NgayDat, GioBatDau, GioKetThuc, TrangThai) 
                VALUES ('$maSan', '$tenKH', '$sdt', '$ngayDat', '$gioBatDau', '$gioKetThuc', 'Chờ phê duyệt')";
    
        $kq = $con->query($sql);
        $p->dongKetNoi($con);
    
        return $kq; // Trả về kết quả
    }

    public function KiemTraTrungGio($ngayDat) {
        $p = new mKetNoi(); // Kết nối cơ sở dữ liệu
        $con = $p->moKetNoi(); // Mở kết nối
        // Truy vấn kiểm tra trùng giờ đặt sân
        $sql = "SELECT * FROM dondatsan1 
                WHERE NgayDat = '$ngayDat'";
        $kq = $con->query($sql); // Thực thi truy vấn
        $p->dongKetNoi($con); // Đóng kết nối
        if ($kq) {
            return $kq; // Nếu có trùng giờ, trả về kết quả
        } else {
            return false; // Nếu không trùng giờ
        }
    }

    public function updateTrangThaiDon($madon) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        $sql = "UPDATE dondatsan1 SET TrangThai='Đã đặt' WHERE MaDonDatSan='$madon'";
        $kq = $con->query($sql); // Thực thi truy vấn
        $p->dongKetNoi($con); // Đóng kết nối
        if ($kq) {
            return $kq; // Nếu có trùng giờ, trả về kết quả
        } else {
            return false; // Nếu không trùng giờ
        }
    }
    

    public function getThongTinVaCapNhatTrangThaiDon($maDonDatSan) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
    
        // Truy vấn lấy thông tin chi tiết của đơn đặt sân
        $sqlThongTin = "SELECT kh.Email, kh.TenKhachHang, sb.TenSanBong, d.NgayDat, d.GioBatDau, d.GioKetThuc, d.TongTien 
                        FROM dondatsan1 d
                        INNER JOIN khachhang kh ON d.MaKhachHang = kh.MaKhachHang
                        INNER JOIN sanbong sb ON d.MaSanBong = sb.MaSanBong
                        WHERE d.MaDonDatSan = '$maDonDatSan'";
        $resultThongTin = mysqli_query($con, $sqlThongTin);
    
        if ($resultThongTin && mysqli_num_rows($resultThongTin) > 0) {
            $thongTinDon = mysqli_fetch_assoc($resultThongTin);
    
            // Cập nhật trạng thái đơn đặt sân
            $sqlCapNhat = "UPDATE dondatsan1 SET TrangThai = 'Đã đặt' WHERE MaDonDatSan = '$maDonDatSan'";
            $resultCapNhat = mysqli_query($con, $sqlCapNhat);
    
            if ($resultCapNhat && mysqli_affected_rows($con) > 0) {
                $p->dongKetNoi($con);
                return $thongTinDon; // Trả về thông tin đơn đặt sân
            }
        }
    
        $p->dongKetNoi($con);
        return false; // Trả về false nếu thất bại
    }
    
    
    public function deletedatsan($maDonDatSan) {
        $p = new mKetNoi();
        $truyvan = "DELETE FROM dondatsan1 WHERE MaDonDatSan = $maDonDatSan"; // Câu truy vấn SQL
        $con = $p->moKetNoi(); // Mở kết nối
        $kq = mysqli_query($con, $truyvan); // Thực hiện truy vấn
        $p->dongKetNoi($con); // Đóng kết nối
        return $kq; // Trả về kết quả (true/false)
    }

    
    public function GetDonDatSanById($maDonDatSan) {
        $p = new mKetNoi();
        $conn = $p->moKetNoi();
        $query = "SELECT * FROM DonDatSan1 dds join KhachHang kh on dds.MaKhachHang = kh.MaKhachHang WHERE MaDonDatSan = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $maDonDatSan);
            $stmt->execute();
            return $stmt->get_result(); 
        }
        return false;
    }

    // Cập nhật đơn đặt sân
    // public function SuaDonDatSan($maDonDatSan, $tenKH, $ngayDat, $gioBatDau, $gioKetThuc, $trangThai) {
    //     $p = new mKetNoi();
    //     $conn = $p->moKetNoi();
    //     $query = "UPDATE DonDatSan1 SET 
    //               TenKhachHang = ?, 
    //               NgayDat = ?, 
    //               GioBatDau = ?, 
    //               GioKetThuc = ?,
    //               TrangThai = ? 
    //               WHERE MaDonDatSan = ?";

    //     if ($stmt = $conn->prepare($query)) {
    //         $stmt->bind_param("sssssi", $tenKH, $ngayDat, $gioBatDau, $gioKetThuc, $trangThai, $maDonDatSan);
    //         return $stmt->execute(); 
    //     }
    //     return false;
    // }

    public function SuaDonDatSan($maDonDatSan, $tenKH, $ngayDat, $gioBatDau, $gioKetThuc, $trangThai, $tongTien) {
        $p = new mKetNoi();
        $conn = $p->moKetNoi();
        $query = "UPDATE dondatsan1 
                  SET MaKhachHang = '$tenKH', 
                      NgayDat = '$ngayDat', 
                      GioBatDau = '$gioBatDau', 
                      GioKetThuc = '$gioKetThuc', 
                      TrangThai = '$trangThai', 
                      TongTien = '$tongTien' 
                  WHERE MaDonDatSan ='$maDonDatSan'";
    $stmt = $conn->query($query);
    if($stmt){
        return $stmt;
        // $stmt->bind_param("ssssssi", $tenKH, $ngayDat, $gioBatDau, $gioKetThuc, $trangThai, $tongTien, $maDonDatSan);
        // return $stmt->execute();
    } else{
        return false;
    }
    
}
    
}
   
        
    
?>