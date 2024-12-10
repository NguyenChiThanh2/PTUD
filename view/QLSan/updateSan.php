<?php
include_once('controller/cSan.php');
$psb = new cSan();

// Kiểm tra mã sân bóng đã có trong URL hay chưa
if (isset($_GET['MaSanBong'])) {
    $maSanBong = $_GET['MaSanBong'];
    $maChuSan = $_GET['MaChuSan'];

    // Lấy thông tin sân bóng từ DB
    $sanBong = $psb->getInfo1San($maSanBong, $maChuSan);
    if ($sanBong) {
        $sanBongData = mysqli_fetch_assoc($sanBong);
        if ($sanBongData) {
            $tenSanBong = $sanBongData['TenSanBong'];
            $loaiSan = $sanBongData['MaLoaiSan'];
            $giathue1 = $sanBongData['Gia'];
            $moTaSan = $sanBongData['MoTa'];
            
            $thoiGianHoatDong = $sanBongData['ThoiGianHoatDong'];
            $parts = explode(" - ", $thoiGianHoatDong);
            $giobatdau = date("H:i", strtotime($parts[0] ?? '')); // Chuyển 6:00 AM thành 06:00
            $giokethuc = date("H:i", strtotime($parts[1] ?? '')); // Chuyển 6:00 PM thành 18:00

            $maNhanVien = $sanBongData['MaNhanVien'];
            $tenNV = $sanBongData['TenNhanVien'];
            $HinhAnh = $sanBongData['HinhAnh'];
            $maCoSo = $sanBongData['MaCoSo'];
            $maLoaiSan = $sanBongData['MaLoaiSan'];
        }
    } else {
        echo "<script>alert('Sân bóng không tồn tại!');</script>";
        header("refresh:0; url='admin.php'");
        exit();
    }
}
?>

