<?php 
      include_once("./model/mChuSan.php");
      class ControllerChuSan{
        public function getAllChuSan(){
            $p = new ModelChuSan();
            $kq = $p->selectAllChuSan();
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }
        public function GetChuSanByMaChuSan($maChuSan){
            $p = new ModelChuSan();
            
            $kq =$p->selectAllChuSanByMaChuSan($maChuSan);
            
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{  
                return false;
            }
        }

        public function updateChuSan($maCS, $tenCS, $email, $sdt, $matKhau, $diaChi, $gioitinh){
            $p = new ModelChuSan();
                
            $kq =$p->updateChuSan($maCS, $tenCS, $email, $sdt, $matKhau, $diaChi, $gioitinh);
          
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }

        public function deleteChuSan($maChuSan){
            $p = new ModelChuSan();
            $kq = $p -> deleteChuSan($maChuSan);
            return $kq;
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
        public function getAllNhanVien(){
            $p = new ModelChuSan();
            $kq = $p->selectAllNhanVien();
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }

        public function getAllNhanVienByMaChuSan($maChuSan){
            $p = new ModelChuSan();
            $kq = $p->selectALLNhanVienByMaChuSan($maChuSan);
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }

        public function get01NhanVien($maNV){
            $p = new ModelChuSan();
            $kq = $p->select01NhanVien($maNV);
            if($kq->num_rows > 0){
                return $kq;
            }else{
                return false;
            }
        }

        public function getAllEmailsAndPhones(){
            $p = new ModelChuSan();
            $kq = $p->selectALLEmailsAndPhones();
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }

        public function insertNhanVien($tenNV, $email, $sdt, $diaChi, $sex, $pass, $maChuSan) {
            $p = new ModelChuSan();
            // Kiểm tra email và số điện thoại đã tồn tại
            $existingData = $this->getAllEmailsAndPhones(); // Gọi hàm getAllEmailsAndPhones
            while ($data = $existingData->fetch_assoc()) {
                if ($data['Email'] === $email || $data['SDT'] === $sdt) {
                    echo "<script>alert('Email hoặc số điện thoại đã tồn tại!');</script>";
                    return false;
                }
            }
            // Thực hiện thêm nhân viên mới
            $kq = $p->insertNhanVien($tenNV, $email, $sdt, $diaChi, $sex, $pass, $maChuSan);
            return $kq;
        }

        public function updateNhanVien($maNV, $tenNV, $email, $sdt, $diaChi, $sex, $pass, $maChuSan) {
            // Kiểm tra mã nhân viên và mã chủ sân có tồn tại
            if (!$maNV || !$maChuSan) {
                echo "<script>alert('Dữ liệu không đầy đủ!');</script>";
                return false;
            }
            $p = new ModelChuSan();
            // Lấy danh sách tất cả email và số điện thoại
            $existingData = $this->getAllEmailsAndPhones();
            while ($data = $existingData->fetch_assoc()) {
                // Chỉ kiểm tra trùng lặp nếu không phải chính nhân viên đang được cập nhật
                if ($data['MaNhanVien'] != $maNV && $data['Email'] === $email || $data['MaNhanVien'] != $maNV && $data['SDT'] === $sdt) {
                    echo "<script>alert('Email hoặc số điện thoại đã tồn tại!');</script>";
                    return false;
                }
            }
            // Thực hiện cập nhật nhân viên
            $kq = $p->updateNhanVien($maNV, $tenNV, $email, $sdt, $diaChi, $sex, $pass, $maChuSan);
            return $kq;
        }
        
        
        public function deleteNhanVien($maNV){
            $p = new ModelChuSan();
            $kq = $p -> deleteNhanVien($maNV);
            return $kq;
        }
        
      }

?>