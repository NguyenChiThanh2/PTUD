<?php
include_once("controller/cChuSan.php");
$p = new ControllerChuSan();


    $maquantri = $_SESSION['MaQuanTri'];
    $kq = $p->getAllChuSan();


// Lấy mã chủ sân từ session


// Lấy danh sách khách hàng theo mã chủ sân
echo "<div class='header-container'>
<h1>Quản lý Chủ Sân</h1>

</div>";
// Kiểm tra xem có dữ liệu hay không
if ($kq) {
    // Bắt đầu bảng hiển thị thông tin khách hàng
    echo "<table>";
    echo "<tr>
            <th>Mã Chủ San</th>
            <th>Tên Chủ Sân</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Giới Tính</th>
            <th>Thao Tác</th>
          </tr>";

    // Duyệt qua từng khách hàng và hiển thị thông tin
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($r["MaChuSan"]) . "</td>"; // Sử dụng htmlspecialchars() để bảo vệ dữ liệu
        echo "<td>" . htmlspecialchars($r["TenChuSan"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["Email"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["SDT"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["DiaChi"]) . "</td>";
        echo "<td>" . htmlspecialchars(($r["GioiTinh"] == 1 ? "Nam" : "Nữ")) . "</td>";
        
        $maChuSan = htmlspecialchars($r['MaChuSan']); // Bảo vệ dữ liệu trong URL
        echo "<td>
                <a href='?action=updateChuSan&MaChuSan=$maChuSan' class='edit-button'>Sửa</a>";
        
   
            echo " 
                <a href='?action=deleteChuSan&MaChuSan=$maChuSan' class='delete-button' onclick='return confirm(\"Bạn chắc chắn muốn xóa chủ sân này?\")'>Xóa</a>";
        

        echo "</td>";
        echo "</tr>";
    }

    // Đóng bảng sau khi hiển thị tất cả dữ liệu
    echo "</table>";
} else {
    // Thông báo nếu không có dữ liệu
    echo "<p>Không có dữ liệu cơ sở nào.</p>";
}

?>

<style>
    .header-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .header-container h1{
        background-color: #e0f2e9;
        color: #333;
        width: 100%;
        margin: 0;
        padding: 10px; 
        box-sizing: border-box;
    }
    .btn-add {
        background-color: #4CAF50; /* Màu nền xanh lá cây */
        color: white; /* Màu chữ trắng */
        padding: 10px 20px;
        text-align: center;
        align-items: right;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-top: 10px;
        margin-left: 80%;
        cursor: pointer;
        border: none;
        border-radius: 4px;
    }
    .edit-button {
    color: white;
    background-color: blue;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 3px;
}

.edit-button:hover {
    background-color: darkblue;
}

/* CSS for Delete button */
.delete-button {
    color: white;
    background-color: red;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 3px;
}

.delete-button:hover {
    background-color: darkred;
}
    </style>