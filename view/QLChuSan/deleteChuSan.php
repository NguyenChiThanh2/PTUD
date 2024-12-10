<?php
        ob_start();
        include_once("controller/cChuSan.php");
        $p = new ControllerChuSan();
        $maCS = $_REQUEST["MaChuSan"];
        $kq = $p->deleteChuSan($maCS);
        if($kq){
            echo "<script>alert('Xóa thành công')</script>";
            header("refresh:0.5; url='admin.php?chusan'");
        }else{
            echo "<script>alert('Xóa thất bại!')</script>";
            header("refresh:0.5; url='admin.php?chusan'");  
            ob_end_flush(); 
        }
?>
