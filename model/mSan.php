<?php
    include_once("mKetNoi.php");
    class mSan{
        public function SelectALLSan(){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT sanbong.*, loaisan.TenLoai
                            FROM sanbong JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function Select1San($idsan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT sanbong.*, coso.DiaChi, loaisan.TenLoai
                            FROM sanbong 
                            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                            WHERE MaSanBong = '$idsan'";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function SelectSanbyType($idloai){
            $p = new mKetNoi();
            $con = $p->moKetNoi();
            if ($con) {
                $truyvan = "SELECT sanbong.*, loaisan.TenLoai 
                            FROM sanbong 
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan 
                            WHERE sanbong.MaLoaiSan = '$idloai'";
                            
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            } else {
                return false;
            }
        }

        public function SelectSanByNameAndAddress($name, $diachi) {
            $p = new mKetNoi();
            $con = $p->moKetNoi();
            
            if ($con) {
                // Tạo truy vấn cơ bản
                $truyvan = "SELECT sanbong.*, coso.DiaChi, loaisan.TenLoai
                            FROM sanbong 
                            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                            WHERE 1=1";
        
                if (!empty($name)) {
                    $name = mysqli_real_escape_string($con, $name);
                    $truyvan .= " AND sanbong.TenSanBong LIKE '%$name%'";
                }
        
                if (!empty($diachi)) {
                    $diachi = mysqli_real_escape_string($con, $diachi); 
                    $truyvan .= " AND coso.DiaChi LIKE '%$diachi%'";
                }
        
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con); 
                return $kq; 
            } else {
                return false; 
            }

        }  
          
    
            public function selectALLSanBongByMaChuSan($maChuSan) {
                $p = new mKetNoi();
                $con = $p->moKetNoi();
                $sql = "SELECT sanbong.MaSanBong, sanbong.TenSanBong, sanbong.ThoiGianHoatDong, sanbong.MoTa, sanbong.HinhAnh, nhanvien.TenNhanVien, loaisan.TenLoai, coso.TenCoSo
                FROM sanbong
                JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                JOIN nhanvien ON sanbong.MaNhanVien = nhanvien.MaNhanVien
                WHERE nhanvien.MaChuSan = '$maChuSan'";
    
                $kq = mysqli_query($con, $sql);
                $p->dongKetNoi($con);
                return $kq; 
              }

              public function GetSanbyTypeAndMaChuSan($idloai,$maChuSan) {
                $p = new mKetNoi();
                $con = $p->moKetNoi();
                $sql = "SELECT sanbong.MaSanBong, sanbong.TenSanBong, sanbong.ThoiGianHoatDong, sanbong.MoTa, sanbong.HinhAnh, nhanvien.TenNhanVien, loaisan.TenLoai, coso.TenCoSo
                FROM sanbong
                JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                JOIN nhanvien ON sanbong.MaNhanVien = nhanvien.MaNhanVien
                WHERE nhanvien.MaChuSan = '$maChuSan' AND sanbong.MaLoaiSan = $idloai";
    
                $kq = mysqli_query($con, $sql);
                $p->dongKetNoi($con);
                return $kq; 
              }
    
    
              public function selectInfo1San($maSanBong,$maChuSan) {
                $p = new mKetNoi();
                $con = $p->moKetNoi();
                    $sql = "SELECT sanbong.*, nhanvien.TenNhanVien,nhanvien.MaNhanVien ,giathue.*,loaisan.TenLoai,loaisan.MaLoaiSan, coso.TenCoSo,coso.MaCoSo
                            FROM sanbong 
                            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                            JOIN giathue ON giathue.MaLoaiSanBong = loaisan.MaLoaiSan
                            JOIN nhanvien ON nhanvien.MaNhanVien = sanbong.MaNhanVien
                            WHERE MaSanBong = '$maSanBong' AND nhanvien.MaChuSan = '$maChuSan';
                    ";
                
                $kq = mysqli_query($con, $sql);
                $p->dongKetNoi($con);
                return $kq; 
              }
              
            
            public function insertSanBong($tenSanBong, $thoiGianHoatDong, $moTa, $hinhAnh, $maNhanVien, $maLoaiSan, $maCoSo) {
                $p = new mKetNoi(); // Đảm bảo class mKetNoi có phương thức moKetNoi() và dongKetNoi()
                $con = $p->moKetNoi();
            
                // Chuẩn bị câu truy vấn SQL
                $truyvan = "INSERT INTO sanbong (TenSanBong, ThoiGianHoatDong, MoTa, HinhAnh, MaNhanVien, MaLoaiSan, MaCoSo) 
                            VALUES (N'$tenSanBong', N'$thoiGianHoatDong', N'$moTa', N'$hinhAnh', '$maNhanVien', '$maLoaiSan', '$maCoSo')";
            
                // Thực thi truy vấn
                $kq = mysqli_query($con, $truyvan);
            
                // Đóng kết nối
                $p->dongKetNoi($con);
            
                // Trả về kết quả
                return $kq;
            }
    
    
        public function updateSanBong($maSanBong, $tenSanBong, $loaiSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan, $macoso) {
        // Mở kết nối cơ sở dữ liệu
        $p = new mKetNoi(); // Đảm bảo class mKetNoi có phương thức moKetNoi() và dongKetNoi()
        $con = $p->moKetNoi(); // Mở kết nối cơ sở dữ liệu
        
        if ($con === false) {
            // Kiểm tra nếu kết nối không thành công
            return false;
        }
    
        // Chuẩn bị câu lệnh SQL với tham số binding để bảo vệ khỏi SQL injection
        $sql = "UPDATE `sanbong`
                SET `TenSanBong` = ?, 
                    `ThoiGianHoatDong` = ?, 
                    `MoTa` = ?, 
                    `HinhAnh` = ?, 
                    `MaNhanVien` = ?, 
                    `MaLoaiSan` = ?, 
                    `MaCoSo` = ? 
                WHERE `MaSanBong` = ?";
    
        // Chuẩn bị truy vấn SQL
        if ($stmt = $con->prepare($sql)) {
            // Gán các tham số vào câu lệnh chuẩn bị
            // Kiểu dữ liệu cho bind_param: s = string, i = integer
            $stmt->bind_param("ssssssss", $tenSanBong, $thoiGianHoatDong, $moTaSan, $anhSan, $maNhanVien, $loaiSan, $macoso, $maSanBong);
    
            // Thực thi câu lệnh
            $result = $stmt->execute();
    
            if ($result) {
                // Nếu câu lệnh thực thi thành công, đóng câu lệnh và kết nối
                $stmt->close();
                $con->close();
                return true; // Trả về true nếu thành công
            } else {
                // Nếu câu lệnh thực thi thất bại
                $stmt->close();
                $con->close();
                return false;
            }
        } else {
            // Nếu không thể chuẩn bị câu lệnh, đóng kết nối và trả về false
            $con->close();
            return false;
        }
    }
    
            
    
    
            public function deleteSanBong($masanbong){
                $p = new mKetNoi();
                $truyvan = "DELETE FROM `sanbong` WHERE MaSanBong = $masanbong";
                $con = $p -> moKetNoi();
                $kq = mysqli_query($con, $truyvan);
                $p -> dongKetNoi(con: $con);
                return $kq;
              }
    
        }      

        
    
?>