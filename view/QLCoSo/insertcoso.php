<?php 
include_once("controller/cCoSo.php");
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra session MaChuSan
if (!isset($_SESSION['MaChuSan'])) {
    echo "<script>alert('Bạn cần đăng nhập để thực hiện thao tác này.');</script>";
    echo '<script>window.location.href="login.php";</script>';
    exit();
}

$maChuSan = $_SESSION['MaChuSan'];
$p = new cCoSo();
$kq = $p->GetCoSoByMaChuSan($maChuSan);
?>
<h2 align="center">Thêm Cơ Sở</h2>
<form action="" method="post" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label for="TenCoSo">Tên Cơ Sở</label>
        <input type="text" id="TenCoSo" name="TenCoSo" required placeholder="VD: Cơ sở Quang Trung">
        <small id="TenCoSoError" class="error-message" style="color: red; display: none;">Tên Cơ Sở không được trống</small>
    </div>
    
    <div class="form-group">
        <label for="DiaChi">Địa Chỉ</label>
        <input type="text" id="DiaChi" name="DiaChi" placeholder="Số 60 Quang Trung, Phường 5, Gò Vấp">
        <small id="DiaChiError" class="error-message" style="color: red; display: none;">Địa chỉ không được trống</small>
    </div>
    
    <div class="form-group">
        <label for="MoTa">Mô Tả</label>
        <textarea id="MoTa" name="MoTa" placeholder="Hệ thống sân bóng đá hiện đại..."></textarea>
    </div>
    
    <div class="form-group" style="display: flex; justify-content: space-between;">
        <input type="submit" name="btnThemCoSo" value="Thêm Cơ Sở">
        <input type="reset" value="Hủy" onclick="history.back();"  >
    </div>

  

</form>

<?php
if (isset($_POST['btnThemCoSo'])) {
    // Lấy dữ liệu từ form
    $tenCoSo = htmlspecialchars($_POST['TenCoSo']);
    $DiaChi = htmlspecialchars($_POST['DiaChi']);
    $moTa = htmlspecialchars($_POST['MoTa']);

    $ktraten  = $p->getallCoSoByTenAnDiaChi($tenCoSo,$DiaChi);
    if ($ktraten === 1) {
        echo "<script>alert('Cơ Sở này đã tồn tại!');</script>";
        echo '<script>window.history.back();</script>';
        exit();  // Dừng lại ngay sau khi tên sân đã tồn tại
    }

    if (!empty($tenCoSo) && !empty($DiaChi)) {
        $kq = $p->insertCoSo($tenCoSo, $DiaChi, $moTa, $maChuSan);
        if ($kq) {
            echo "<script>alert('Thêm cơ sở thành công!');</script>";
            echo '<script>window.location.href="admin.php?coso";</script>';
        } else {
            echo "<script>alert('Thêm cơ sở thất bại!');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!');</script>";
        echo '<script>window.history.back();</script>';
        exit();
    }
}
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const TenCoSoInput = document.getElementById("TenCoSo");
    const DiaChiInput = document.getElementById("DiaChi");
    const TenCoSoError = document.getElementById("TenCoSoError");
    const DiaChiError = document.getElementById("DiaChiError");

    function validateInput(input, errorElement, message) {
        const value = input.value.trim();
        if (value === "") {
            input.style.border = "2px solid red";
            errorElement.style.display = "block";
            errorElement.innerText = message;
            return false;
        } else {
            input.style.border = "2px solid green";
            errorElement.style.display = "none";
            return true;
        }
    }

    TenCoSoInput.addEventListener("blur", function () {
        validateInput(TenCoSoInput, TenCoSoError, "Tên Cơ Sở không được trống");
    });

    DiaChiInput.addEventListener("blur", function () {
        validateInput(DiaChiInput, DiaChiError, "Địa chỉ không được trống");
    });
});
</script>

<?php
include_once("controller/cCoSo.php");
$pcs = new cCoSo();

if (isset($_POST['btnThemCoSo'])) {
    // Lấy dữ liệu từ form
    $tenCoSo = $_POST['TenCoSo'];
    $DiaChi = $_POST['DiaChi'];
    $moTa = $_POST['MoTa'];

    $kq = $pcs->insertCoSo($tenCoSo, $DiaChi, $moTa, $maChuSan);
               
                if ($kq) {
                    echo "<script>alert('Thêm cơ sở thành công!')</script>";
                    echo '<script>window.location.href="admin.php?coso";</script>';

                } else {
                    
                    echo "<script>alert('Thêm cơ sở thất bại')</script>";
                    echo '<script>window.location.href="admin.php?action=addCoSo";</script>';        
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