<?php
ob_start();
include_once("controller/cDonDatSan.php");
require("PHPMailer-master/src/PHPMailer.php");
require("PHPMailer-master/src/SMTP.php");
require("PHPMailer-master/src/Exception.php");

$p = new cDonDatSan();

if (isset($_REQUEST["printDon"])) {
    $thongTinDon = $p->duyetVaGuiThongTinDonDatSan($_REQUEST["printDon"]);

    if ($thongTinDon) {
        $emailKhachHang = $thongTinDon['Email'];
        $tenKH = $thongTinDon['TenKhachHang'];
        $tenSan = $thongTinDon['TenSanBong'];
        $ngayDat = date("d-m-Y", strtotime($thongTinDon['NgayNhanSan']));
        $gioBatDau = $thongTinDon['ThoiGianBatDau'];
        $gioKetThuc = $thongTinDon['ThoiGianKetThuc'];
        $tongTien = number_format($thongTinDon['TongTien'], 0, ',', '.') ;
        // Tạo nội dung email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->Username = "rya07661@gmail.com";
        $mail->Password = "tcnkzzujjdvjsoel"; // Thay bằng mật khẩu ứng dụng
        $mail->SetFrom("rya07661@gmail.com");
        $mail->Subject = "BẠN ĐÃ ĐẶT SÂN THÀNH CÔNG";
        $mail->CharSet = 'UTF-8';
        $mail->Body = "
    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
        <p>Chào <strong>$tenKH</strong>,</p>
        <p>Đơn đặt sân của bạn đã được <span style='color: #28a745; font-weight: bold;'>duyệt thành công</span>! Dưới đây là thông tin chi tiết:</p>
        <ul style='list-style: none; padding-left: 0;'>
            <li><strong>Tên sân:</strong> $tenSan</li>
            <li><strong>Ngày đặt:</strong> $ngayDat</li>
            <li><strong>Giờ bắt đầu:</strong> $gioBatDau</li>
            <li><strong>Giờ kết thúc:</strong> $gioKetThuc</li>
            <li><strong>Tổng tiền:</strong> $tongTien VND</li>
        </ul>
        <p>Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi.<strong>Trân Trọng Cảm Ơn ❤️</strong>
 </p>
    </div>
";

        $mail->AddAddress($emailKhachHang);

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Thông báo đã được gửi tới email khách hàng.";
        }

        header("Location: admin.php?dondat");
        exit();
    } else {
        echo "Có lỗi xảy ra khi duyệt đơn hoặc gửi email.";
    }
}

ob_end_flush();
?>
