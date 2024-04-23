CREATE TABLE supplier (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(50) NOT NULL,
    supplier_phone VARCHAR(50) NOT NULL,
    supplier_address VARCHAR(50) NOT NULL,
    supplier_email VARCHAR(50) NOT NULL
);

CREATE TABLE customer (
    customer_id varchar(5) PRIMARY KEY,
    customer_name varchar(50) not null,
    customer_address varchar(50) not null,
    customer_phone varchar(10) not null,
    customer_email varchar(50) not null
);

CREATE TABLE employee (
    employee_id varchar(5) PRIMARY KEY,
    employee_name varchar(50) not null,
    employee_phone varchar(10) not null,
    employee_address varchar(50) not null,
    employee_email varchar(50) not null
);

DELIMITER //
CREATE TRIGGER before_insert_employee
BEFORE INSERT ON employee
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    SET new_id = (SELECT COUNT(*) FROM employee) + 1;
    SET NEW.employee_id = CONCAT('NV', LPAD(new_id, 2, '0'));
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_insert_customer
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    SET new_id = (SELECT COUNT(*) FROM customer) + 1;
    SET NEW.customer_id = CONCAT('KH', LPAD(new_id, 2, '0'));
END;
//
DELIMITER ;

CREATE TABLE good_receipt (
  good_receipt_id INT PRIMARY KEY AUTO_INCREMENT,
  supplier_id INT,
  employee_id varchar(5),
  date_good_receipt DATE,
  total float,
  CONSTRAINT fk_supplier_id FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id),
  CONSTRAINT fk_employee_id FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);

