<?php
include_once("controller/cSan.php");
// if (!isset($_SESSION['dangnhap'])) {
//     echo "<script>alert('Bạn cần đăng nhập để có thể đặt sân!')</script>";
//     header("refresh: 0.5; url=view/dangnhap.php");
//     exit();
// }
$idsan = $_REQUEST["idsan"];
include_once("controller/cSan.php");
$p = new cSan();
$kq = $p->Get1San($idsan);

if ($kq) {
    echo "<table>";
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<tr>";
        echo "<td><img src='img/SanBong/" . $r['HinhAnh'] . "' alt='" . $r['TenSanBong'] . "' width='250px' height='170px' />"."<br>"."Mô tả: ".$r['MoTa']."</td>";
        echo "<td>
                <div class='title'>" . $r["TenSanBong"] . "</div>
                <br>
                " . $r['TenLoai'] . "<br>
                Địa chỉ cơ sở: " . $r['DiaChi'] . "<br>
                <div class='highlight'>" . $r["ThoiGianHoatDong"] . "</div>
                <div class='highlight'>SDT liên hệ: " . $r["SDT"] . "</div>
                <br>";
        echo "
    <button class='btn-other'>
        <a class='edit-button' href='";
if (isset($_SESSION['loaiNguoiDung'])) {
    if ($_SESSION['loaiNguoiDung'] == 'nhanvien' || $_SESSION['loaiNguoiDung'] == 'chusan') {
        echo "view/datsan.php?idSan=".$r["MaSanBong"]."&mals=".$r["MaLoaiSan"];
    } elseif ($_SESSION['loaiNguoiDung'] == 'khachhang') {
        echo "view/kh_datsan.php?idsan=".$r["MaSanBong"];
    } else {
        echo "view/dangnhap.php";
    }
} else {
    echo "view/dangnhap.php";
}
echo "'>Đặt sân</a>
    </button>";
        // echo "<button class='btn-other'><a href='San.php'>Xem sân khác</a></button>";
        echo "<button onclick='window.history.back();'>Quay lại</button>
            </td>";
       
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu";
}
?>

<style>
    /* Table Styling */
table {
    width: 60%;
    margin: 30px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: center;
}

td {
    padding: 15px;
    vertical-align: middle;
    border: none;
}

td img {
    display: block;
    max-width: 80%;
    height: auto;
    margin: 0 auto;
    border-radius: 8px;
}

td.description {
    font-size: 16px;
    color: #555;
    padding: 10px 20px;
    text-align: justify;
}

/* Title Styling */
.title {
    font-size: 22px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.highlight {
    font-size: 16px;
    font-weight: bold;
    color: #007bff;
    margin: 10px 0;
}

/* Button Styling */
button {
    display: inline-block;
    padding: 8px 16px;
    margin: 10px 5px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    background: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
}

button a {
    color: #fff;
    text-decoration: none;
}

button.btn-other {
    background-color: #28a745;
}

button.btn-back {
    background-color: #ffc107;
}

button:hover {
    background: #0056b3;
    opacity: 0.95;
}

button.btn-other:hover {
    background-color: #218838;
}

button.btn-back:hover {
    background-color: #e0a800;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        width: 90%;
    }

    td {
        display: block;
        text-align: center;
    }

    td img {
        max-width: 90%;
    }

    button {
        width: 100%;
        margin: 10px 0;
    }
}

</style>

