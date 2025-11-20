-- สร้างตาราง tb_customers (ลูกค้า)
CREATE TABLE IF NOT EXISTS tb_customers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    company_name VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    province VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    subdistrict VARCHAR(100) NOT NULL,
    zipcode VARCHAR(10) NOT NULL,
    tax_id VARCHAR(20) DEFAULT NULL,
    contact_person VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง tb_shipments (พัสดุ)
CREATE TABLE IF NOT EXISTS tb_shipments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11) NOT NULL,
    tracking_number VARCHAR(50) NOT NULL UNIQUE,
    service_type ENUM('express', 'standard', 'economy') NOT NULL,
    temperature_range ENUM('frozen', 'chilled', 'cool', 'room') NOT NULL,
    shipment_date DATE NOT NULL,
    total_weight DECIMAL(10, 2) NOT NULL DEFAULT 0,
    parcel_width INT(11) DEFAULT NULL,
    parcel_length INT(11) DEFAULT NULL,
    parcel_height INT(11) DEFAULT NULL,
    shipping_cost DECIMAL(10, 2) NOT NULL DEFAULT 0,
    cod_amount DECIMAL(10, 2) DEFAULT 0,
    status ENUM('draft', 'pending', 'processing', 'shipping', 'delivered', 'returned', 'cancelled', 'problem') NOT NULL DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES tb_customers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง tb_shipment_senders (ผู้ส่ง)
CREATE TABLE IF NOT EXISTS tb_shipment_senders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    province VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    subdistrict VARCHAR(100) NOT NULL,
    zipcode VARCHAR(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (shipment_id) REFERENCES tb_shipments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง tb_shipment_receivers (ผู้รับ)
CREATE TABLE IF NOT EXISTS tb_shipment_receivers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    province VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    subdistrict VARCHAR(100) NOT NULL,
    zipcode VARCHAR(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (shipment_id) REFERENCES tb_shipments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง tb_shipment_items (รายการสินค้าในพัสดุ)
CREATE TABLE IF NOT EXISTS tb_shipment_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    weight DECIMAL(10, 2) NOT NULL DEFAULT 0,
    note TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (shipment_id) REFERENCES tb_shipments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง tb_shipment_status (ประวัติสถานะพัสดุ)
CREATE TABLE IF NOT EXISTS tb_shipment_status (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT(11) NOT NULL,
    status VARCHAR(50) NOT NULL,
    location VARCHAR(255) DEFAULT NULL,
    note TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (shipment_id) REFERENCES tb_shipments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง provinces (จังหวัด)
CREATE TABLE IF NOT EXISTS provinces (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name_th VARCHAR(120) NOT NULL,
    name_en VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง districts (อำเภอ)
CREATE TABLE IF NOT EXISTS districts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    province_id INT(11) NOT NULL,
    name_th VARCHAR(120) NOT NULL,
    name_en VARCHAR(120) NOT NULL,
    FOREIGN KEY (province_id) REFERENCES provinces(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- สร้างตาราง subdistricts (ตำบล)
CREATE TABLE IF NOT EXISTS subdistricts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    district_id INT(11) NOT NULL,
    name_th VARCHAR(120) NOT NULL,
    name_en VARCHAR(120) NOT NULL,
    zip_code VARCHAR(5) NOT NULL,
    FOREIGN KEY (district_id) REFERENCES districts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
