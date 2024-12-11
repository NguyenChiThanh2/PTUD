<?php 
// session_start();
include_once("mKetNoi.php");

class ModelUser {
    public function checkLogin($email, $password) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();

        // Danh sách bảng và cột ID để kiểm tra đăng nhập
        // $tables = [
        //     'khachhang' => 'MaKhachHang',
        //     'nhanvien' => 'MaNhanVien',
        //     'chusan' => 'MaChuSan',
        //     'quantrihethong' => 'MaQuanTri'
        // ];
        $tables = [
            'khachhang' => ['id' => 'MaKhachHang', 'hoten' => 'TenKhachHang'],
            'nhanvien' => ['id' => 'MaNhanVien', 'hoten' => 'TenNhanVien'],
            'chusan' => ['id' => 'MaChuSan', 'hoten' => 'TenChuSan'],
            'quantrihethong' => ['id' => 'MaQuanTri', 'hoten' => 'TenQuanTri']
        ];

        foreach ($tables as $table => $columns) { // Đổi $idColumn thành $columns
            // Sử dụng Prepared Statements để tránh SQL Injection
            $stmt = $con->prepare("SELECT * FROM $table WHERE Email = ? AND MatKhau = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Thiết lập session sau khi đăng nhập thành công
                $_SESSION["dangnhap"] = $user[$columns['id']]; // Lưu ID người dùng
                $_SESSION["loaiNguoiDung"] = $table;           // Lưu loại người dùng
                // $_SESSION["hoten"] = $user[$columns['hoten']]; // Lưu họ tên người dùng
                if (isset($user[$columns['hoten']])) {
                    $_SESSION["hoten"] = $user[$columns['hoten']];
                } else {
                    $_SESSION["hoten"] = "Chưa xác định"; // Xử lý trường hợp không tìm thấy
                }
                $_SESSION["email"] = $email;
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

    public function selectAUserByEmail2($email){
        $p = new mKetNoi();
        $con = $p->moKetNoi();
    
        // Kiểm tra email trong bảng chusan
        $sqlChuSan = "SELECT * FROM chusan WHERE Email = '$email'";
        $kq = $con->query($sqlChuSan);
    
        if ($kq->num_rows > 0) {
            $p->dongKetNoi($con);
            return $kq; // Nếu tìm thấy email trong bảng chusan
        }

        $sqlChuSan = "SELECT * FROM nhanvien WHERE Email = '$email'";
        $kq = $con->query($sqlChuSan);
    
        if ($kq->num_rows > 0) {
            $p->dongKetNoi($con);
            return $kq; // Nếu tìm thấy email trong bảng chusan
        }

        $sqlChuSan = "SELECT * FROM quantrihethong WHERE Email = '$email'";
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
