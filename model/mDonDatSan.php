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
    public function GetALLDonDatSanByMaChuSan($machusan) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();

        if (!$con) {
            return false;  // Return false if connection fails
        }

        $sql = "SELECT d.MaDonDatSan, d.MaKhachHang, d.TenKhachHang, d.MaSanBong, d.NgayDat,ct.NgayNhanSan, ct.ThoiGianBatDau, ct.ThoiGianKetThuc ,d.GioBatDau, d.GioKetThuc, d.TongTien, d.TrangThai,
                    s.TenSanBong,
                    s.MoTa AS MoTaSanBong,
                    c.TenCoSo,
                    c.DiaChi AS DiaChiCoSo
                FROM 
                    dondatsan1 d
                JOIN 
                    chitietdondatsan ct ON ct.MaDonDatSan  = d.MaDonDatSan
                JOIN 
                    sanbong s ON d.MaSanBong = s.MaSanBong
                JOIN 
                    coso c ON s.MaCoSo = c.MaCoSo
                WHERE 
                    c.MaChuSan = $machusan;
                "; 
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

    public function insertDatSan($maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien,$tenKhachHang) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        error_log("Debug: maSanBong=$maSanBong, maKhachHang=$maKhachHang, ngayNhanSan=$ngayNhanSan, gioBatDau=$gioBatDau, gioKetThuc=$gioKetThuc, tongTien=$tongTien");

        if (empty($gioBatDau) || empty($gioKetThuc) || empty($tongTien)) {
            error_log("Error: Missing required fields");
            return false;
        }
       

       

       

        $ngayDat = date("Y-m-d"); // Current date
        $trangThai = 'Chờ duyệt';
        $sqlDatSan = "INSERT INTO dondatsan1 (MaKhachHang, TenKhachHang, MaSanBong, NgayDat, TongTien, TrangThai) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sqlDatSan);
        $stmt->bind_param("isisds", $maKhachHang, $tenKhachHang, $maSanBong, $ngayDat, $tongTien, $trangThai);
        $ketQua = $stmt->execute();
        echo 'đúng';
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
        $p->dongKetNoi($con);
        return $ketQua;
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

    public function KiemTraTrungGio($ngayNhanSan) {
        $p = new mKetNoi(); // Kết nối cơ sở dữ liệu
        $con = $p->moKetNoi(); // Mở kết nối
        // Truy vấn kiểm tra trùng giờ đặt sân
        $sql = "SELECT dd.MaKhachHang, dd.TrangThai, 
        dd.MaSanBong, ct.ThoiGianBatDau, 
        ct.ThoiGianKetThuc FROM dondatsan1 dd 
        JOIN chitietdondatsan ct 
        ON dd.MaDonDatSan = ct.MaDonDatSan WHERE ct.NgayNhanSan = '$ngayNhanSan';
                ";

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
        // Kết nối đến cơ sở dữ liệu
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        
        // Sử dụng Prepared Statements để tránh SQL Injection
        $sqlThongTin = "SELECT d.MaDonDatSan, d.TrangThai, kh.Email, kh.TenKhachHang, sb.MaSanBong, sb.TenSanBong, d.NgayDat, d.GioBatDau, d.GioKetThuc, d.TongTien, ct.NgayNhanSan, ct.ThoiGianBatDau, ct.ThoiGianKetThuc
                        FROM dondatsan1 d
                        JOIN chitietdondatsan ct ON ct.MaDonDatSan = d.MaDonDatSan
                        INNER JOIN khachhang kh ON d.MaKhachHang = kh.MaKhachHang
                        INNER JOIN sanbong sb ON d.MaSanBong = sb.MaSanBong
                        WHERE d.MaDonDatSan = ?";
        
        // Chuẩn bị câu truy vấn
        $stmt = $con->prepare($sqlThongTin);
        if ($stmt === false) {
            // Xử lý lỗi nếu không thể chuẩn bị câu truy vấn
            die("Error preparing SQL query: " . $con->error);
        }
        
        // Liên kết tham số với câu truy vấn
        $stmt->bind_param("i", $maDonDatSan);  // "i" cho integer (MaDonDatSan là số nguyên)
    
        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Lấy kết quả truy vấn
        $result = $stmt->get_result();
        
        // Đảm bảo rằng kết quả truy vấn không rỗng
        if ($result->num_rows > 0) {
            // Lấy thông tin đơn đặt sân
            $thongTinDon = $result->fetch_assoc();
        } else {
            $thongTinDon = null;  // Nếu không có kết quả, trả về null
        }
    
        // Đóng kết nối
        $stmt->close();
        $p->dongKetNoi($con);
    
        return $thongTinDon; // Trả về kết quả
    }
    
    public function UpdateTrangThaiSan($maDonDatSan,$trangThai) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        
    
            // Cập nhật trạng thái đơn đặt sân
            $sql = "UPDATE dondatsan1 SET TrangThai = N'$trangThai' WHERE MaDonDatSan = '$maDonDatSan'";
            $kq = mysqli_query($con, $sql);
    
            $kq = $con->query($sql); // Thực thi truy vấn
        $p->dongKetNoi($con); // Đóng kết nối
        if ($kq) {
            return $kq; // Nếu có trùng giờ, trả về kết quả
        } else {
            return false; // Nếu không trùng giờ
        }
    }
    
    
    public function updateTrangThaiDatSan($maDonDatSan, $trangThai) {
        $p = new mKetNoi(); // Tạo đối tượng kết nối
        $con = $p->moKetNoi(); // Mở kết nối
        
        // Cập nhật trạng thái trong bảng dondatsan1
        $truyVanCapNhat = "UPDATE dondatsan1 SET TrangThai = ? WHERE MaDonDatSan = ?"; 
        $stmt = mysqli_prepare($con, $truyVanCapNhat); // Chuẩn bị câu truy vấn
        
        if ($stmt === false) {
            return false;
        }
        
        // Liên kết tham số với câu truy vấn
        mysqli_stmt_bind_param($stmt, "si", $trangThai, $maDonDatSan);
        
        // Thực thi câu truy vấn
        $kq = mysqli_stmt_execute($stmt);
        
        // Đóng statement và kết nối
        mysqli_stmt_close($stmt);
        $p->dongKetNoi($con);
        
        return $kq; // Trả về kết quả (true/false)
    }
    

    
    public function GetDonDatSanById($maDonDatSan) {
        $p = new mKetNoi();
        $conn = $p->moKetNoi();
        $query = "SELECT sb.TenSanBong, dds.MaDonDatSan, dds.TrangThai, dds.TongTien ,dds.TenKhachHang,kh.MaKhachHang, ct.NgayNhanSan , ct.ThoiGianBatDau, ct.ThoiGianKetThuc FROM DonDatSan1 dds 
        JOIN sanbong sb on dds.MaSanBong = sb.MaSanBong
        join chitietdondatsan ct on dds.MaDonDatSan = ct.MaDonDatSan 

        join KhachHang kh on dds.MaKhachHang = kh.MaKhachHang WHERE dds.MaDonDatSan = ?";
     
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

    public function suaDatSan($maDonDatSan, $maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien, $tenKhachHang) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
    
        // Kiểm tra nếu các trường quan trọng bị trống
        if (empty($maDonDatSan) || empty($maSanBong) || empty($maKhachHang) || 
            empty($ngayNhanSan) || empty($gioBatDau) || empty($gioKetThuc) || empty($tongTien)) {
            error_log("Error: Missing required fields for update.");
            return false;
        }
    
        // Cập nhật thông tin trong bảng dondatsan1
        $sqlUpdateDon = "UPDATE dondatsan1 
                          SET MaKhachHang = ?, TenKhachHang = ?, MaSanBong = ?, TongTien = ?
                          WHERE MaDonDatSan = ?";
        $stmtDon = $con->prepare($sqlUpdateDon);
        $stmtDon->bind_param("issdi", $maKhachHang, $tenKhachHang, $maSanBong, $tongTien, $maDonDatSan);
        $ketQuaDon = $stmtDon->execute();
    
        if (!$ketQuaDon) {
            error_log("Error updating dondatsan1: " . $stmtDon->error);
            $p->dongKetNoi($con);
            return false;
        }
    
        // Cập nhật thông tin trong bảng chitietdondatsan
        $sqlUpdateChiTiet = "UPDATE chitietdondatsan 
                             SET NgayNhanSan = ?, ThoiGianBatDau = ?, ThoiGianKetThuc = ?, MaSanBong = ?, DonGia = ?
                             WHERE MaDonDatSan = ?";
        $stmtChiTiet = $con->prepare($sqlUpdateChiTiet);
        $stmtChiTiet->bind_param("sssidi", $ngayNhanSan, $gioBatDau, $gioKetThuc, $maSanBong, $tongTien, $maDonDatSan);
        $ketQuaChiTiet = $stmtChiTiet->execute();
    
        if (!$ketQuaChiTiet) {
            error_log("Error updating chitietdondatsan: " . $stmtChiTiet->error);
            $p->dongKetNoi($con);
            return false;
        }
    
        // Đóng kết nối và trả về kết quả
        $p->dongKetNoi($con);
        return true;
    }


    public function selectALLChiTietDonByMaDonDatSan($maDonDatSan) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        // Sửa lại câu truy vấn để lấy chi tiết đơn từ bảng dondatsan1
        $sql = "SELECT dondatsan1.*, 
                        sanbong.TenSanBong, 
                        khachhang.TenKhachHang, 
                        khachhang.SDT, 
                        khachhang.Email, 
                        coso.DiaChi,
                        chitietdondatsan.NgayNhanSan,
                        chitietdondatsan.ThoiGianBatDau,
                        chitietdondatsan.ThoiGianKetThuc
                FROM dondatsan1
                JOIN sanbong ON dondatsan1.MaSanBong = sanbong.MaSanBong 
                JOIN khachhang ON dondatsan1.MaKhachHang = khachhang.MaKhachHang
                JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                JOIN chitietdondatsan ON dondatsan1.MaDonDatSan = chitietdondatsan.MaDonDatSan
                WHERE dondatsan1.MaDonDatSan = $maDonDatSan";
        $kq = mysqli_query($con, $sql);
        if (!$kq) {
            die("Query failed: " . mysqli_error($con));
        }
        $p->dongKetNoi($con);
        return $kq; 
    }
    
    

    
}
   
        
    
?>