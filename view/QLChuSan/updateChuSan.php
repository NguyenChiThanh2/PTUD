<?php
include_once('controller/cChuSan.php');
$pkh = new ControllerChuSan();

// Kiểm tra mã sân bóng đã có trong URL hay chưa
if (isset($_GET['MaChuSan'])) {
    $maChuSan = $_GET['MaChuSan'];
 //   $maChuSan = $_GET['MaChuSan'];

    // Lấy thông tin sân bóng từ DB
    $ChuSan = $pkh->GetChuSanByMaChuSan($maChuSan);
    if ($ChuSan) {
        $ChuSanData = mysqli_fetch_assoc($ChuSan);
        if ($ChuSanData) {
            $tenChuSan = $ChuSanData['TenChuSan'] ?? '';
            $diachi = $ChuSanData['DiaChi'] ?? '';
            $SDT = $ChuSanData['SDT'] ?? '';
            $email = $ChuSanData['Email'] ?? '';
            $gioitinh = $ChuSanData['GioiTinh'] ?? '';
            $matkhau = $ChuSanData['MatKhau'] ?? '';
        } else {
            echo "<script>alert('Không tìm thấy dữ liệu cơ sở!');</script>";
            header("refresh:0; url='admin.php?chusan'");
            exit();
        }
    } else {
        echo "<script>alert('Khách hàng không tồn tại!');</script>";
        header("refresh:0; url='admin.php?chusan'");
        exit();
    }
} else {
    echo "<script>alert('Thông tin không hợp lệ!');</script>";
    header("refresh:0; url='admin.php'");
    exit();
}
?>

<h2 align="center">Cập Nhật Chủ Sân</h2>
<form action="" method="POST" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label for="tenChuSan">Tên Chủ Sân</label>
        <input type="text" id="tenChuSan" name="tenChuSan" required placeholder="VD: Nguyễn Văn An" value="<?php echo htmlspecialchars($tenChuSan, ENT_QUOTES); ?>">
        <small class="error-message" style="color: red; display: none;">Tên không hợp lệ!</small>
    </div>

    <div class="form-group">
        <label for="Email">Email</label>
        <input type="email" id="Email" name="Email" required value="<?php if(isset($email)) echo $email; ?>">
        <small class="error-message" style="color: red; display: none;">Email không hợp lệ!</small>
    </div>
    <div class="form-group">
        <label for="SDT">Số Điện Thoại</label>
        <input type="text" id="SDT" name="SDT" required value="<?php if(isset($SDT)) echo $SDT; ?>">
        <small class="error-message" style="color: red; display: none;">Số điện thoại không hợp lệ!</small>
    </div>
    
    <div class="form-group">
        <label for="DiaChi">Địa Chỉ</label>
        <input id="DiaChi" name="DiaChi" required value="<?php if(isset($diachi)) echo $diachi; ?>"></input>
        <small class="error-message" style="color: red; display: none;">Địa chỉ không hợp lệ!</small>
    </div>
    <div class="form-group">
        <label for="GioiTinh">Giới Tính</label>
        <select id="GioiTinh" name="GioiTinh" required>
            <option value="1" <?php echo (isset($gioitinh) && $gioitinh == 1) ? "selected" : ""; ?>>Nam</option>
            <option value="0" <?php echo (isset($gioitinh) && $gioitinh == 0) ? "selected" : ""; ?>>Nữ</option>
        </select>
    </div>

    <div class="form-group" style="position: relative;">
        <label for="MatKhau">Mật Khẩu</label>
        <input type="password" id="MatKhau" name="MatKhau" required value="<?php if(isset($matkhau)) echo $matkhau; ?>" style="padding-right: 40px;">
            <!-- Biểu tượng con mắt -->
            <span id="togglePassword" style="position: absolute; right: 10px; top: 40px; cursor: pointer;">
                👁️
            </span>
    </div>

    

    
    <div class="form-group" style="display: flex; justify-content: space-between;">
        <input type="submit" name="btnUpdateChuSan" value="Cập Nhật Chủ Sân">
        <input type="reset" value="Hủy" onclick="history.back();">
    </div>
</form>


