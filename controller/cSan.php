<?php
include_once(__DIR__ . "/../model/mSan.php");
    class cSan{
        public function GetALLSan(){
            $p = new mSan();
            $kq =$p->SelectALLSan();
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }

        public function Get1San($idsan){
            $p = new mSan();
            $kq =$p->Select1San($idsan);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
        
        public function GetSanbyType($idloai){
            $p = new mSan();
            $kq =$p->SelectSanbyType($idloai);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }

        // public function GetSanbyName($name){
        //     $p = new mSan();
        //     $kq =$p->SelectSanbyName($name);
        //     if(mysqli_num_rows($kq)>0){
        //         return $kq;
        //     }else{
        //         return false;
        //     }
        // }

        public function GetSanByNameAndAddress($name, $address) {
            $p = new mSan(); 
            $kq = $p->SelectSanByNameAndAddress($name, $address); 
            if (mysqli_num_rows($kq) > 0) {
                return $kq; 
            } else {
                return false; 
            }
        }     


        public function getAllSanBongByMaChuSan($maChuSan){
            $p = new mSan();
            $kq = $p->selectALLSanBongByMaChuSan($maChuSan);
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }

        public function GetSanbyTypeAndMaChuSan($idloai,$maChuSan){
            $p = new mSan();
            $kq =$p->GetSanbyTypeAndMaChuSan($idloai,$maChuSan);
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }

        public function getInfo1San($maSan,$maChuSan){
            $p = new mSan();
            $kq = $p->selectInfo1San($maSan,$maChuSan);
            if(!$kq){
                echo "Không có dữ liệu!";
            }else{
                if($kq->num_rows > 0)
                    return $kq;
            }
        }

        public function insertSanBong($tenSanBong, $thoiGianHoatDong, $moTa, $hinhanh, $maNhanVien, $maLoaiSan, $maCoSo) {
            $p = new mKetNoi();
            $con = $p->moKetNoi();
    
            // Sử dụng prepared statement để tránh SQL Injection
            $checkQuery = "SELECT * FROM sanbong WHERE TenSanBong = ? AND MaCoSo = ?";
            $stmtCheck = $con->prepare($checkQuery);
            $stmtCheck->bind_param("ss", $tenSanBong, $maCoSo);
            $stmtCheck->execute();
            $existingData = $stmtCheck->get_result();
            
            if ($existingData && $existingData->num_rows > 0) {
                echo "<script>alert('Tên sân bóng đã tồn tại tại cơ sở này!');</script>";
                $stmtCheck->close();
                $p->dongKetNoi($con);
                return false;
            }
    
            // Câu lệnh INSERT với prepared statement
            $insertQuery = "INSERT INTO sanbong (TenSanBong, ThoiGianHoatDong, MoTa, HinhAnh, MaNhanVien, MaLoaiSan, MaCoSo) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $con->prepare($insertQuery);
            $stmtInsert->bind_param("sssssss", $tenSanBong, $thoiGianHoatDong, $moTa, $hinhanh, $maNhanVien, $maLoaiSan, $maCoSo);
            $kq = $stmtInsert->execute();
    
            
    
            // Đóng kết nối
            $stmtInsert->close();
            $p->dongKetNoi($con);
            
            return $kq;
        }
        

        // public function updateSanBong($maSanBong, $tenSanBong, $loaiSan, $giaSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan,$macoso) {
        //     // Kiểm tra mã nhân viên và mã chủ sân có tồn tại
        //     if (!$maSanBong) {
        //         echo "<script>alert('Dữ liệu không đầy đủ!');</script>";
        //         return false;
        //     }
        //     $p = new mSan();
            
        //     // Thực hiện cập nhật nhân viên
        //     $kq = $p->updateSanBong($maSanBong, $tenSanBong, $loaiSan, $giaSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan,$macoso);
        //     return $kq;
        // }

        public function updateSanBong($maSanBong, $tenSanBong, $loaiSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan, $macoso) {
            // Kiểm tra dữ liệu đầu vào
            if (empty($maSanBong) || empty($tenSanBong) || empty($loaiSan) || empty($moTaSan) || empty($thoiGianHoatDong) || empty($maNhanVien) || empty($macoso)) {
                echo "<script>alert('Dữ liệu không đầy đủ!');</script>";
                return false;
            }
        
            // Tạo đối tượng model mSan
            $p = new mSan();
        
            // Gọi phương thức updateSanBong trong model
            $kq = $p->updateSanBong($maSanBong, $tenSanBong, $loaiSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan, $macoso);
        
           
            
            return $kq;  // Trả về kết quả để kiểm tra ở nơi gọi phương thức này
        }
        

        

        public function deleteSanBong($maSanBong){
            $p = new mSan();
            $kq = $p -> deleteSanBong($maSanBong);
            return $kq;
        }



        
        }        
        

        
    
?>