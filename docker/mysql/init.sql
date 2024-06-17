create table users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     username varchar(255),
     password varchar(255),
     role varchar(255)
);

CREATE table students (
	id INT auto_increment UNIQUE,
    code varchar(255) PRIMARY KEY,
    username varchar(255),
    email varchar(255) UNIQUE,
    department varchar(255),
    major varchar(255)
);

INSERT INTO students(code, username, email, department, major) VALUES
('SV215213', 'Trần Phước Anh Quốc', 'anhquoc18092003@gmail.com' ,'Công nghệ phần mềm', 'Kỹ thuật phần mềm'),
('SV215214', 'Trần Phước Long', 'phuoclong18092003@gmail.com', 'Công nghệ phần mềm', 'Kỹ thuật phần mềm'),
('SV215215', 'Lê Thị Thu Hiền', 'thuhien18092003@gmail.com', 'Công nghệ phần mềm', 'Kỹ thuật phần mềm'),
('SV215212', 'Mai Đình Khôi', 'dinhkhoi18092003@gmail.com', 'Công nghệ phần mềm', 'Kỹ thuật phần mềm'),
('SV215218', 'Trần Vương Duy', 'vuongduy18092003@gmail.com', 'Hệ thống thông tin', 'Kỹ thuật máy tính'),
('SV215219', 'Trương Nguyễn Phước Trí', 'phuoctri18092003@gmail.com', 'Thương mại điện tử', 'Khoa học máy tính'),
('SV215210', 'Hồ Thị Thanh Thảo', 'thanhthao18092003@gmail.com', 'Hệ thống thông tin', 'Thương mại điện tử');