CREATE TABLE orders (
  order_id INT PRIMARY KEY AUTO_INCREMENT,
  customer_id varchar(5),
  employee_id varchar(5),
  total float,
  date_buy DATETIME,
  CONSTRAINT fk_id_employee FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
  CONSTRAINT fk_id_customer FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE categories (
	category_id INT PRIMARY KEY AUTO_INCREMENT,
	category_name varchar(50) not null
);
CREATE TABLE product (
	category_id INT,
	product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name varchar(50),
	product_ram INT,
	product_rom INT,
	product_battery INT,
	product_screen float,
    quantity INT,
	product_made_in varchar(50),
	product_year_produce INT,
	product_time_insurance INT,
	product_price INT,
	product_image varchar(50),
	CONSTRAINT fk_category_product FOREIGN KEY (category_id) REFERENCES categories(category_id)
);
CREATE TABLE product_seri (
	product_seri varchar(12),
	product_id INT,
	PRIMARY KEY(product_seri),
	CONSTRAINT fk_id_product FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE detail_order (
	order_id INT PRIMARY KEY,
	product_seri varchar(12),
	CONSTRAINT fk_order_id_detail_order FOREIGN KEY (order_id) REFERENCES orders(order_id),
	CONSTRAINT fk_product_seri_detail_order FOREIGN KEY (product_seri) REFERENCES product_seri(product_seri)
);
CREATE TABLE insurance (
    insurance_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    employee_id varchar(5),
    customer_id varchar(5),
    product_seri varchar(12),
    status_product INT,
    equipment_replacement varchar(50),
    cost float,
    time_to_finish DATE,
    status_insurance INT,
    CONSTRAINT fk_order_id_insurance FOREIGN KEY (order_id) REFERENCES orders(order_id),
    CONSTRAINT fk_employee_id_insurance FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    CONSTRAINT fk_customer_id_insurance FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    CONSTRAINT fk_product_seri_insurance FOREIGN KEY (product_seri) REFERENCES product_seri(product_seri)
);
CREATE TABLE detail_good_receipt (
    good_receipt_id INT,
    product_id INT,
    product_seri varchar(12),
    price float,
    PRIMARY KEY(good_receipt_id,product_id,product_seri),
    CONSTRAINT fk_good_receipt_id_detail_good_receipt FOREIGN KEY (good_receipt_id) REFERENCES good_receipt(good_receipt_id),
    CONSTRAINT fk_product_id_detail_good_receipt FOREIGN KEY (product_id) REFERENCES product(product_id),
    CONSTRAINT fk_product_seri_detail_good_receipt FOREIGN KEY (product_seri) REFERENCES product_seri(product_seri)
);
CREATE TABLE role ( 
	role_id INT PRIMARY KEY AUTO_INCREMENT,
	role_name varchar(60)
);
CREATE TABLE account (
	account_id INT PRIMARY KEY AUTO_INCREMENT,
	username varchar(5),
	password varchar(60) not null,
	role_id INT,
	status_account INT,
	CONSTRAINT fk_role_id_account FOREIGN KEY (role_id) REFERENCES role(role_id)
);
CREATE TABLE task (
	task_id INT PRIMARY KEY AUTO_INCREMENT,
	task_name varchar(50) not null
);
CREATE TABLE activity (
	activity_id INT PRIMARY KEY AUTO_INCREMENT,
	activity_name varchar(50) not null
);
CREATE TABLE detail_task_role (
	role_id INT,
	task_id INT,
	activity_id INT,
    PRIMARY KEY(role_id, task_id, activity_id),
	CONSTRAINT fk_role_id_detail_task_role FOREIGN KEY (role_id) REFERENCES role(role_id),
	CONSTRAINT fk_task_id_detail_task_role FOREIGN KEY (task_id) REFERENCES task(task_id),
	CONSTRAINT fk_activity_id_detail_task_role FOREIGN KEY (activity_id) REFERENCES activity(activity_id)
);

CREATE TABLE `cart` (
  `cart_id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int,
  `total_money` int,
  CONSTRAINT fk_account_id_cart FOREIGN KEY (account_id) REFERENCES account(account_id),
  CONSTRAINT fk_product_id_cart FOREIGN KEY (product_id) REFERENCES product(product_id)
);


-- Thêm dữ liệu vào bảng supplier
INSERT INTO supplier (supplier_name, supplier_address, supplier_phone, supplier_email)
VALUES ('Công Ty TNHH Tin Học Kim Thiên Bảo', 'Việt Nam', '0907225889', 'letandanh999@gmail.com'),
       ('Công Ty TNHH Thế Giới Di Động', 'Việt Nam', '0283510010', 'lienhe@thegioididong.com'),
       ('Công Ty TNHH Thương Mại Công Nghệ Bạch Long', 'Việt Nam', '0869287135', 'marketing@bachlongmobile.com'),
       ('Công Ty TNHH Bao La', 'Việt Nam', '0283511906', 'baola@gmail.com'),
       ('Doanh Nghiệp Tư Nhân Ngọc An Khang', 'Việt Nam', '0909577752', 'ngoc0909577752@gmail.com'),
       ('Công Ty Cổ Phần Thế Giới Số', 'Việt Nam', '0208365777', 'nganlt@thegioiso.vn'),
       ('Công Ty TNHH Giải Pháp CNTT Hoàn Vũ', 'Việt Nam', '0976060324', 'hvtransco@gmail.com'),
       ('Công Ty TNHH Thương Mại Và Dịch Vụ Đồng Dung', 'Việt Nam', '0392549661', 'phukienthienlan@gmail.com');
       
-- Thêm các nhân viên bắt đầu từ NV01
INSERT INTO employee (employee_id, employee_name, employee_phone, employee_address, employee_email)
VALUES 
('NV01', 'Nguyễn Văn An', '0987654321', '123 Đường ABC', 'nguyenvanan@example.com'),
('NV02', 'Trần Thị Bình', '0123456789', '456 Đường XYZ', 'tranbinh@example.com'),
('NV03', 'Lê Văn Cường', '0912345678', '789 Đường DEF', 'levancuong@example.com'),
('NV04', 'Phạm Thị Dung', '0876543210', '101 Đường HIJ', 'phamthidung@example.com'),
('NV05', 'Hoàng Văn Đức', '0765432109', '234 Đường KLM', 'hoangvanduc@example.com'),
('NV06', 'Đinh Thị Lan', '0654321098', '567 Đường NOP', 'dinhthilan@example.com'),
('NV07', 'Ngô Văn Giang', '0543210987', '890 Đường QRS', 'ngovangiang@example.com'),
('NV08', 'Lý Thị Hương', '0432109876', '123 Đường TUV', 'lythihuong@example.com'),
('NV09', 'Vũ Văn Khánh', '0321098765', '456 Đường WXY', 'vuvankhanh@example.com'),
('NV10', 'Bùi Thị Kim', '0210987654', '789 Đường ZAB', 'buithikim@example.com');

-- Thêm các khách hàng bắt đầu từ KH01
INSERT INTO customer (customer_id, customer_name, customer_address, customer_phone, customer_email)
VALUES 
('KH01', 'Nguyễn Thị An', '123 Đường ABC', '0987654321', 'nguyenthian@example.com'),
('KH02', 'Trần Văn Bình', '456 Đường XYZ', '0123456789', 'tranbinh@example.com'),
('KH03', 'Lê Thị Cẩm', '789 Đường DEF', '0912345678', 'lethicam@example.com'),
('KH04', 'Phạm Văn Đức', '101 Đường HIJ', '0876543210', 'phamvanduc@example.com'),
('KH05', 'Hoàng Thị Hương', '234 Đường KLM', '0765432109', 'hoangthihuong@example.com'),
('KH06', 'Đinh Văn Kiên', '567 Đường NOP', '0654321098', 'dinhvankien@example.com'),
('KH07', 'Ngô Thị Lan', '890 Đường QRS', '0543210987', 'ngothilan@example.com'),
('KH08', 'Lý Văn Minh', '123 Đường TUV', '0432109876', 'lyvanminh@example.com'),
('KH09', 'Vũ Thị Ngọc', '456 Đường WXY', '0321098765', 'vuthingoc@example.com'),
('KH10', 'Bùi Văn Quân', '789 Đường ZAB', '0210987654', 'buivanquan@example.com');

-- Thêm dữ liệu vào bảng category
INSERT INTO categories (category_name) VALUES
('iphone'),
('oppo'),
('redmi'),
('samsung'),
('lenovo'),
('sony');

-- Thêm dữ liệu vào bảng product
INSERT INTO product (category_id, product_name, product_ram, product_rom, product_battery, product_screen, product_made_in, product_year_produce, product_time_insurance, product_price, product_image)
VALUES
(1, 'iPhone 8', 3, 64, 1821, 4.7, 'Mỹ', 2017, 12, 15000000, 'Iphone-8.png'),
(1, 'iPhone 11', 4, 128, 3110, 6.1, 'Mỹ', 2019, 12, 22000000, 'Iphone-11.png'),
(1, 'iPhone 11 Pro', 4, 256, 3046, 5.8, 'Mỹ', 2019, 12, 30000000, 'Iphone-11pro.png'),
(1, 'iPhone 12', 4, 128, 2815, 6.1, 'Mỹ', 2020, 12, 27000000, 'Iphone-12.png'),
(1, 'iPhone 12 Pro', 6, 256, 2815, 6.1, 'Mỹ', 2020, 12, 33000000, 'Iphone-12pro.png'),
(1, 'iPhone 13', 4, 128, 4352, 6.1, 'Mỹ', 2021, 12, 27000000, 'Iphone-13.png'),
(1, 'iPhone 13 Pro', 6, 256, 3095, 6.1, 'Mỹ', 2021, 12, 36000000, 'Iphone-13pro.png'),
(1, 'iPhone 14', 6, 256, NULL, 6.1, 'Mỹ', 2022, 12, 38000000, 'Iphone-14.png'),
(2, 'Oppo A3s', 2, 16, 4230, 6.2, 'Trung Quốc', 2018, 12, 5000000, 'Oppo-A3s.png'),
(2, 'Oppo A5s', 3, 32, 4230, 6.2, 'Trung Quốc', 2019, 12, 6000000, 'Oppo-A5s.png'),
(2, 'Oppo A16k', 3, 32, 5000, 6.52, 'Trung Quốc', 2020, 12, 7000000, 'Oppo-A16k.png'),
(2, 'Oppo A55', 4, 64, 5000, 6.51, 'Trung Quốc', 2022, 12, 9000000, 'Oppo-A55.png'),
(2, 'Oppo Reno7', 6, 128, 4500, 6.43, 'Trung Quốc', 2023, 12, 12000000, 'Oppo-Reno7.png'),
(2, 'Oppo Reno8', 6, 256, 5000, 6.5, 'Trung Quốc', 2023, 12, 15000000, 'Oppo-Reno8.png'),
(2, 'Oppo Reno10', 8, 256, 5000, 6.8, 'Trung Quốc', 2023, 12, 18000000, 'Oppo-Reno10.png'),
(2, 'Oppo Reno11', 8, 512, 5000, 6.8, 'Trung Quốc', 2023, 12, 20000000, 'Oppo-Reno11.png'),
(2, 'Oppo Reno4', 8, 256, 4000, 6.4, 'Trung Quốc', 2020, 12, 14000000, 'Oppo-Reno4.png'),
(3, 'Redmi 10x', 4, 64, 5020, 6.53, 'Trung Quốc', 2020, 12, 5000000, 'Redmi-10x.png'),
(3, 'Redmi 11', 4, 128, 5000, 6.67, 'Trung Quốc', 2022, 12, 6000000, 'Redmi-11.png'),
(3, 'Redmi 12c', 4, 128, 6000, 6.53, 'Trung Quốc', 2023, 12, 7000000, 'Redmi-12c.png'),
(3, 'Redmi Note 8', 4, 64, 4000, 6.3, 'Trung Quốc', 2019, 12, 3000000, 'Redmi-Note-8.png'),
(3, 'Redmi Note 11', 6, 128, 5000, 6.43, 'Trung Quốc', 2021, 12, 4000000, 'Redmi-Note-11.png'),
(3, 'Redmi Note 12', 8, 256, 5500, 6.6, 'Trung Quốc', 2022, 12, 4500000, 'Redmi-Note-12.png'),
(4, 'Samsung Note8', 6, 64, 3300, 6.3, 'Hàn Quốc', 2017, 12, 8000000, 'Samsung-Note8.png'),
(4, 'Samsung Note11', 8, 128, 4000, 6.6, 'Hàn Quốc', 2021, 12, 12000000, 'Samsung-Note11.png'),
(4, 'Samsung Note12', 12, 256, 4500, 6.8, 'Hàn Quốc', 2022, 12, 15000000, 'Samsung-Note12.png'),
(4, 'Samsung A03', 3, 32, 5000, 6.5, 'Hàn Quốc', 2021, 12, 5000000, 'Samsung-A03.png'),
(4, 'Samsung A13', 4, 64, 6000, 6.6, 'Hàn Quốc', 2021, 12, 7000000, 'Samsung-A13.png'),
(4, 'Samsung A20s', 4, 64, 4000, 6.5, 'Hàn Quốc', 2019, 12, 6000000, 'Samsung-A20s.png'),
(4, 'Samsung A23', 4, 128, 5000, 6.6, 'Hàn Quốc', 2022, 12, 8000000, 'Samsung-A23.png'),
(4, 'Samsung A33', 6, 128, 6000, 6.5, 'Hàn Quốc', 2023, 12, 10000000, 'Samsung-A33.png'),
(4, 'Samsung Galaxy22', 8, 256, 4500, 6.7, 'Hàn Quốc', 2023, 12, 15000000, 'Samsung-Galaxy22.png'),
(4, 'Samsung GalaxyA6', 6, 128, 4000, 6.4, 'Hàn Quốc', 2018, 12, 9000000, 'Samsung-GalaxyA6.png'),
(5, 'Lenovo K8', 3, 32, 4000, 5.2, 'Trung Quốc', 2017, 12, 7000000, 'Lenovo-k8.png'),
(5, 'Lenovo Phab', 3, 32, 4250, 6.98, 'Trung Quốc', 2016, 12, 9000000, 'Lenovo-Phab.png'),
(5, 'Lenovo S660', 1, 8, 3000, 4.7, 'Trung Quốc', 2014, 12, 3500000, 'Lenovo-s660.png'),
(5, 'Lenovo S930', 1, 8, 3000, 6, 'Trung Quốc', 2013, 12, 4000000, 'Lenovo-s930.png'),
(5, 'Lenovo Vibe X2', 2, 32, 2300, 5, 'Trung Quốc', 2014, 12, 6000000, 'Lenovo-Vibe-x2.png'),
(5, 'Lenovo Z5', 4, 128, 3300, 6.2, 'Trung Quốc', 2018, 12, 11000000, 'Lenovo-Z5.png'),
(5, 'Lenovo 0p70', 3, 16, 2500, 5, 'Trung Quốc', 2015, 12, 5000000, 'Lenovo-0p70.png'),
(6, 'Sony Xperia 1', 6, 128, 3300, 6.5, 'Nhật Bản', 2019, 12, 10000000, 'Sony-Xperia-1.png'),
(6, 'Sony Xperia 5', 6, 128, 3140, 6.1, 'Nhật Bản', 2019, 12, 8000000, 'Sony-Xperia-5.png'),
(6, 'Sony Xperia 10', 3, 64, 2870, 6, 'Nhật Bản', 2019, 12, 6000000, 'Sony-Xperia-10.png'),
(6, 'Sony Xperia XZ2', 4, 64, 3180, 5.7, 'Nhật Bản', 2018, 12, 7000000, 'Sony-Xperia-XZ2.png'),
(6, 'Sony Xperia XZ3', 6, 64, 3300, 6, 'Nhật Bản', 2018, 12, 9000000, 'Sony-Xperia-XZ3.png');


-- Thêm dữ liệu vào bảng product_seri
-- iPhone serie         Quốc gia-tên sp-loại-phiên bản (00-> thường, 01-> pro)-0000 stt
INSERT INTO product_seri (product_id, product_seri)
VALUES 
(1, 'USIP08000001'),
(1, 'USIP08000002'),
(1, 'USIP08000003'),
(1, 'USIP08000004'),
(1, 'USIP08000005'),
(2, 'USIP11000001'),
(2, 'USIP11000002'),
(2, 'USIP11000003'),
(2, 'USIP11000004'),
(2, 'USIP11000005'),
(3, 'USIP11010001'),
(3, 'USIP11010002'),
(3, 'USIP11010003'),
(3, 'USIP11010004'),
(3, 'USIP11010005'),
(3, 'USIP11010006'),
(3, 'USIP11010007'),
(4, 'USIP12000001'),
(4, 'USIP12000002'),
(4, 'USIP12000003'),
(4, 'USIP12000004'),
(4, 'USIP12000005'),
(4, 'USIP12000006'),
(4, 'USIP12000007'),
(4, 'USIP12000008'),
(5, 'USIP12010001'),
(5, 'USIP12010002'),
(5, 'USIP12010003'),
(6, 'USIP13000001'),
(6, 'USIP13000002'),
(6, 'USIP13000003'),
(7, 'USIP13010001'),
(7, 'USIP13010002'),
(7, 'USIP13010003'),
(7, 'USIP13010004'),
(8, 'USIP14000001'),
(8, 'USIP14000002'),
(8, 'USIP14000003'),
(9, 'CNOPA3S00001'),
(9, 'CNOPA3S00002'),
(9, 'CNOPA3S00003'),
(10, 'CNOPA5S00001'),
(10, 'CNOPA5S00002'),
(10, 'CNOPA5S00003'),
(11, 'CNOPA16K0001'),
(11, 'CNOPA16K0002'),
(11, 'CNOPA16K0003'),
(12, 'CNOPA5500001'),
(12, 'CNOPA5500002'),
(12, 'CNOPA5500003'),
(12, 'CNOPA5500004'),
(13, 'CNOPRE070001'),
(13, 'CNOPRE070002'),
(13, 'CNOPRE070003'),
(13, 'CNOPRE070004'),
(14, 'CNOPRE080001'),
(14, 'CNOPRE080002'),
(14, 'CNOPRE080003'),
(14, 'CNOPRE080004'),
(15, 'CNOPRE100001'),
(15, 'CNOPRE100002'),
(15, 'CNOPRE100003'),
(15, 'CNOPRE100004'),
(16, 'CNOPRE110001'),
(16, 'CNOPRE110002'),
(16, 'CNOPRE110003'),
(16, 'CNOPRE110004'),
(17, 'CNOPRE040001'),
(17, 'CNOPRE040002'),
(17, 'CNOPRE040003'),
(18, 'CNRM100X0001'),
(18, 'CNRM100X0002'),
(18, 'CNRM100X0003'),
(18, 'CNRM100X0004'),
(19, 'CNRM11000001'),
(19, 'CNRM11000002'),
(19, 'CNRM11000003'),
(19, 'CNRM11000004'),
(20, 'CNRM120C0001'),
(20, 'CNRM120C0002'),
(20, 'CNRM120C0003'),
(20, 'CNRM120C0004'),
(21, 'CNRMNO080001'),
(21, 'CNRMNO080002'),
(21, 'CNRMNO080003'),
(21, 'CNRMNO080004'),
(22, 'CNRMNO110001'),
(22, 'CNRMNO110002'),
(22, 'CNRMNO110003'),
(22, 'CNRMNO110004'),
(23, 'CNRMNO120001'),
(23, 'CNRMNO120002'),
(23, 'CNRMNO120003'),
(24, 'KRSGNO080001'),
(24, 'KRSGNO080002'),
(24, 'KRSGNO080003'),
(24, 'KRSGNO080004'),
(25, 'KRSGNO110001'),
(25, 'KRSGNO110002'),
(25, 'KRSGNO110003'),
(25, 'KRSGNO110004'),
(26, 'KRSGNO120001'),
(26, 'KRSGNO120002'),
(26, 'KRSGNO120003'),
(27, 'KRSGA0300001'),
(27, 'KRSGA0300002'),
(27, 'KRSGA0300003'),
(27, 'KRSGA0300004'),
(28, 'KRSGA1300001'),
(28, 'KRSGA1300002'),
(28, 'KRSGA1300003'),
(28, 'KRSGA1300004'),
(29, 'KRSGA20S0001'),
(29, 'KRSGA20S0002'),
(29, 'KRSGA20S0003'),
(29, 'KRSGA20S0004'),
(30, 'KRSGA2300001'),
(30, 'KRSGA2300002'),
(30, 'KRSGA2300003'),
(30, 'KRSGA2300004'),
(31, 'KRSGA3300001'),
(31, 'KRSGA3300002'),
(31, 'KRSGA3300003'),
(31, 'KRSGA3300004'),
(32, 'KRSG22000001'),
(32, 'KRSG22000002'),
(32, 'KRSG22000003'),
(32, 'KRSG22000004'),
(33, 'KRSGA6000001'),
(33, 'KRSGA6000002'),
(33, 'KRSGA6000003'),
(33, 'KRSGA6000004'),
(34, 'CNLNK8000001'),
(34, 'CNLNK8000002'),
(34, 'CNLNK8000003'),
(34, 'CNLNK8000004'),
(35, 'CNLNPHAB0001'),
(35, 'CNLNPHAB0002'),
(35, 'CNLNPHAB0003'),
(35, 'CNLNPHAB0004'),
(36, 'CNLNS6600001'),
(36, 'CNLNS6600002'),
(36, 'CNLNS6600003'),
(36, 'CNLNS6600004'),
(37, 'CNLNS9300001'),
(37, 'CNLNS9300002'),
(37, 'CNLNS9300003'),
(37, 'CNLNS9300004'),
(38, 'CNLNVIX20001'),
(38, 'CNLNVIX20002'),
(38, 'CNLNVIX20003'),
(38, 'CNLNVIX20004'),
(39, 'CNLNZ5000001'),
(39, 'CNLNZ5000002'),
(39, 'CNLNZ5000003'),
(39, 'CNLNZ5000004'),
(40, 'CNLNOP700001'),
(40, 'CNLNOP700002'),
(40, 'CNLNOP700003'),
(40, 'CNLNOP700004'),
(41, 'JPSX01000001'),
(41, 'JPSX01000002'),
(41, 'JPSX01000003'),
(41, 'JPSX01000004'),
(42, 'JPSX05000001'),
(42, 'JPSX05000002'),
(42, 'JPSX05000003'),
(42, 'JPSX05000004'),
(43, 'JPSX10000001'),
(43, 'JPSX10000002'),
(43, 'JPSX10000003'),
(43, 'JPSX10000004'),
(44, 'JPSXXZ020001'),
(44, 'JPSXXZ020002'),
(44, 'JPSXXZ020003'),
(44, 'JPSXXZ020004'),
(45, 'JPSXXZ030001'),
(45, 'JPSXXZ030002'),
(45, 'JPSXXZ030003'),
(45, 'JPSXXZ030004');

-- Thêm dữ liệu vào bảng role
INSERT INTO role (role_name) VALUES
('admin'),
('employee'),
('customer');

-- Thêm dữ liệu vào bảng task
INSERT INTO task (task_name) VALUES
('account management'),
('customer management'),
('product management'),
('order management'),
('employee management'),
('role management'),
('discount management'),
('good receipt management'),
('statistical management'),
('insurance management'),
('client');

-- Thêm dữ liệu vào bảng activity
INSERT INTO activity (activity_name) VALUES
('add'),
('edit'),
('delete'),
('search'),
('clients');

-- Thêm dữ liệu vào bảng detail_task_role
INSERT INTO detail_task_role (role_id, task_id, activity_id) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(2, 1, 1),
(3, 11, 5);

-- Thêm dữ liệu vào bảng good_receipt
INSERT INTO good_receipt (supplier_id, employee_id, date_good_receipt, total) VALUES
(1, 'NV01', NOW(), NULL),
(2, 'NV02', NOW(), NULL),
(3, 'NV03', NOW(), NULL),
(4, 'NV04', NOW(), NULL),
(5, 'NV05', NOW(), NULL),
(6, 'NV06', NOW(), NULL);

-- Thêm dữ liệu vào bảng detail_good_receipt
INSERT INTO detail_good_receipt (good_receipt_id, product_id, product_seri, price) VALUES
(1, 1, 'USIP08000001', 15000000),
(1, 1, 'USIP08000002', 15000000),
(1, 1, 'USIP08000003', 15000000),
(1, 1, 'USIP08000004', 15000000),
(1, 1, 'USIP08000005', 15000000),
(1, 1, 'USIP11000001', 22000000),
(1, 1, 'USIP11000002', 22000000),
(1, 1, 'USIP11000003', 22000000),
(1, 1, 'USIP11000004', 22000000),
(1, 1, 'USIP11000005', 22000000),
(1, 2, 'USIP11000001', 22000000),
(1, 2, 'USIP11000002', 22000000),
(1, 2, 'USIP11000003', 22000000),
(1, 2, 'USIP11000004', 22000000),
(1, 2, 'USIP11000005', 22000000),
(1, 3, 'USIP11010001', 30000000),
(1, 3, 'USIP11010002', 30000000),
(1, 3, 'USIP11010003', 30000000),
(1, 3, 'USIP11010004', 30000000),
(1, 3, 'USIP11010005', 30000000),
(1, 3, 'USIP11010006', 30000000),
(1, 3, 'USIP11010007', 30000000),
(1, 4, 'USIP12000001', 27000000),
(1, 4, 'USIP12000002', 27000000),
(1, 4, 'USIP12000003', 27000000),
(1, 4, 'USIP12000004', 27000000),
(1, 4, 'USIP12000005', 27000000),
(1, 4, 'USIP12000006', 27000000),
(1, 4, 'USIP12000007', 27000000),
(1, 4, 'USIP12000008', 27000000),
(1, 5, 'USIP12010001', 33000000),
(1, 5, 'USIP12010002', 33000000),
(1, 5, 'USIP12010003', 33000000),
(1, 6, 'USIP13000001', 27000000),
(1, 6, 'USIP13000002', 27000000),
(1, 6, 'USIP13000003', 27000000),
(1, 7, 'USIP13010001', 36000000),
(1, 7, 'USIP13010002', 36000000),
(1, 7, 'USIP13010003', 36000000),
(1, 7, 'USIP13010004', 36000000),
(1, 8, 'USIP14000001', 38000000),
(1, 8, 'USIP14000002', 38000000),
(1, 8, 'USIP14000003', 38000000),
(1, 9, 'CNOPA3S00001', 5000000),
(1, 9, 'CNOPA3S00002', 5000000),
(1, 9, 'CNOPA3S00003', 5000000),
(1, 10, 'CNOPA5S00001', 6000000),
(1, 10, 'CNOPA5S00002', 6000000),
(1, 10, 'CNOPA5S00003', 6000000),
(1, 11, 'CNOPA16K0001', 7000000),
(1, 11, 'CNOPA16K0002', 7000000),
(1, 11, 'CNOPA16K0003', 7000000),
(1, 12, 'CNOPA5500001', 9000000),
(1, 12, 'CNOPA5500002', 9000000),
(1, 12, 'CNOPA5500003', 9000000),
(1, 12, 'CNOPA5500004', 9000000),
(1, 13, 'CNOPRE070001', 12000000),
(1, 13, 'CNOPRE070002', 12000000),
(1, 13, 'CNOPRE070003', 12000000),
(1, 13, 'CNOPRE070004', 12000000),
(1, 14, 'CNOPRE080001', 15000000),
(1, 14, 'CNOPRE080002', 15000000),
(1, 14, 'CNOPRE080003', 15000000),
(1, 14, 'CNOPRE080004', 15000000),
(1, 15, 'CNOPRE100001', 27000000),
(1, 15, 'CNOPRE100002', 27000000),
(1, 15, 'CNOPRE100003', 27000000),
(1, 15, 'CNOPRE100004', 27000000),
(1, 16, 'CNOPRE110001', 36000000),
(1, 16, 'CNOPRE110002', 36000000),
(1, 16, 'CNOPRE110003', 36000000),
(1, 16, 'CNOPRE110004', 36000000),
(1, 17, 'CNOPRE040001', 27000000),
(1, 17, 'CNOPRE040002', 27000000),
(1, 17, 'CNOPRE040003', 27000000),
(1, 18, 'CNRM100X0001', 8000000),
(1, 18, 'CNRM100X0002', 8000000),
(1, 18, 'CNRM100X0003', 8000000),
(1, 18, 'CNRM100X0004', 8000000),
(1, 19, 'CNRM11000001', 12000000),
(1, 19, 'CNRM11000002', 12000000),
(1, 19, 'CNRM11000003', 12000000),
(1, 19, 'CNRM11000004', 12000000),
(1, 20, 'CNRM120C0001', 15000000),
(1, 20, 'CNRM120C0002', 15000000),
(1, 20, 'CNRM120C0003', 15000000),
(1, 20, 'CNRM120C0004', 15000000),
(1, 21, 'CNRMNO080001', 5000000),
(1, 21, 'CNRMNO080002', 5000000),
(1, 21, 'CNRMNO080003', 5000000),
(1, 21, 'CNRMNO080004', 5000000),
(1, 22, 'CNRMNO110001', 6000000),
(1, 22, 'CNRMNO110002', 6000000),
(1, 22, 'CNRMNO110003', 6000000),
(1, 22, 'CNRMNO110004', 6000000),
(1, 23, 'CNRMNO120001', 7000000),
(1, 23, 'CNRMNO120002', 7000000),
(1, 23, 'CNRMNO120003', 7000000),
(1, 24, 'KRSGNO080001', 8000000),
(1, 24, 'KRSGNO080002', 8000000),
(1, 24, 'KRSGNO080003', 8000000),
(1, 24, 'KRSGNO080004', 8000000),
(1, 25, 'KRSGNO110001', 12000000),
(1, 25, 'KRSGNO110002', 12000000),
(1, 25, 'KRSGNO110003', 12000000),
(1, 25, 'KRSGNO110004', 12000000),
(1, 26, 'KRSGNO120001', 15000000),
(1, 26, 'KRSGNO120002', 15000000),
(1, 26, 'KRSGNO120003', 15000000),
(1, 27, 'KRSGA0300001', 38000000),
(1, 27, 'KRSGA0300002', 38000000),
(1, 27, 'KRSGA0300003', 38000000),
(1, 27, 'KRSGA0300004', 38000000),
(1, 28, 'KRSGA1300001', 38000000),
(1, 28, 'KRSGA1300002', 38000000),
(1, 28, 'KRSGA1300003', 38000000),
(1, 28, 'KRSGA1300004', 38000000),
(1, 29, 'KRSGA20S0001', 38000000),
(1, 29, 'KRSGA20S0002', 38000000),
(1, 29, 'KRSGA20S0003', 38000000),
(1, 29, 'KRSGA20S0004', 38000000),
(1, 30, 'KRSGA2300001', 38000000),
(1, 30, 'KRSGA2300002', 38000000),
(1, 30, 'KRSGA2300003', 38000000),
(1, 30, 'KRSGA2300004', 38000000),
(1, 31, 'KRSGA3300001', 38000000),
(1, 31, 'KRSGA3300002', 38000000),
(1, 31, 'KRSGA3300003', 38000000),
(1, 31, 'KRSGA3300004', 38000000),
(1, 32, 'KRSG22000001', 38000000),
(1, 32, 'KRSG22000002', 38000000),
(1, 32, 'KRSG22000003', 38000000),
(1, 32, 'KRSG22000004', 38000000),
(1, 33, 'KRSGA6000001', 38000000),
(1, 33, 'KRSGA6000002', 38000000),
(1, 33, 'KRSGA6000003', 38000000),
(1, 33, 'KRSGA6000004', 38000000),
(1, 34, 'CNLNK8000001', 38000000),
(1, 34, 'CNLNK8000002', 38000000),
(1, 34, 'CNLNK8000003', 38000000),
(1, 34, 'CNLNK8000004', 38000000),
(1, 35, 'CNLNPHAB0001', 38000000),
(1, 35, 'CNLNPHAB0002', 38000000),
(1, 35, 'CNLNPHAB0003', 38000000),
(1, 35, 'CNLNPHAB0004', 38000000),
(1, 36, 'CNLNS6600001', 38000000),
(1, 36, 'CNLNS6600002', 38000000),
(1, 36, 'CNLNS6600003', 38000000),
(1, 36, 'CNLNS6600004', 38000000),
(1, 37, 'CNLNS9300001', 38000000),
(1, 37, 'CNLNS9300002', 38000000),
(1, 37, 'CNLNS9300003', 38000000),
(1, 37, 'CNLNS9300004', 38000000),
(1, 38, 'CNLNVIX20001', 38000000),
(1, 38, 'CNLNVIX20002', 38000000),
(1, 38, 'CNLNVIX20003', 38000000),
(1, 38, 'CNLNVIX20004', 38000000),
(1, 39, 'CNLNZ5000001', 38000000),
(1, 39, 'CNLNZ5000002', 38000000),
(1, 39, 'CNLNZ5000003', 38000000),
(1, 39, 'CNLNZ5000004', 38000000),
(1, 40, 'CNLNOP700001', 38000000),
(1, 40, 'CNLNOP700002', 38000000),
(1, 40, 'CNLNOP700003', 38000000),
(1, 40, 'CNLNOP700004', 38000000),
(1, 41, 'JPSX01000001', 38000000),
(1, 41, 'JPSX01000002', 38000000),
(1, 41, 'JPSX01000003', 38000000),
(1, 41, 'JPSX01000004', 38000000),
(1, 42, 'JPSX05000001', 38000000),
(1, 42, 'JPSX05000002', 38000000),
(1, 42, 'JPSX05000003', 38000000),
(1, 42, 'JPSX05000004', 38000000),
(1, 43, 'JPSX10000001', 38000000),
(1, 43, 'JPSX10000002', 38000000),
(1, 43, 'JPSX10000003', 38000000),
(1, 43, 'JPSX10000004', 38000000),
(1, 44, 'JPSXXZ020001', 38000000),
(1, 44, 'JPSXXZ020002', 38000000),
(1, 44, 'JPSXXZ020003', 38000000),
(1, 44, 'JPSXXZ020004', 38000000),
(1, 45, 'JPSXXZ030001', 38000000),
(1, 45, 'JPSXXZ030002', 38000000),
(1, 45, 'JPSXXZ030003', 38000000),
(1, 45, 'JPSXXZ030004', 38000000);

-- Thêm dữ liệu vào bảng account

INSERT INTO account (username, password, role_id, status_account) VALUES
('KH01', 'kh01abc', 3, 1),
('admin', 'admin', 1, 1);



