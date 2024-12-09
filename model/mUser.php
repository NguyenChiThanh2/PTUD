<?php 
// session_start();
include_once("mKetNoi.php");

class ModelUser {
    public function checkLogin($email, $password) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();

        // Danh sách bảng và cột ID để kiểm tra đăng nhập
        $tables = [
            'khachhang' => 'MaKhachHang',
            'nhanvien' => 'MaNhanVien',
            'chusan' => 'MaChuSan',
            'quantrihethong' => 'MaQuanTri'
        ];

        foreach ($tables as $table => $idColumn) {
            // Sử dụng Prepared Statements để tránh SQL Injection
            $stmt = $con->prepare("SELECT * FROM $table WHERE Email = ? AND MatKhau = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Thiết lập session sau khi đăng nhập thành công
                $_SESSION["dangnhap"] = $user[$idColumn];
                $_SESSION["loaiNguoiDung"] = $table; // Lưu loại người dùng
                
                $stmt->close();
                $p->dongKetNoi($con);
                return $user;
            }

            $stmt->close();
        }

        // Đóng kết nối và trả về false nếu không tìm thấy người dùng
        $p->dongKetNoi($con);
        return false;
    }

    public function dangKy($hoten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh, $loaitk) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();
        if($loaitk === "canhan"){
            $sql = "insert into khachhang (TenKhachHang, Email, SDT, MatKhau, DiaChi, GioiTinh) values ('$hoten', '$email', '$sodienthoai', '$matkhau', '$diachi', '$gioitinh')";
        }else{
            $sql = "insert into chusan (TenChuSan, Email, MatKhau, SDT, DiaChi, GioiTinh) values ('$hoten', '$email', '$matkhau', '$sodienthoai', '$diachi', '$gioitinh')";
        }
        
        $kq = $con->query($sql);
        $p->dongKetNoi($con);
        return $kq;
    }

    public function selectAUserByEmail($email){
        $p = new mKetNoi();
        $con = $p->moKetNoi();
    
        // Kiểm tra email trong bảng chusan
        $sqlChuSan = "SELECT * FROM chusan WHERE Email = '$email'";
        $kq = $con->query($sqlChuSan);
    
        if ($kq->num_rows > 0) {
            $p->dongKetNoi($con);
            return $kq; // Nếu tìm thấy email trong bảng chusan
        }
    
        // Nếu không tìm thấy, kiểm tra bảng khachhang
        $sqlKhachHang = "SELECT * FROM khachhang WHERE Email = '$email'";
        $kq = $con->query($sqlKhachHang);
    
        $p->dongKetNoi($con);
        return $kq; // Trả về kết quả từ bảng khachhang hoặc rỗng
    }
    
}
?>
