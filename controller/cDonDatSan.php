<?php
include_once(__DIR__ . '/../model/mDonDatSan.php'); 

class cDonDatSan {
    public function GetAllDonDatSan() {
        $model = new mDonDatSan();
        return $model->GetALLDonDatSan(); // Lấy tất cả đơn đặt sân
    }
    public function GetAllDonDatSanByMaChuSan($machusan) {
        $model = new mDonDatSan();
        return $model->GetALLDonDatSanByMaChuSan($machusan); // Lấy tất cả đơn đặt sân
    }

    public function ThemDonDatSan($tenKH, $sdt, $ngayDat, $gioBatDau, $gioKetThuc, $tenSanBong) {
        $model = new mDonDatSan();
        return $model->ThemDonDatSan($tenKH, $sdt, $ngayDat, $gioBatDau, $gioKetThuc, $tenSanBong);
    }

    public function PheDuyetDon($maDonDatSan) {
        $model = new mDonDatSan();
        return $model->PheDuyetDon($maDonDatSan);
    }

    public function getinsertDatSan($maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien,$tenKH){
        $model = new mDonDatSan();
        
        $kq = $model->insertDatSan($maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien,$tenKH);
      
        if($kq){
            return $kq;
        }else{
           

            return false;
        }
    }
    
    public function getKiemTraSDT($sdt){
        $model = new mDonDatSan();
        $kq = $model->KiemTraSDT($sdt);
        if($kq){
            if($kq->num_rows>0){
                while($r = $kq->fetch_assoc()){
                    $_SESSION["TenKH"] = $r["TenKhachHang"];
                    $_SESSION["MaKH"] = $r["MaKhachHang"];
                }
                return $kq;
            }else{
                return 0;
            }
        }else{
            return false;
        }
    }
    

    public function getKiemTraTrungGio($ngayNhanSan) {
        // Tạo đối tượng model để gọi phương thức kiểm tra trùng giờ
        $model = new mDonDatSan();
        $kq = $model->KiemTraTrungGio($ngayNhanSan);
    
        // Kiểm tra nếu truy vấn lỗi
        if ($kq === false) {
            return false; // Truy vấn lỗi
        }
    
        // Kiểm tra nếu không có kết quả
        if ($kq->num_rows === 0) {
            return null; // Không có đơn trùng giờ
        }
    
        // Trường hợp có kết quả
        return $kq;
    }
    

    public function getupdateTrangThaiDon($madon){
        // Tạo đối tượng model để gọi phương thức kiểm tra trùng giờ
        $model = new mDonDatSan();
        $kq = $model->updateTrangThaiDon($madon);
    
        if ($kq) {
            return $kq;
        } else {
            // Trường hợp có lỗi trong việc truy vấn
            return false;
        }
    }

    public function duyetVaGuiThongTinDonDatSan($maDonDatSan) {
        // Tạo đối tượng của model
        $model = new mDonDatSan();
    
        // Lấy thông tin và cập nhật trạng thái của đơn
        $thongTinDon = $model->getThongTinVaCapNhatTrangThaiDon($maDonDatSan);
    
        // Kiểm tra xem kết quả có hợp lệ hay không
        if ($thongTinDon) {
            return $thongTinDon; // Nếu có dữ liệu, trả về thông tin đơn
        } else {
            // Nếu không có dữ liệu hoặc có lỗi, xử lý lỗi và trả về false
            return false;
        }
    }
    


 public function updateTrangThaiDatSan($maDonDatSan, $trangThai) {
    // Tạo đối tượng của model mDonDatSan
    $model = new mDonDatSan();
    
    // Gọi hàm trong model để cập nhật trạng thái đơn đặt sân
    $ketQua = $model->updateTrangThaiDatSan($maDonDatSan, $trangThai);
    
    // Trả về kết quả của quá trình cập nhật (true/false)
    return $ketQua;
}

    
    
    
    // Sửa lại tên phương thức từ GetDonById thành GetDonDatSanById
    public function GetDonDatSanById($maDonDatSan) {
        $model = new mDonDatSan(); 
        
        return $model->GetDonDatSanById($maDonDatSan); // Gọi đúng phương thức của lớp model
    }

    // Cập nhật thông tin đơn đặt sân
   
// public function UpDonDatSan($maDonDatSan, $tenKH, $ngayDat, $gioBatDau, $gioKetThuc, $trangThai) {
//     // Kết nối tới model
//     $model = new mDonDatSan();

//     // Gọi hàm cập nhật trong model và truyền thêm tổng tiền
//     return $model->SuaDonDatSan($maDonDatSan, $tenKH, $ngayDat, $gioBatDau, $gioKetThuc, $trangThai);
// }
public function UpDonDatSan($maDonDatSan, $maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien, $tenKhachHang) {
    $model = new mDonDatSan();
    return $model->suaDatSan($maDonDatSan, $maSanBong, $maKhachHang, $ngayNhanSan, $gioBatDau, $gioKetThuc, $tongTien, $tenKhachHang);
}

    
public function getALLChiTietDonByMaDonDatSan($maDonDatSan) {
    $p = new mDonDatSan();
    $kq = $p->selectALLChiTietDonByMaDonDatSan($maDonDatSan);
    if($kq){
        return $kq;
    } else {
        echo "Không có dữ liệu!";
    }
}

    
}
?>