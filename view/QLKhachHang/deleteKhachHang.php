<?php
        ob_start();
        include_once("controller/cKhachHang.php");
        $p = new cKhachHang();
        $maKH = $_REQUEST["MaKhachHang"];
        $kq = $p->deleteKhachHang($maKH);
        if($kq){
            echo "<script>alert('Xóa thành công')</script>";
            header("refresh:0.5; url='admin.php?khachhang'");
        }else{
            echo "<script>alert('Xóa thất bại!')</script>";
            header("refresh:0.5; url='admin.php?khachhang'");  
            ob_end_flush(); 
        }
?>
