<?php
    include_once("mKetNoi.php");
    class mCoSo{
        public function SelectCosoByMaChuSan($machusan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT coso.* ,chusan.TenChuSan FROM `coso` JOIN chusan  ON coso.MaChuSan = chusan.MaChuSan WHERE coso.MaChuSan = $machusan";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function SelectAllCoso(){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT * FROM `coso` ";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function SelectCosoByMaChuSanMaCoSo($macoso,$machusan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT coso.* ,chusan.TenChuSan, chusan.MaChuSan FROM `coso` JOIN chusan  ON coso.MaChuSan = chusan.MaChuSan WHERE coso.MaChuSan = $machusan AND coso.MaCoSo = $macoso";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }
        public function selectCoSoByTenAnDiaChi($tenCoSo,$DiaChi): bool|mysqli_result {
            // Mở kết nối cơ sở dữ liệu
            $p = new mKetNoi();
            $con = $p->moKetNoi();
        
            // Chuẩn bị câu lệnh SQL
            $sql = "SELECT * FROM `coso` WHERE TenCoSo = ? AND DiaChi = ?";
            
            // Chuẩn bị câu lệnh SQL để tránh SQL Injection
            if ($stmt = mysqli_prepare($con, $sql)) {
                // Liên kết tham số
                mysqli_stmt_bind_param($stmt, "ss", $tenCoSo, $DiaChi); // "ss" chỉ loại dữ liệu string cho hai tham số
                
                // Thực thi câu lệnh
                mysqli_stmt_execute($stmt);
                
                // Lấy kết quả
                $kq = mysqli_stmt_get_result($stmt);
                
                // Đóng câu lệnh đã chuẩn bị
                mysqli_stmt_close($stmt);
            } else {
                // Trường hợp lỗi chuẩn bị câu lệnh
                $kq = false;
            }
        
            // Đóng kết nối
            $p->dongKetNoi($con);
            
            // Trả về kết quả
            return $kq;
        }

        public function insertCoSo($tenCoSo,$DiaChi,$moTa,$maChuSan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "insert into coso(TenCoSo, DiaChi, MoTa, MaChuSan) 
                      values (N'$tenCoSo', N'$DiaChi', N'$moTa', '$maChuSan')";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }


        public function updateCoSo($macoso,$tenCoSo,$DiaChi,$moTa,$maChuSan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "UPDATE `coso` SET `TenCoSo`='$tenCoSo',`DiaChi`='$DiaChi',`MoTa`='$moTa',`MaChuSan`='$maChuSan' WHERE MaCoSo = $macoso";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function deleteCoSo($maCoSo){
            $p = new mKetNoi();
            $truyvan = "DELETE FROM `coso` WHERE MaCoSo = $maCoSo";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi(con: $con);
            return $kq;
          }

    }
?>