<?php
include_once('controller/cCoSo.php');
$pcs = new cCoSo();

// Kiểm tra mã sân bóng đã có trong URL hay chưa
if (isset($_GET['MaCoSo']) && isset($_GET['MaChuSan'])) {
    $maCoSo = $_GET['MaCoSo'];
    $maChuSan = $_GET['MaChuSan'];

    // Lấy thông tin sân bóng từ DB
    $CoSo = $pcs->GetCoSoByMaChuSanMaCoSo($maCoSo, $maChuSan);
    if ($CoSo) {
        $CoSoData = mysqli_fetch_assoc($CoSo);
        if ($CoSoData) {
            $tenCoSo = $CoSoData['TenCoSo'] ?? '';
            $DiaChi = $CoSoData['DiaChi'] ?? '';
            $moTa = $CoSoData['MoTa'] ?? '';
        } else {
            echo "<script>alert('Không tìm thấy dữ liệu cơ sở!');</script>";
            header("refresh:0; url='admin.php'");
            exit();
        }
    } else {
        echo "<script>alert('Cơ sở không tồn tại!');</script>";
        header("refresh:0; url='admin.php'");
        exit();
    }
} else {
    echo "<script>alert('Thông tin không hợp lệ!');</script>";
    header("refresh:0; url='admin.php'");
    exit();
}
?>

<h2 align="center">Cập Nhật Cơ Sở</h2>
<form action="" method="POST" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label for="TenCoSo">Tên Cơ Sở</label>
        <input type="text" id="TenCoSo" name="TenCoSo" required placeholder="VD: Cơ sở Quang Trung" value="<?php echo htmlspecialchars($tenCoSo, ENT_QUOTES); ?>">
        <small class="error-message" style="color: red; display: none;">Tên không hợp lệ!</small>
    </div>
    
    <div class="form-group">
        <label for="DiaChi">Địa Chỉ</label>
        <input type="text" id="DiaChi" name="DiaChi" placeholder="Số 60 Quang Trung, Phường 5, Gò Vấp" value="<?php echo htmlspecialchars($DiaChi, ENT_QUOTES); ?>">
    </div>
    
    <div class="form-group">
        <label for="MoTa">Mô Tả</label>
        <textarea id="MoTa" name="MoTa" placeholder="Hệ thống sân bóng đá hiện đại..."><?php echo htmlspecialchars($moTa, ENT_QUOTES); ?></textarea>
    </div>
    
    <div class="form-group" style="display: flex; justify-content: space-between;">
        <input type="submit" name="btnUpdateCoSo" value="Cập Nhật Cơ Sở">
        <input type="reset" value="Hủy" onclick="history.back();">
    </div>
</form>

<?php
if (isset($_POST['btnUpdateCoSo'])) {
    // Lấy dữ liệu từ form
    $tenCoSo = $_POST['TenCoSo'] ?? '';
    $DiaChi = $_POST['DiaChi'] ?? '';
    $moTa = $_POST['MoTa'] ?? '';

    if (!empty($tenCoSo) && !empty($DiaChi)) {
        $kq = $pcs->updateCoSo($maCoSo, $tenCoSo, $DiaChi, $moTa, $maChuSan);
        if ($kq) {
            echo "<script>alert('Cập nhật cơ sở thành công!')</script>";
            echo '<script>window.location.href="admin.php?coso";</script>';
        } else {
            echo "<script>alert('Cập nhật cơ sở thất bại');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!');</script>";
    }
}
?>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding-left: 0;
        align-items: center;
        height: 100vh;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .form-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 400px;
        margin-left: 400px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
    }

    .form-group input[type="submit"],
    .form-group input[type="reset"] {
        width: 48%;
        cursor: pointer;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        padding: 10px;
        margin-right: 4%;
        background-color: #007bff;
        color: white;
        transition: background-color 0.3s ease;
    }

    .form-group input[type="reset"] {
        background-color: #6c757d;
    }

    .form-group input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .form-group input[type="reset"]:hover {
        background-color: #495057;
    }
</style>