<script>
    // Regex cho từng loại kiểm tra
    const nameRegex = /^[A-ZÀÁÃẠẢĂẲẰẮẴẶÂẦẪẬẨẤÈẺÉẼẸÊỂẾỀỆỄÌỈÍỊĨÒỎÓỌÕÔỔỐỒỘỖỞƠỚỜỢỠÙÚỦŨỤĐƯỨỪỮỰỬỲỴÝỶỸ][a-zàáãạảăẳằắẵặâầẫậẩấèẻéẽẹêểếềệễìỉíịĩòỏóọõôổốồộỗởơớờợỡùúủũụđưứừữựửỳỵýỷỹ]*(\s[A-ZÀÁÃẠẢĂẲẰẮẴẶÂẦẪẬẨẤÈẺÉẼẸÊỂẾỀỆỄÌỈÍỊĨÒỎÓỌÕÔỔỐỒỘỖỞƠỚỜỢỠÙÚỦŨỤĐƯỪỨỮỰỬỲỴÝỶỸ][a-zàáãạảăẳằắẵặâầẫậẩấèẻéẽẹêểếềệễìỉíịĩòỏóọõôổốồộỗởơớờợỡùúủũụđưứừữựửỳỵýỷỹ]*)*$/u;
    const addressRegex = /^[a-zA-ZÀÁÃẠẢĂẲẰẮẴẶÂẦẪẬẨẤÈẺÉẼẸÊỂẾỀỆỄÌỈÍỊĨÒỎÓỌÕÔỔỐỒỘỖỞƠỚỜỢỠÙÚỨỦŨỤĐƯỪỮỰỬỲỴÝỶỸàáãạảăẳằắẵặâầẫậẩấèẻéẽẹêểếềệễìỉíịĩòỏóọõôổốồộỗởơớờợỡùúủũụđưứừữựửỳỵýỷỹ0-9\s,\/\.]+$/u;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    const phoneRegex = /^(03|07|08|09)[0-9]{8}$/;

    // Hàm kiểm tra dữ liệu
    function validateField(input, regex, errorMessage) {
        const value = input.value.trim(); // Loại bỏ khoảng trắng thừa
        const errorElement = input.nextElementSibling;

        if (!regex.test(value)) {
            input.style.border = "2px solid red"; // Viền đỏ
            errorElement.style.display = "block"; // Hiển thị thông báo lỗi
            errorElement.innerText = errorMessage;
        } else {
            input.style.border = "2px solid green"; // Viền xanh lá cây
            errorElement.style.display = "none"; // Ẩn thông báo lỗi
        }
    }

    // Gán sự kiện blur cho từng ô nhập liệu
    document.getElementById("tenChuSan").addEventListener("blur", function () {
        validateField(this, nameRegex, "Tên không hợp lệ! Tên phải viết hoa chữ cái đầu và không chứa ký tự đặc biệt.");
    });

    document.getElementById("Email").addEventListener("blur", function () {
        validateField(this, emailRegex, "Email không hợp lệ! Vui lòng nhập đúng định dạng xxx@gmail.com.");
    });

    document.getElementById("SDT").addEventListener("blur", function () {
        validateField(this, phoneRegex, "Số điện thoại không hợp lệ! Vui lòng nhập 10 số với đầu số 03, 07, 08 hoặc 09.");
    });

    document.getElementById("DiaChi").addEventListener("blur", function () {
        validateField(this, addressRegex, "Địa chỉ không hợp lệ! Vui lòng nhập địa chỉ hợp lệ.");
    });
</script>

<?php

        if (isset($_POST['btnUpdateChuSan'])) {
            $tenCS = $_POST['tenChuSan'] ?? '';
            $email = $_POST['Email'] ?? '';
            $sdt = $_POST['SDT'] ?? '';
            $matKhau = $_POST['MatKhau'] ?? '';
            $diaChi = $_POST['DiaChi'] ?? '';
            $gioiTinh = $_POST['GioiTinh'] ?? '';

            $matKhau = md5($matKhau);
                    // Gọi hàm cập nhật khách hàng từ model
            $kq = $pkh->updateChuSan($maChuSan, $tenCS, $email, $sdt, $matKhau, $diaChi, $gioiTinh);
           
            if ($kq) {
                echo "<script>alert('Cập nhật chủ sân thành công!');</script>";
                echo "<script>window.location.href = 'admin.php?chusan';</script>";

                exit();
            } else {
                echo "<script>alert('Cập nhật chủ sân thất bại!');</script>";
                echo "<script>window.location.href = 'admin.php?chusan';</script>";
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