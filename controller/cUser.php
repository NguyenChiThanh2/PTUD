<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("..//model/mUser.php");
class ControllerUser {
    public function login($email, $password) {
        $p = new ModelUser();
        $user = $p->checkLogin($email, $password);
    
        if ($user) {
            // Lấy loại người dùng từ session
            $role = $_SESSION['loaiNguoiDung'];
            $welcomeMessage = "";
    
            switch ($role) {
                case 'chusan':
                    $welcomeMessage = "Hoan nghênh Chủ Sân. Chúc bạn một ngày kinh doanh hiệu quả và thành công.";
                    $_SESSION["MaChuSan"] = $user["MaChuSan"];
                    break;
                case 'nhanvien':
                    $welcomeMessage = "Đăng nhập thành công. Chúc bạn một ngày làm việc tràn đầy năng lượng.";
                    $_SESSION["MaNhanVien"] = $user["MaNhanVien"];
                    $_SESSION["MaChuSan"] = $user["MaChuSan"];
                    break;
                case 'khachhang':
                    $welcomeMessage = "Chào mừng Quý Khách. Hãy tận hưởng những dịch vụ tốt nhất từ chúng tôi.";
                    $_SESSION["MaKhachHang"] = $user["MaKhachHang"];
                    break;
                case 'quantrihethong':
                    $welcomeMessage = "Chào mừng quản trị viên.";
                    $_SESSION["MaQuanTri"] = $user["MaQuanTri"];
                    break;
                default:
                    $welcomeMessage = "Welcome Admin!";
            }
    
            // Hiển thị thông báo
            echo "<script>
                alert('$welcomeMessage');
                window.location.href = '../index.php';
            </script>";
        } else {
            // Đăng nhập thất bại
            echo "<script>
                alert('Đăng nhập thất bại! Vui lòng kiểm tra lại.');
                window.location.href = 'dangnhap.php';
            </script>";
        }
    }


    public function registerTK($hoten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh, $loaitk){
        $matkhau = md5($matkhau);
        $p = new ModelUser();
        $kq = $p->dangKy($hoten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh, $loaitk);
        if($kq){
            echo "<script>alert('Đăng kí thành công !')</script>";
            // header("Location: ");
        }else{
            echo "<script>alert('Đăng kí thất bại, vui lòng thực hiện lại !')</script>";
            // header("Location: index.php?dangnhap");
        }
    }

    public function getAUserByEmail($email){
        $p = new ModelUser();
        $kq = $p->selectAUserByEmail($email);
        if(!$kq){
            echo "No data !";
        }else{
            if($kq->num_rows > 0)
                return $kq;
        }
    }
    
}
?>
