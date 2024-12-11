<?php
include_once("model/mCoSo.php");

    class cCoSo{

        public function GetAllCoSo(){
            $p = new mCoSo();
            $kq =$p->SelectAllCoSo();
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
        public function GetCoSoByMaChuSan($maChuSan){
            $p = new mCoSo();
            $kq =$p->SelectCosoByMaChuSan($maChuSan);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{  
                return false;
            }
        }

        public function GetCoSoByMaChuSanMaCoSo($macoso, $maChuSan){
            $p = new mCoSo();
            $kq =$p->SelectCosoByMaChuSanMaCoSo($macoso,$maChuSan);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{  
                return false;
            }
        }

        public function getallCoSoByTenAnDiaChi($tenCoSo,$DiaChi) {
            $p = new mCoSo();
            
            // Lấy kết quả từ phương thức selectSanbongByTenSanBong
            $kq = $p->selectCoSoByTenAnDiaChi($tenCoSo,$DiaChi);
            
            // Kiểm tra xem có bản ghi nào trong kết quả không
            if ($kq && mysqli_num_rows($kq) > 0) {
                return 1; // Có bản ghi
            } else {
                return false; // Không có bản ghi
            }
        }

        public function insertCoSo($tenCoSo,$DiaChi,$moTa,$maChuSan){
            $p = new mCoSo();
            $kq =$p->insertCoSo($tenCoSo,$DiaChi,$moTa,$maChuSan);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }

        public function updateCoSo($macoso,$tenCoSo,$DiaChi,$moTa,$maChuSan){
            $p = new mCoSo();
            $kq =$p->updateCoSo($macoso,$tenCoSo,$DiaChi,$moTa,$maChuSan);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }

        

        public function deleteCoSo($maCoSo){
            $p = new mCoSo();
            $kq = $p -> deleteCoSo($maCoSo);
            return $kq;
        }
    

        
    }
?>