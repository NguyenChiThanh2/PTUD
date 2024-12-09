<?php
include_once("model/mKhachHang.php");

    class cKhachHang{
        public function GetKhachHangByMaChuSan($maChuSan){
            $p = new ModelKhachHang();
            $kq =$p->SelectKhachHangByMaChuSan($maChuSan);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{  
                return false;
            }
        }
        public function GetKhachHangByMaKhachHang($maKH){
            $p = new ModelKhachHang();
            $kq =$p->SelectKhachHangByMaKhachHang($maKH);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{  
                return false;
            }
        }

        public function GetAllKhachHang(){
            $p = new ModelKhachHang();
            $kq =$p->selectAllKhachHang();
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{  
                return false;
            }
        }


        // public function updateKhachHang($maKH, $TenKH, $email, $sdt, $matKhau, $diaChi, $gioitinh) {
        //     // Kiểm tra mã nhân viên và mã chủ sân có tồn tại
        //     if (!$maKH) {
        //         echo "<script>alert('Dữ liệu không đầy đủ!');</script>";
        //         return false;
        //     }
        //     $p = new ModelKhachHang();
        //     // Lấy danh sách tất cả email và số điện thoại
        //     $existingData = $this->getAllEmailsAndPhones();
        //     while ($data = $existingData->fetch_assoc()) {
        //         // Chỉ kiểm tra trùng lặp nếu không phải chính nhân viên đang được cập nhật
        //         if (isset($data['MaNhanv']) && $data['MaNhanVien'] != $maNV) {
        //             if ($data['Email'] === $email || $data['SDT'] === $sdt) {
        //                 echo "<script>alert('Email hoặc số điện thoại đã tồn tại!');</script>";
        //                 return false;
        //             }
        //         }
        //     }
        //     // Thực hiện cập nhật nhân viên
        //     $kq = $p->updateKhachHang($maKH, $TenKH, $email, $sdt, $matKhau, $diaChi, $gioitinh));
        //     return $kq;
        // }

        public function updateKhachHang($maKH, $TenKH, $email, $sdt, $matKhau, $diaChi, $gioitinh){
            $p = new ModelKhachHang();
            $kq =$p->updateKhachHang($maKH, $TenKH, $email, $sdt, $matKhau, $diaChi, $gioitinh);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }

        



        

        
    }
?>