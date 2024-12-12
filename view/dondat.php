<?php

ob_start();
include_once("controller/cDonDatSan.php");
$p = new cDonDatSan();
$maChuSan = $_SESSION['MaChuSan'];
$kq = $p->GetAllDonDatSanByMaChuSan($maChuSan); // Lấy tất cả đơn đặt sân
?>

<div class="header-container">
    <h1>Quản lý đơn đặt sân</h1>
</div>

<?php
// Hiển thị danh sách đơn đặt sân
// Hiển thị danh sách đơn đặt sân
if ($kq && mysqli_num_rows($kq) > 0) {
    echo "<table>";
    echo "<tr>
            <th>Mã đơn</th>
            <th>Mã Khách Hàng</th>
            <th>Tên Khách Hàng</th>
            <th>Tên Sân</th>
            <th>Ngày Nhận Sân </th>
            <th>Giờ Bắt Đầu</th>
            <th>Giờ Kết Thúc</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Hành động</th>
          </tr>";

    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<tr>";
        echo "<td>".$r["MaDonDatSan"]."</td>";
        echo "<td>".$r["MaKhachHang"]."</td>";
        echo "<td>".$r["TenKhachHang"]."</td>";
        echo "<td>".$r["TenSanBong"]."</td>";
        echo "<td>".$r["NgayNhanSan"]."</td>";
        echo "<td>".$r["ThoiGianBatDau"]."</td>";
        echo "<td>".$r["ThoiGianKetThuc"]."</td>";
        echo "<td>".number_format($r["TongTien"], 0, '.', ',')."</td>";
        echo "<td>".$r["TrangThai"]."</td>";
        echo "<td>";

        // Form chứa các nút hành động
        echo "<form method='post' class='action-form'>
        <input type='hidden' name='id' value='".$r["MaDonDatSan"]."'>";

// Nếu trạng thái là "Đã hủy đơn", hiển thị nút "Chi Tiết Đơn"
if ($r["TrangThai"] == "Đã hủy đơn") {
    echo "<a class='detail-button' href='?chitietdondat&id=" . $r["MaDonDatSan"] . "'>Chi Tiết Đơn</a>";
} else {
    // Nút "Sửa"
    echo "<a class='edit-button' href='?action=editDon&id=" . $r["MaDonDatSan"] . "'>Sửa</a>";

    // Nút "Duyệt" chỉ hiển thị khi trạng thái không phải là "Đã đặt"
    if ($r["TrangThai"] != "Đã đặt") {
        echo "<a class='indon-button' href='?printDon=".$r["MaDonDatSan"]."'>Duyệt</a>";
    }

    // Nút "Hủy" chỉ hiển thị nếu trạng thái không phải là "Đã hủy đơn"
    if ($r["TrangThai"] != "Đã hủy đơn") {
        echo "<button type='submit' name='delete' class='delete-button delete-form'>Hủy</button>";
    }
}

echo "</form>";

        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Không có đơn đặt sân nào!</p>";
}

// Xử lý xóa đơn đặt sân (cập nhật trạng thái thành "Đã hủy")
if (isset($_POST["delete"])) {
    $maDonDatSan = $_POST["id"]; // Lấy giá trị id từ form
    $trangThai = "Đã hủy đơn"; // Trạng thái mới
    $kq = $p->updateTrangThaiDatSan($maDonDatSan, $trangThai); // Gọi hàm cập nhật trạng thái
    if ($kq) {
        echo "<script>alert('Đơn đặt sân đã được chuyển sang trạng thái Đã hủy!');</script>";
        echo "<script>window.location.href = 'admin.php?dondat';</script>";

        exit();
    } else {
        echo "<script>alert('Không thể cập nhật trạng thái đơn đặt sân. Vui lòng thử lại!');</script>";
    }
}

// Cập nhật trạng thái về "Chờ duyệt" khi nhấn nút Sửa
if (isset($_GET['action']) && $_GET['action'] == 'editDon' && isset($_GET['id'])) {
    $maDonDatSan = $_GET['id'];
    $trangThai = "Chờ duyệt";
    $kq = $p->updateTrangThaiDatSan($maDonDatSan, $trangThai); // Cập nhật trạng thái
    if ($kq) {
        echo "<script>alert('Đơn đặt sân đã được chuyển về trạng thái Chờ duyệt!');</script>";
        header("Location: ?dondat");
        exit();
    } else {
        echo "<script>alert('Không thể cập nhật trạng thái đơn đặt sân. Vui lòng thử lại!');</script>";
    }
}
?>

<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-container h1 {
        font-size: 24px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .edit-button, .delete-button, .approve-button {
        padding: 5px 10px;
        color: white;
        text-decoration: none;
        border-radius: 3px;
        font-size: 14px;
        display: inline-block;
        margin: 0 5px;
    }

    .edit-button {
        background-color: #007bff;
    }

    .edit-button:hover {
        background-color: #0056b3;
    }

    .delete-button {
        background-color: #dc3545;
    }

    .delete-button:hover {
        background-color: #b21f2d;
    }

    .approve-button {
        background-color: #28a745;
    }

    .approve-button:hover {
        background-color: #218838;
    }

    .action-form {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .action-form a, .action-form button {
        margin: 0 5px;
    }
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-container h1 {
        font-size: 24px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    /* Flexbox container for the action buttons */
    .action-form {
        display: flex;
        justify-content: center;
        gap: 10px; /* Đảm bảo có khoảng cách giữa các nút */
    }

    .action-form a, .action-form button {
        padding: 5px 10px;
        color: white;
        text-decoration: none;
        border-radius: 3px;
        font-size: 14px;
        display: inline-block;
    }

    .edit-button {
        background-color: #007bff;
    }

    .edit-button:hover {
        background-color: #0056b3;
    }

    .delete-button {
        background-color: #dc3545;
    }

    .delete-button:hover {
        background-color: #b21f2d;
    }

    .indon-button {
        background-color: #28a745;
    }

    .indon-button:hover {
        background-color: #218838;
    }

    /* Nút "Chi Tiết Đơn" */
    .detail-button {
        background-color: #17a2b8;
    }

    .detail-button:hover {
        background-color: #138496;
    }
</style>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Xử lý confirm delete
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function (form) {
        form.addEventListener('click', function (e) {
            if (!window.confirm('Bạn có chắc chắn muốn hủy đơn này không?')) {
                e.preventDefault(); // Ngừng hành động nếu người dùng chọn "Cancel"
            }
        });
    });


    // Kiểm tra giờ bắt đầu và giờ kết thúc
    const bookingForm = document.querySelector('form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function (e) {
            const gioBatDau = document.querySelector('[name="gioBatDau"]').value;
            const gioKetThuc = document.querySelector('[name="gioKetThuc"]').value;

            if (gioBatDau && gioKetThuc && gioBatDau >= gioKetThuc) {
                alert('Giờ bắt đầu phải nhỏ hơn giờ kết thúc!');
                e.preventDefault();
            }
        });
    }
});

</script>

