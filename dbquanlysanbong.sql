-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 09, 2024 lúc 05:39 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dbquanlysanbong`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdondatsan`
--

CREATE TABLE `chitietdondatsan` (
  `MaChiTietDonDatSan` int(11) NOT NULL,
  `NgayNhanSan` date NOT NULL,
  `ThoiGianBatDau` time DEFAULT NULL,
  `ThoiGianKetThuc` time DEFAULT NULL,
  `MaDonDatSan` int(11) DEFAULT NULL,
  `MaSanBong` int(11) DEFAULT NULL,
  `DonGia` int(11) DEFAULT NULL,
  `ThoiLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chusan`
--

CREATE TABLE `chusan` (
  `MaChuSan` int(11) NOT NULL,
  `TenChuSan` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `MatKhau` varchar(255) DEFAULT NULL,
  `SDT` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `GioiTinh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `chusan`
--

INSERT INTO `chusan` (`MaChuSan`, `TenChuSan`, `Email`, `MatKhau`, `SDT`, `DiaChi`, `GioiTinh`) VALUES
(1, 'Nguyễn Văn Trung', 'nguyenvantrung@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0779056430', '123 Phạm Văn Đồng', 1),
(2, 'Trần Thị Bảo Châu', 'tranthibaochau@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0325379177', '456 Bạch Đằng', 0),
(3, 'Lê Văn Việt Đức', 'levanvietduc@example.com', 'e10adc3949ba59abbe56e057f20f883e', '0969456328', '789 Lê Lợi', 1),
(4, 'Đào Đặng Thùy Vy', 'daodangthuyvy@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '0792708732', '530 Lâm Văn Bền', 0),
(5, 'Phạm Thanh Nguyên', 'phamthanhnguyen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0792441286', '23 Tô Vĩnh Diệm', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coso`
--

CREATE TABLE `coso` (
  `MaCoSo` int(11) NOT NULL,
  `TenCoSo` varchar(255) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `MaChuSan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `coso`
--

INSERT INTO `coso` (`MaCoSo`, `TenCoSo`, `DiaChi`, `MoTa`, `MaChuSan`) VALUES
(1, 'Sân bóng Thống Nhất', '138 Đào Duy Từ, P.6 Q.10 TP.Hồ Chí Minh', 'Sân bóng đá trung tâm, thích hợp với các giải đấu lớn nhỏ và hoạt động cộng đồng', 3),
(2, 'Sân bóng Cầu Diễn', '136 Cầu Diễn, Quận Bắc Từ Liêm, Hà Nội', 'Sân bóng tiêu chuẩn với hệ thống đèn chiếu hiện đại, phục vụ các trận đấu buổi tối', 2),
(3, 'Sân bóng Lạch Lay', '19 Lạch Lay, Ngô Quyền, Hải Phòng', 'Sân bóng đạt tiêu chuẩn quốc tế, thường tổ chức các giải đấu cấp thành phố và khu vực', 1),
(4, 'Sân bóng Hòa Xuân', 'Đường Hòa Xuân, Cẩm Lệ, Đà Nẵng', 'Cơ sở sân cỏ chất lượng cao, rất thu hút các đội bóng trong khu vực', 3),
(5, 'Sân bóng Mỹ Định', '128, Nam Từ Liêm, Hà Nội', 'Sân bóng lớn, phục phụ cho các trận bóng nhiệt huyết', 5),
(6, 'Sân bóng Bình Phước', 'Đường Trần Hưng Đạo, Phước Bình, Bình Phước', 'Sân bóng phục vụ cho các cầu thủ với những tiện ích tuyệt vời', 4),
(7, 'Sân bóng Bình Dương', 'Đường Cách Mạng Tháng 8, Phú Cường, Thủ Dầu Một, Bình Dương', 'Sân bóng được trang bị đèn chiếu sáng và khu vực ngồi xem rộng rãi', 1),
(8, 'Sân bóng Tân Hiệp', 'Tân Hiệp, Tân Uyên, Bình Dương', 'sân bóng có chất lượng tốt, được các đội bóng phong trào lựa chọn tập luyện', 2),
(9, 'Sân bóng Vinh', '1 Trường Thi, TP Vinh, Nghệ An', 'Cơ sở phục vụ các giải đấu từ bình dân đến chuyên nghiệp tại khu vực Miền Trung', 4),
(10, 'Sân bóng Rạch Giá', '27 Nguyễn Trung Trực, Rạch Giá, Kiên Giang', 'Sân bóng nằm giữa khu vực trung tâm, thuận tiện cho các đội bóng địa phương vui chơi và tập luyện', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondatsan1`
--

CREATE TABLE `dondatsan1` (
  `MaDonDatSan` int(11) NOT NULL,
  `MaKhachHang` int(11) DEFAULT NULL,
  `TenKhachHang` varchar(255) NOT NULL,
  `MaSanBong` int(11) DEFAULT NULL,
  `NgayDat` date DEFAULT NULL,
  `GioBatDau` time NOT NULL,
  `GioKetThuc` time NOT NULL,
  `TongTien` decimal(10,0) DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `dondatsan1`
--

INSERT INTO `dondatsan1` (`MaDonDatSan`, `MaKhachHang`, `TenKhachHang`, `MaSanBong`, `NgayDat`, `GioBatDau`, `GioKetThuc`, `TongTien`, `TrangThai`) VALUES
(53, 13, 'Nguyễn Chí Thanh', 3, '2024-12-11', '18:24:00', '21:24:00', '360000', 'Chờ duyệt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giathue`
--

CREATE TABLE `giathue` (
  `MaGiaThue` int(11) NOT NULL,
  `ThoiGianBatDau` time DEFAULT NULL,
  `ThoiGianKetThuc` time DEFAULT NULL,
  `Gia` int(11) DEFAULT NULL,
  `MaLoaiSanBong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `giathue`
--

INSERT INTO `giathue` (`MaGiaThue`, `ThoiGianBatDau`, `ThoiGianKetThuc`, `Gia`, `MaLoaiSanBong`) VALUES
(1, '06:00:00', '12:00:00', 100000, 1),
(2, '13:00:00', '23:00:00', 120000, 1),
(3, '06:00:00', '12:00:00', 150000, 2),
(4, '13:00:00', '23:00:00', 170000, 2),
(5, '06:00:00', '12:00:00', 200000, 3),
(6, '13:00:00', '23:00:00', 250000, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKhachHang` int(11) NOT NULL,
  `TenKhachHang` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `SDT` varchar(255) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `GioiTinh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKhachHang`, `TenKhachHang`, `Email`, `SDT`, `MatKhau`, `DiaChi`, `GioiTinh`) VALUES
(1, 'Nguyễn Thị Lan Anh', 'lananh.nguyen@gmail.com', '0908765432', 'e10adc3949ba59abbe56e057f20f883e', '54 Trần Hưng Đạo, Quận 1, TP Hồ Chí Minh', 0),
(2, 'Trần Minh Khoa', 'minh.khoa.tran@gmail.com', '0932456789', 'e10adc3949ba59abbe56e057f20f883e', '101 Nguyễn Huệ, Quận 1, TP.Hồ Chí Minh', 1),
(3, 'Lê Hồng Phúc', 'lephuc.hong@gmail.com', '0978645321', 'e10adc3949ba59abbe56e057f20f883e', '72 Lý Tự Trong, Quận Hải Châu, Đà Nẵng', 1),
(4, 'Phạm Thị Hương', 'phamhuong1987@gmail.com', '09023456789', 'e10adc3949ba59abbe56e057f20f883e', '135 Đinh Tiên Hoàng, Quận Bình Thạnh, TP.Hồ Chí Minh', 0),
(5, 'Đặng Quốc Vinh', 'quocvinhdang@gmail.com', '0919876532', 'e10adc3949ba59abbe56e057f20f883e', '25 Nguyễn Thị Minh Khai, Quận Ninh Kiều, Cần Thơ', 1),
(6, 'Vũ Thanh Hà', 'thanhha.vu@gmail.com', '0932765890', 'e10adc3949ba59abbe56e057f20f883e', '42 Hoàng Hoa Thám, Quận Thanh Khê, Đà Nẵng', 1),
(7, 'Nguyễn Xuân Bách', 'bachxuan.nguyen@gmail.com', '0908654359', 'e10adc3949ba59abbe56e057f20f883e', '10 Lê Văn Sỹ, Quận Phú Nhuận, TP. Hồ Chí Minh', 1),
(8, 'Trương Thị Mai', 'truongthimai1980@gmail.com', '0987654235', 'e10adc3949ba59abbe56e057f20f883e', '20 Trần Phú, Quận Ba Đình, Hà Nội', 0),
(9, 'Kh Giả', 'luongthat2003@gmail.com', '0971245678', 'c56d0e9a7ccec67b4ea131655038d604', '89 Võ Thị Sáu, Quận 3, TP.Hồ Chí Minh', 1),
(13, 'Nguyễn Chí Thanh', 'NCT@gmail.com', '0328362054', 'e10adc3949ba59abbe56e057f20f883e', '60/18 HKA', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisan`
--

CREATE TABLE `loaisan` (
  `MaLoaiSan` int(11) NOT NULL,
  `TenLoai` varchar(255) NOT NULL,
  `MoTa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `loaisan`
--

INSERT INTO `loaisan` (`MaLoaiSan`, `TenLoai`, `MoTa`) VALUES
(1, 'Sân 5', 'Sân bóng dành cho đội 3-5. Kích thước 25-42m chiều dài, 15-25m chiều rộng'),
(2, 'Sân 7', 'Sân dành cho đội 7-10 người. Kích thước 50-75m chiều dài, 30-50m chiều rộng'),
(3, 'Sân 11', 'Sân dành cho đội 11 người trở lên. Kích thước 90-120m chiều dài, 45-90m chiều rộng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNhanVien` int(11) NOT NULL,
  `TenNhanVien` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `SDT` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `GioiTinh` int(11) DEFAULT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `MaChuSan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNhanVien`, `TenNhanVien`, `Email`, `SDT`, `DiaChi`, `GioiTinh`, `MatKhau`, `MaChuSan`) VALUES
(1, 'Trần Thị Mai Linh', 'mailinh.tran@gmail.com', '0901256794', '15 Nguyễn Đình Chiểu, Quận 1, TP.Hồ Chí Minh', 0, 'c56d0e9a7ccec67b4ea131655038d604', 3),
(2, 'Nguyễn Văn Hùng', 'vanhungnguyen@gmail.com', '0946420358', '60 Lý Thường Kiệt, Quận Hoàn Kiếm, Hà Nội', 1, 'e10adc3949ba59abbe56e057f20f883e', 2),
(3, 'Phạm Quang Minh', 'phamquangminh@gmail.com', '0982642398', '20 Hai Bà Trưng, Quận Ninh Kiều, Cần Thơ', 1, 'e10adc3949ba59abbe56e057f20f883e', 4),
(4, 'Lê Thị Thảo', 'lethithao@gmail.com', '0923154690', '32 Phan Đăng Lưu, Quận Hải Châu, Đà Nẵng', 0, 'e10adc3949ba59abbe56e057f20f883e', 1),
(5, 'NV Ngọc Thật', 'rya07661@gmail.com', '01202893949', '45 Nguyễn Văn Linh, Quận 7, TP.Hồ Chí Minh', 1, 'e10adc3949ba59abbe56e057f20f883e', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quantrihethong`
--

CREATE TABLE `quantrihethong` (
  `MaQuanTri` int(11) NOT NULL,
  `TenQuanTri` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `matKhau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `quantrihethong`
--

INSERT INTO `quantrihethong` (`MaQuanTri`, `TenQuanTri`, `Email`, `matKhau`) VALUES
(1, 'Admin', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanbong`
--

CREATE TABLE `sanbong` (
  `MaSanBong` int(11) NOT NULL,
  `TenSanBong` varchar(255) NOT NULL,
  `ThoiGianHoatDong` varchar(255) DEFAULT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `MaNhanVien` int(11) DEFAULT NULL,
  `MaLoaiSan` int(11) DEFAULT NULL,
  `MaCoSo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `sanbong`
--

INSERT INTO `sanbong` (`MaSanBong`, `TenSanBong`, `ThoiGianHoatDong`, `MoTa`, `HinhAnh`, `MaNhanVien`, `MaLoaiSan`, `MaCoSo`) VALUES
(1, 'Thống nhất 01', '6:00 - 22:00', 'Sân cỏ nhân tạo, kích thước chuẩn 7 người', 'thong-nhat-01.jpg', 1, 2, 1),
(2, 'Thống Nhất 02', '6:00 - 22:00', 'Sân có đèn chiếu sáng, phù hợp tổ chức giải đấu nhỏ', 'thong-nhat-02.jpg', 1, 3, 1),
(3, 'Thống Nhất 03', '6:00 - 20:00', 'Sân bóng cỏ tự nhiên, chất lượng cao', 'thong-nhat-03.jpg', 1, 1, 1),
(4, 'Cầu Diễn 01', '5:30 - 22:30', 'Sân bóng có hệ thống phun sương làm mát', 'cau-dien-01.jpg', 2, 1, 2),
(5, 'Cầu Diễn 02', '5:30 - 22:30', 'Sân bóng có hệ thống phun sương làm mát', 'cau-dien-02.jpg', 2, 2, 2),
(6, 'Cầu Diễn 03', '5:30 - 22:30', 'Sân bóng có hệ thống phun sương làm mát', 'cau-dien-03.jpg', 2, 3, 2),
(7, 'Lạch Lay 01', '6:30 - 23:00', 'Sân cỏ có mái che, phù hợp với mọi thời tiết', 'lach-lay-01.jpg', 4, 1, 3),
(8, 'Lạch Lay 02', '6:30 - 23:00', 'Sân cỏ có mái che, phù hợp với mọi thời tiết', 'lach-lay-02.jpg', 4, 2, 3),
(9, 'Lạch Lay 03', '6:30 - 23:00', 'Sân cỏ có mái che, phù hợp với mọi thời tiết', 'lach-lay-03.jpg', 4, 3, 3),
(10, 'Hòa Xuân 01', '7:00 - 23:00', 'Sân có chỗ ngồi rộng lớn cho khán giả', 'hoa-xuan-01.jpg', 1, 1, 4),
(11, 'Hòa Xuân 02', '7:00 - 23:00', 'Sân có chỗ ngồi rộng lớn cho khán giả', 'hoa-xuan-02.jpg', 1, 2, 4),
(12, 'Hòa Xuân 03', '7:00 - 23:00', 'Sân có chỗ ngồi rộng lớn cho khán giả', 'hoa-xuan-03.jpg', 1, 3, 4),
(13, 'Mỹ Định 01', '6:00 - 21:00', 'Sân chuyên dụng cho trẻ em và thiếu niên', 'my-dinh-01.jpg', 5, 1, 5),
(14, 'Mỹ Định 02', '6:00 - 21:00', 'Sân chuyên dụng cho trẻ em và thiếu niên', 'my-dinh-02.jpg', 5, 2, 5),
(15, 'Mỹ Định 03', '6:00 - 21:00', 'Sân chuyên dụng cho trẻ em và thiếu niên', 'my-dinh-03.jpg', 5, 3, 5),
(16, 'Bình Phước 01', '7:00 - 23:00', 'Sân cỏ tự nhiên, có khu vực cho tác giả', 'binh-phuoc-01.jpg', 3, 1, 6),
(17, 'Bình Phước 02', '7:00 - 23:00', 'Sân cỏ tự nhiên, có khu vực cho tác giả', 'binh-phuoc-02.jpg', 3, 2, 6),
(18, 'Bình Phước 03', '7:00 - 23:00', 'Sân cỏ tự nhiên, có khu vực cho tác giả', 'binh-phuoc-03.jpg', 3, 3, 6);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdondatsan`
--
ALTER TABLE `chitietdondatsan`
  ADD PRIMARY KEY (`MaChiTietDonDatSan`),
  ADD KEY `MaDonDatSan` (`MaDonDatSan`),
  ADD KEY `MaSanBong` (`MaSanBong`);

--
-- Chỉ mục cho bảng `chusan`
--
ALTER TABLE `chusan`
  ADD PRIMARY KEY (`MaChuSan`);

--
-- Chỉ mục cho bảng `coso`
--
ALTER TABLE `coso`
  ADD PRIMARY KEY (`MaCoSo`),
  ADD KEY `MaChuSan` (`MaChuSan`);

--
-- Chỉ mục cho bảng `dondatsan1`
--
ALTER TABLE `dondatsan1`
  ADD PRIMARY KEY (`MaDonDatSan`),
  ADD KEY `MaKhachHang` (`MaKhachHang`),
  ADD KEY `MaSanBong` (`MaSanBong`);

--
-- Chỉ mục cho bảng `giathue`
--
ALTER TABLE `giathue`
  ADD PRIMARY KEY (`MaGiaThue`),
  ADD KEY `MaSanBong` (`MaLoaiSanBong`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKhachHang`);

--
-- Chỉ mục cho bảng `loaisan`
--
ALTER TABLE `loaisan`
  ADD PRIMARY KEY (`MaLoaiSan`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNhanVien`),
  ADD KEY `MaChuSan` (`MaChuSan`);

--
-- Chỉ mục cho bảng `quantrihethong`
--
ALTER TABLE `quantrihethong`
  ADD PRIMARY KEY (`MaQuanTri`);

--
-- Chỉ mục cho bảng `sanbong`
--
ALTER TABLE `sanbong`
  ADD PRIMARY KEY (`MaSanBong`),
  ADD KEY `MaLoaiSan` (`MaLoaiSan`),
  ADD KEY `MaNhanVien` (`MaNhanVien`),
  ADD KEY `MaCoSo` (`MaCoSo`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdondatsan`
--
ALTER TABLE `chitietdondatsan`
  MODIFY `MaChiTietDonDatSan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `chusan`
--
ALTER TABLE `chusan`
  MODIFY `MaChuSan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `coso`
--
ALTER TABLE `coso`
  MODIFY `MaCoSo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `dondatsan1`
--
ALTER TABLE `dondatsan1`
  MODIFY `MaDonDatSan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `giathue`
--
ALTER TABLE `giathue`
  MODIFY `MaGiaThue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKhachHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `loaisan`
--
ALTER TABLE `loaisan`
  MODIFY `MaLoaiSan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNhanVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `quantrihethong`
--
ALTER TABLE `quantrihethong`
  MODIFY `MaQuanTri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `sanbong`
--
ALTER TABLE `sanbong`
  MODIFY `MaSanBong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdondatsan`
--
ALTER TABLE `chitietdondatsan`
  ADD CONSTRAINT `chitietdondatsan_ibfk_1` FOREIGN KEY (`MaDonDatSan`) REFERENCES `dondatsan1` (`MaDonDatSan`);

--
-- Các ràng buộc cho bảng `coso`
--
ALTER TABLE `coso`
  ADD CONSTRAINT `coso_ibfk_1` FOREIGN KEY (`MaChuSan`) REFERENCES `chusan` (`MaChuSan`);

--
-- Các ràng buộc cho bảng `dondatsan1`
--
ALTER TABLE `dondatsan1`
  ADD CONSTRAINT `dondatsan1_ibfk_1` FOREIGN KEY (`MaKhachHang`) REFERENCES `khachhang` (`MaKhachHang`),
  ADD CONSTRAINT `dondatsan1_ibfk_2` FOREIGN KEY (`MaSanBong`) REFERENCES `sanbong` (`MaSanBong`);

--
-- Các ràng buộc cho bảng `giathue`
--
ALTER TABLE `giathue`
  ADD CONSTRAINT `giathue_ibfk_1` FOREIGN KEY (`MaLoaiSanBong`) REFERENCES `loaisan` (`MaLoaiSan`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`MaChuSan`) REFERENCES `chusan` (`MaChuSan`);

--
-- Các ràng buộc cho bảng `sanbong`
--
ALTER TABLE `sanbong`
  ADD CONSTRAINT `sanbong_ibfk_1` FOREIGN KEY (`MaLoaiSan`) REFERENCES `loaisan` (`MaLoaiSan`),
  ADD CONSTRAINT `sanbong_ibfk_2` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`),
  ADD CONSTRAINT `sanbong_ibfk_3` FOREIGN KEY (`MaCoSo`) REFERENCES `coso` (`MaCoSo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
