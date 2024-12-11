<?php 
      include_once("ketnoi.php");
      class ModelNhanVien {
            public function selectAllNhanVien() {
                  $p = new mKetNoi();
                  $con = $p->moKetNoi();
                  $sql = "select * from nhanvien";
                  $kq = $con->query($sql);
                  $p->dongKetNoi($con);
                  return $kq;
            }
              public function selectNhanVienByMaChuSan($maChuSan) {
                  $p = new mKetNoi();
                  $con = $p->moKetNoi();
                  $sql = "select * from nhanvien where MaChuSan = $maChuSan";
                  $kq = mysqli_query($con, $sql);
                  $p->dongKetNoi($con);
                  return $kq; 
                }
            
      }

      

?>