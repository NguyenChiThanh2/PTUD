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