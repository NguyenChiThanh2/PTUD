<?php 
      include_once("mKetnoi.php");
      class ModelKhachHang {
            public function SelectKhachHangByMaChuSan($machusan){
                  $p = new mKetNoi();
                  $con=$p->moKetNoi();
                  if($con){
                      $truyvan = "SELECT DISTINCT 
                                    kh.MaKhachHang,
                                    kh.TenKhachHang,
                                    kh.Email,
                                    kh.SDT,
                                    kh.DiaChi,
                                    kh.GioiTinh
                                FROM 
                                    chusan cs
                                JOIN 
                                    coso csos ON cs.MaChuSan = csos.MaChuSan
                                JOIN 
                                    sanbong sb ON csos.MaCoSo = sb.MaCoSo
                                JOIN 
                                    dondatsan1 dds ON sb.MaSanBong = dds.MaSanBong
                                JOIN 
                                    khachhang kh ON dds.MaKhachHang = kh.MaKhachHang
                                WHERE 
                                    cs.MaChuSan = $machusan;
                                ;

                              ";

                      $kq = mysqli_query($con, $truyvan);
                      
                      $p->dongKetNoi($con);
                      return $kq;
                  }else{
                      return false;
                  }
            }

            public function SelectKhachHangByMaKhachHang($maKH){
                $p = new mKetNoi();
                $con=$p->moKetNoi();
                if($con){
                    $truyvan = "SELECT * FROM `khachhang` WHERE MaKhachHang = $maKH";

                    $kq = mysqli_query($con, $truyvan);
                    
                    $p->dongKetNoi($con);
                    return $kq;
                }else{
                    return false;
                }
            }

            public function selectAllKhachHang(){
                $p = new mKetNoi();
                $con=$p->moKetNoi();
                if($con){
                    $truyvan = "SELECT * FROM `khachhang`";

                    $kq = mysqli_query($con, $truyvan);
                    
                    $p->dongKetNoi($con);
                    return $kq;
                }else{
                    return false;
                }
            }

            public function updateKhachHang($maKH, $TenKH, $email, $sdt, $matKhau, $diaChi, $gioitinh){
                $p = new mKetNoi();
                $con = $p->moKetNoi();  
                // Truy vấn cập nhật thông tin nhân viên
                $truyvan = "UPDATE `khachhang` SET 
                            `TenKhachHang`= N'$TenKH',
                            `Email`='$email',
                            `SDT`='$sdt',
                            `MatKhau`='$matKhau',
                            `DiaChi`='$diaChi',
                            `GioiTinh`='$gioitinh' 
                            WHERE `MaKhachHang` = $maKH";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
              }



      }

?>