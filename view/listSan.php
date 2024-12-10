<?php
// if(isset($_REQUEST["datsan"])){
//     if(isset($_SESSION['dangnhap'])){
//         header("Location: view/datsan.php");
//     }else{
//         echo"<script>alert('Bạn cần đăng nhập để có thể đặt sân!')</script>";
//         header("refresh: 0.5; url=view/dangnhap.php");
//     }
// }

include_once("controller/cSan.php");
$p = new cSan();

// Lấy danh sách sân theo loại hoặc tất cả sân
if(isset($_SESSION['MaChuSan'])){
    $kq = $p->getAllSanBongByMaChuSan($_SESSION['MaChuSan']);
}
elseif (isset($_REQUEST["idloai"])){
    $kq = $p->GetSanbyType($_REQUEST["idloai"]);
}else if(isset($_REQUEST['btnTim'])) {
    $kq = $p->GetSanbyName($_REQUEST["txtTuKhoa"]);
} else {
    $kq = $p->GetALLSan();
}

if ($kq) {
    echo "<table>";
    echo "<tr>";
    echo "<h2>Danh Sách Sân Bóng</h2>";
    $dem = 0;

    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<td>";
        echo "<div class='product-item'>";
        echo "<img src='img/SanBong/".$r['HinhAnh']."' width='200px' height='120px'/><br>";
        echo "<a href='?idsan=" . $r["MaSanBong"] . "'>" . $r["TenSanBong"] . "</a><br>";
        echo $r["TenLoai"] . "<br>";
        echo "<button class='btn-book'><a style='color: white;' href='?idsan=".$r["MaSanBong"]."'>Xem chi tiết</a></button>";
        echo "</div>";
        echo "</td>";
        $dem++;
        
        if ($dem % 5 == 0) {
            echo "</tr><tr>";
        }
    }

    echo "</tr>";
    echo "</table>";
} else {
    echo "Không có dữ liệu";
}

    

?>