<h2 align="center">Cập Nhật Sân Bóng</h2>
<form action="" method="post" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label for="TenSan">Tên Sân Bóng</label>
        <input type="text" id="TenSan" name="TenSan" required value="<?php echo htmlspecialchars($tenSanBong ?? '', ENT_QUOTES); ?>">
        <small class="error-message" style="color: red; display: none;">Tên không hợp lệ!</small>
    </div>
    <div class="form-group">
        <label for="LoaiSan">Loại Sân</label>
        <select id="LoaiSan" name="LoaiSan" required onchange="updatePrice()">
            <?php
            include_once("controller/cLoaiSan.php");
            $pls = new cLoaiSan();
            $kqls = $pls->GetALLLoaiSan();
            
            if ($kqls) {
                while ($row = mysqli_fetch_assoc($kqls)) {
                    $selected = ($row['MaLoaiSan'] == $loaiSan) ? "selected" : "";
                    echo "<option value='{$row['MaLoaiSan']}' data-price='{$row['Gia']}' $selected>{$row['TenLoai']}</option>";
                }
            } else {
                echo "<option value=''>Không có loại sân nào</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="GiaThueSang">Giá thuê sáng</label>
        <input type="text" id="GiaThueSang" name="GiaThueSang" readonly>
    </div>

    <div class="form-group">
        <label for="GiaThueChieu">Giá thuê chiều</label>
        <input type="text" id="GiaThueChieu" name="GiaThueChieu" readonly>
    </div>

    <div class="form-group">
        <label for="MoTaSan">Mô Tả Sân</label>
        <textarea id="MoTaSan" name="MoTaSan"><?php echo htmlspecialchars($moTaSan ?? ''); ?></textarea>
    </div>

    <div class="form-group">
    <label for="GioMoCua">Giờ Mở Cửa</label>
    <input type="time" id="GioMoCua" name="GioMoCua" 
    value="<?php echo htmlspecialchars($giobatdau ?? '', ENT_QUOTES); ?>" required>
    <label for="GioDongCua">Giờ Đóng Cửa</label>

    <input type="time" id="GioDongCua" name="GioDongCua" 
    value="<?php echo htmlspecialchars($giokethuc ?? '', ENT_QUOTES); ?>" required>


        <small class="error-message" style="color: red; display: none;">Thời gian không hợp lệ!</small>
    </div>
    </div>

    <div class="form-group">
        <label for="MaNhanVien">Nhân Viên Quản Lí</label>
        <select id="MaNhanVien" name="MaNhanVien" required>
            <?php
            include_once("controller/cNhanVien.php");
            $pnv = new cNhanVien();
            $kqnv = $pnv->getNhanVienByMaChuSan($maChuSan);
            
            if ($kqnv) {
                while ($row = mysqli_fetch_assoc($kqnv)) {
                    $selected = ($row['MaNhanVien'] == $maNhanVien) ? "selected" : "";
                    echo "<option value='{$row['MaNhanVien']}' $selected>{$row['TenNhanVien']}</option>";
                }
            } else {
                echo "<option value=''>Không có nhân viên nào</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="MaCoSo">Cơ Sở</label>
        <select id="MaCoSo" name="MaCoSo" required>
            <?php
            include_once("controller/cCoSo.php");
            $pnv = new cCoSo();
            $kqnv = $pnv->GetCoSoByMaChuSan($maChuSan);
            
            if ($kqnv) {
                while ($row = mysqli_fetch_assoc($kqnv)) {
                    $selected = ($row['MaCoSo'] == $maCoSo) ? "selected" : "";
                    echo "<option value='{$row['MaCoSo']}' $selected>{$row['TenCoSo']}</option>";
                }
            } else {
                echo "<option value=''>Không có nhân viên nào</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="HinhAnh">Hình Ảnh Sân</label>
        <?php
        if (!empty($HinhAnh)) {
            echo "<img src='img/SanBong/$HinhAnh' alt='Ảnh Sân' style='max-width: 200px; margin-bottom: 10px;'>";
        }
        ?>
        <input type="file" id="HinhAnh" name="HinhAnh" accept="image/*">
    </div>

    <div class="form-group" style="display: flex; justify-content: space-between;">
        <input type="submit" name="btnCapNhatSan" value="Cập Nhật Sân">
        <input type="reset" value="Hủy" onclick="history.back();">
    </div>
</form>

<script>
        document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử DOM
    const errorMessage = document.querySelector(".error-message");
    const form = document.querySelector(".form-container");
    const thoiGianHoatDongInput = document.getElementById("ThoiGianHoatDong");
    const tenSanInput = document.getElementById("TenSan");
    const loaiSanSelect = document.getElementById("LoaiSan");
    const giaThueSang = document.getElementById("GiaThueSang");
    const giaThueChieu = document.getElementById("GiaThueChieu");

    // Hàm kiểm tra tên sân hợp lệ
    function validateTenSan() {
        const tenSanValue = tenSanInput.value.trim();
        const errorElement = document.querySelector(".error-message");

        if (tenSanValue === "" || tenSanValue.length < 3) {
            tenSanInput.style.border = "2px solid red"; // Viền đỏ nếu không hợp lệ
            errorElement.style.display = "block";
            errorElement.innerText = "Tên sân phải có ít nhất 3 ký tự!";
            return false;
        } else {
            tenSanInput.style.border = "2px solid green"; // Viền xanh nếu hợp lệ
            errorElement.style.display = "none";
            return true;
        }
    }

    // Hàm kiểm tra thời gian hoạt động hợp lệ
        function validateThoiGianHoatDong() {
        const value = thoiGianHoatDongInput.value.trim();
        const errorElement = thoiGianHoatDongInput.nextElementSibling;

        // Điều chỉnh regex để hỗ trợ định dạng giờ từ 1 chữ số hoặc 2 chữ số
        const regex = /^([1-9]|1[0-9]|2[0-3]):[0-5][0-9]\s-\s([1-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;

        // Kiểm tra định dạng thời gian
        if (!regex.test(value)) {
            thoiGianHoatDongInput.style.border = "2px solid red";
            errorElement.style.display = "block";
            errorElement.innerText = "Thời gian hoạt động phải theo định dạng: HH:MM - HH:MM (Ví dụ: 6:00 - 23:00)";
            return false;
        }

        // Tách giờ bắt đầu và kết thúc
        const [start, end] = value.split(" - ");

        // Hàm chuyển đổi thời gian thành số phút kể từ 00:00
        function convertToMinutes(time) {
            const [hour, minute] = time.split(":");
            let hourInt = parseInt(hour);
            let minuteInt = parseInt(minute);

            // Tính tổng số phút từ 00:00
            return hourInt * 60 + minuteInt;
        }

        const startTimeInMinutes = convertToMinutes(start);
        const endTimeInMinutes = convertToMinutes(end);

        // Kiểm tra giờ kết thúc phải lớn hơn giờ bắt đầu
        if (startTimeInMinutes >= endTimeInMinutes) {
            thoiGianHoatDongInput.style.border = "2px solid red";
            errorElement.style.display = "block";
            errorElement.innerText = "Giờ kết thúc phải lớn hơn giờ bắt đầu.";
            return false;
        }

        // Nếu hợp lệ, hiển thị thông báo đúng
        thoiGianHoatDongInput.style.border = "2px solid green";
        errorElement.style.display = "none";
        return true;
    }





    // Hàm cập nhật giá thuê dựa vào loại sân
 

    // Gán sự kiện khi rời khỏi ô nhập thời gian hoạt động
    thoiGianHoatDongInput.addEventListener("blur", validateThoiGianHoatDong);

    // Gán sự kiện khi rời khỏi ô nhập tên sân
    tenSanInput.addEventListener("blur", validateTenSan);

    // Gán sự kiện onchange cho loại sân
    loaiSanSelect.addEventListener("change", updatePrice);

    // Xử lý khi submit form
   
});   
    
// Lấy giá trị loại sân từ PHP
const maLoaiSan = "<?php echo $maLoaiSan; ?>"; // PHP to JS

// Giả sử bạn có các biến tham chiếu đến các phần tử trên trang HTML:
const loaiSanSelect = document.getElementById("LoaiSan"); // Dropdown để chọn loại sân
const giaThueSang = document.getElementById("GiaThueSang"); // Element hiển thị giá thuê sáng
const giaThueChieu = document.getElementById("GiaThueChieu"); // Element hiển thị giá thuê chiều

// Hàm cập nhật giá
function updatePrice() {
    const maLoaiSan = loaiSanSelect.value;

    // Sử dụng switch để thay đổi giá theo loại sân
    switch (maLoaiSan) {
        case "1":
            giaThueSang.value = "100,000"; // Giá thuê sáng cho loại sân 1
            giaThueChieu.value = "120,000"; // Giá thuê chiều cho loại sân 1
            break;
        case "2":
            giaThueSang.value = "150,000"; // Giá thuê sáng cho loại sân 2
            giaThueChieu.value = "170,000"; // Giá thuê chiều cho loại sân 2
            break;
        case "3":
            giaThueSang.value = "200,000"; // Giá thuê sáng cho loại sân 3
            giaThueChieu.value = "250,000"; // Giá thuê chiều cho loại sân 3
            break;
        default:
            giaThueSang.value = "..."; // Hiển thị dấu ba chấm nếu không có giá
            giaThueChieu.value = "..."; // Hiển thị dấu ba chấm nếu không có giá
            break;
    }
}

// Thêm sự kiện để gọi hàm updatePrice khi người dùng chọn loại sân
loaiSanSelect.addEventListener('change', updatePrice);

// Gọi hàm ngay lần đầu để hiển thị giá mặc định khi trang được tải
updatePrice();
</script>

<?php
// Xử lý form cập nhật thông tin sân bóng
if (isset($_POST['btnCapNhatSan'])) {
    $tenSanBong = $_POST['TenSan'];
    $loaiSan = $_POST['LoaiSan'];

    $moTaSan = $_POST['MoTaSan'];
    $giomocua = $_POST['GioMoCua'];
    $giodongcua = $_POST['GioDongCua'];
    $thoiGianHoatDong = $giomocua.' - '.$giodongcua;
    $maNhanVien = $_POST['MaNhanVien'];
    $maCoSo = $_POST['MaCoSo'];
   
    
    
    // Xử lý ảnh
    $newFileName = null;
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "img/SanBong/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
        $fileName = basename($_FILES['HinhAnh']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid('sanbong_') . '.' . $fileExtension;
            $destPath = $targetDir . $newFileName;
            move_uploaded_file($fileTmpPath, $destPath);

            if (!empty($sanBongData['HinhAnh']) && file_exists($targetDir . $sanBongData['HinhAnh'])) {
                unlink($targetDir . $sanBongData['HinhAnh']);
            }
        } else {
            echo "Chỉ cho phép tải lên các định dạng ảnh: jpg, jpeg, png, gif.";
        }
    } else {
        $newFileName = $sanBongData['HinhAnh'];
    }
    
    // Cập nhật thông tin sân bóng
    $result = $psb->
    updateSanBong($maSanBong, $tenSanBong, $loaiSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $newFileName, $maCoSo);
    if ($result) {
        echo "<script>alert('Cập nhật sân bóng thành công!');</script>";
        echo '<script>window.location.href="admin.php?sanbong";</script>';
        exit();
    } else {
        echo "<script>alert('Cập nhật sân bóng thất bại!');</script>";
        echo '<script>window.location.href="admin.php?action=updateSanBong&MaSanBong=' . $maSanBong . '&MaChuSan=' . $maChuSan . '";</script>';
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
