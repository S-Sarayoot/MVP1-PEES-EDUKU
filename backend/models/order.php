<?php
    Class Order {
        // database connection and table name
        private $conn;
        private $table_name = "tb_shippingorder";
        private $table_name_status = "tb_status"; // ชื่อ table สำหรับสถานะ

        // object properties
        public $order_id;
        public $userId;
        public $userCode;
        public $polarsTrackingcode;
        public $serviceType;
        public $parcelWeight;
        public $parcelSize; // เพิ่มขนาดพัสดุ (S, M, L, XL)
        public $parcelWidth;
        public $parcelLength;
        public $parcelHeight;
        public $shippingCost;
        public $serviceCost;
        public $shippingFee;
        public $serviceFee;
        public $parcelStatus;
        public $senderName;
        public $senderPhone;
        public $senderEmail; // เพิ่ม email ของผู้ส่ง
        public $senderAddress;
        public $senderProvince;
        public $senderDistrict;
        public $senderSubdistrict;
        public $senderZipcode;
        public $receiverName;
        public $receiverPhone;
        public $receiverEmail; // เพิ่ม email ของผู้รับ
        public $receiverAddress;
        public $receiverProvince;
        public $receiverDistrict;
        public $receiverSubdistrict;
        public $receiverZipcode;
        public $parcelDescription = ''; // เพิ่มรายละเอียดพัสดุ
        public $parcelNote = ''; // เพิ่มหมายเหตุ
        public $parcelInbox = ''; // Optional field, can be set to empty if not provided
        public $createdDate; // เพิ่มวันที่สร้าง
        public $updatedDate; // เพิ่มวันที่อัปเดต

        public $areaZone; // เพิ่มเขตพื้นที่ (optional)

        public $productPrice; // เพิ่มราคาสินค้า (สำหรับ COD)

        // constructor with database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // method to create a new order
        public function createOrder() {
            // SQL query to insert order data
            $query = "INSERT INTO " . $this->table_name . " SET 
                userId = :userId, 
                userCode = :userCode,
                polarsTrackingcode = :polarsTrackingcode, 
                serviceType = :serviceType, 
                parcelSize = :parcelSize,
                parcelWeight = :parcelWeight,
                parcelWidth = :parcelWidth, 
                parcelLength = :parcelLength, 
                parcelHeight = :parcelHeight, 
                shippingCost = :shippingCost,
                serviceCost = :serviceCost,
                shippingFee = :shippingFee,
                serviceFee = :serviceFee,
                parcelStatus = :parcelStatus, 
                senderName = :senderName, 
                senderPhone = :senderPhone, 
                senderEmail = :senderEmail,
                senderAddress = :senderAddress, 
                senderZipcode = :senderZipcode,
                receiverName = :receiverName,
                receiverPhone = :receiverPhone,
                receiverEmail = :receiverEmail,
                receiverAddress = :receiverAddress,
                receiverZipcode = :receiverZipcode,
                parcelDescription = :parcelDescription,
                parcelNote = :parcelNote,
                parcelInbox = :parcelInbox, 
                createdDate = NOW(),
                updatedDate = NOW(),
                areaZone = :areaZone,
                productPrice = :productPrice
            ";

            // prepare the query
            $stmt = $this->conn->prepare($query);
            
            // bind the parameters
            $stmt->bindParam(':userId', $this->userId);
            $stmt->bindParam(':userCode', $this->userCode);
            $stmt->bindParam(':polarsTrackingcode', $this->polarsTrackingcode);
            $stmt->bindParam(':serviceType', $this->serviceType);
            $stmt->bindParam(':parcelSize', $this->parcelSize);
            $stmt->bindParam(':parcelWeight', $this->parcelWeight);
            $stmt->bindParam(':parcelWidth', $this->parcelWidth);
            $stmt->bindParam(':parcelLength', $this->parcelLength);
            $stmt->bindParam(':parcelHeight', $this->parcelHeight);
            $stmt->bindParam(':shippingCost', $this->shippingCost);
            $stmt->bindParam(':serviceCost', $this->serviceCost);
            $stmt->bindParam(':shippingFee', $this->shippingFee);
            $stmt->bindParam(':serviceFee', $this->serviceFee);
            $stmt->bindParam(':parcelStatus', $this->parcelStatus);
            $stmt->bindParam(':senderName', $this->senderName);
            $stmt->bindParam(':senderPhone', $this->senderPhone);
            $stmt->bindParam(':senderEmail', $this->senderEmail);
            $stmt->bindParam(':senderAddress', $this->senderAddress);
            $stmt->bindParam(':senderZipcode', $this->senderZipcode);
            $stmt->bindParam(':receiverName', $this->receiverName);
            $stmt->bindParam(':receiverPhone', $this->receiverPhone);
            $stmt->bindParam(':receiverEmail', $this->receiverEmail);
            $stmt->bindParam(':receiverAddress', $this->receiverAddress);
            $stmt->bindParam(':receiverZipcode', $this->receiverZipcode);
            $stmt->bindParam(':parcelDescription', $this->parcelDescription);
            $stmt->bindParam(':parcelNote', $this->parcelNote);
            $stmt->bindParam(':parcelInbox', $this->parcelInbox); // bind parcelInbox parameter
            $stmt->bindParam(':areaZone', $this->areaZone); // bind areaZone parameter
            $stmt->bindParam(':productPrice', $this->productPrice); 
            
            // execute the query
            if ($stmt->execute()) {
                // return the last inserted order ID
                $this->order_id = $this->conn->lastInsertId();
                return true;
            } else {
                error_log("Error creating order: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        }

        public function editOrder() {
            // SQL query to update order data
            $query = "UPDATE " . $this->table_name . " SET 
                serviceType = :serviceType, 
                parcelSize = :parcelSize,
                parcelWeight = :parcelWeight,
                parcelWidth = :parcelWidth, 
                parcelLength = :parcelLength, 
                parcelHeight = :parcelHeight, 
                shippingCost = :shippingCost,
                serviceCost = :serviceCost,
                shippingFee = :shippingFee,
                serviceFee = :serviceFee,
                parcelStatus = :parcelStatus, 
                senderName = :senderName, 
                senderPhone = :senderPhone, 
                senderEmail = :senderEmail,
                senderAddress = :senderAddress, 
                senderZipcode = :senderZipcode,
                receiverName = :receiverName,
                receiverPhone = :receiverPhone,
                receiverEmail = :receiverEmail,
                receiverAddress = :receiverAddress,
                receiverZipcode = :receiverZipcode,
                parcelDescription = :parcelDescription,
                parcelNote = :parcelNote,
                parcelInbox = :parcelInbox,
                updatedDate = NOW(),
                areaZone = :areaZone,
                productPrice = :productPrice
            WHERE polarsTrackingcode = :polarsTrackingcode";

            // prepare the query
            $stmt = $this->conn->prepare($query);
            
            // bind the parameters
            $stmt->bindParam(':polarsTrackingcode', $this->polarsTrackingcode);
            $stmt->bindParam(':serviceType', $this->serviceType);
            $stmt->bindParam(':parcelSize', $this->parcelSize);
            $stmt->bindParam(':parcelWeight', $this->parcelWeight);
            $stmt->bindParam(':parcelWidth', $this->parcelWidth);
            $stmt->bindParam(':parcelLength', $this->parcelLength);
            $stmt->bindParam(':parcelHeight', $this->parcelHeight);
            $stmt->bindParam(':shippingCost', $this->shippingCost);
            $stmt->bindParam(':serviceCost', $this->serviceCost);
            $stmt->bindParam(':shippingFee', $this->shippingFee);
            $stmt->bindParam(':serviceFee', $this->serviceFee);
            $stmt->bindParam(':parcelStatus', $this->parcelStatus);
            $stmt->bindParam(':senderName', $this->senderName);
            $stmt->bindParam(':senderPhone', $this->senderPhone);
            $stmt->bindParam(':senderEmail', $this->senderEmail);
            $stmt->bindParam(':senderAddress', $this->senderAddress);
            $stmt->bindParam(':senderZipcode', $this->senderZipcode);
            $stmt->bindParam(':receiverName', $this->receiverName);
            $stmt->bindParam(':receiverPhone', $this->receiverPhone);
            $stmt->bindParam(':receiverEmail', $this->receiverEmail);
            $stmt->bindParam(':receiverAddress', $this->receiverAddress);
            $stmt->bindParam(':receiverZipcode', $this->receiverZipcode);
            $stmt->bindParam(':parcelDescription', $this->parcelDescription);
            $stmt->bindParam(':parcelNote', $this->parcelNote);
            $stmt->bindParam(':parcelInbox', $this->parcelInbox); // bind parcelInbox parameter
            $stmt->bindParam(':areaZone', $this->areaZone); // bind areaZone parameter
            $stmt->bindParam(':productPrice', $this->productPrice); 
            // execute the query
            if ($stmt->execute()) {
                // return true if the update was successful
                return true;
            } else {
                error_log("Error updating order: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        }

        // เพิ่มเมธอดสำหรับดึงข้อมูลคำสั่ง
        public function getOrderById($userId) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE userId = :userId AND is_deleted = 0";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            
            return $stmt;
        }
        
        // เพิ่มเมธอดสำหรับอัปเดตสถานะคำสั่ง
        /*
        public function updateOrderStatus() {
            $query = "UPDATE " . $this->table_name . " SET 
                      status = :status,
                      updated_at = NOW()
                      WHERE order_id = :order_id";
                      
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':order_id', $this->order_id);
            
            if($stmt->execute()) {
                return true;
            }
            
            return false;
        }*/
        

        
        // นับจำนวนรายการทั้งหมด
        public function countAll() {
            $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['total'];
        }

        // นับจำนวนรายการที่ตรงตามเงื่อนไข
        public function countFiltered($whereClause = "", $params = []) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE 1=1" . $whereClause . " AND is_deleted = 0";
            $stmt = $this->conn->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['total'];
        }

        // ดึงข้อมูลรายการตามเงื่อนไข
        public function getOrders($whereClause = "", $params = [], $start = 0, $length = 10) {
        $query = "SELECT 
            o.*,
            s.status_name,
            CAST(SUBSTRING(o.polarsTrackingcode, -5) AS UNSIGNED) as tracking_number
            FROM " . $this->table_name . " o
            LEFT JOIN 
            " . $this->table_name_status . " s ON o.parcelStatus = s.status_code
            WHERE 1=1" . $whereClause . "  AND o.is_deleted = 0
            ORDER BY o.createdDate DESC, tracking_number DESC LIMIT :start, :length";
        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
        $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
        }

        // สถิติจำนวนรายการตามสถานะ ตามวันที่
        public function getOrderStatsWhere($whereClause = "", $params = []) {
            

            $query = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN parcelStatus = '101' OR parcelStatus = '201' OR parcelStatus = '202' OR parcelStatus = '203' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN parcelStatus = '301' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN parcelStatus = '401' OR parcelStatus = '501' OR parcelStatus = '502' THEN 1 ELSE 0 END) as problem 
            FROM " . $this->table_name . " WHERE 1=1 " . $whereClause . " AND is_deleted = 0 ";

            $stmt = $this->conn->prepare($query);


            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // แปลงค่าให้เป็นตัวเลข
            foreach ($row as $key => $value) {
                $row[$key] = (int)$value;
            }


            return $row;
        }

        // สถิติจำนวนรายการตามสถานะ
        public function getOrderStats($userId = null) {
            $whereClause = " WHERE is_deleted = 0 ";
            if ($userId !== null) {
                $whereClause .= " AND userId = :userId ";
            }

            $query = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN parcelStatus = '101' OR parcelStatus = '201' OR parcelStatus = '202' OR parcelStatus = '203' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN parcelStatus = '301' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN parcelStatus = '401' OR parcelStatus = '501' OR parcelStatus = '502' THEN 1 ELSE 0 END) as problem 
            FROM " . $this->table_name . $whereClause;

            $stmt = $this->conn->prepare($query);

            if ($userId !== null) {
                $stmt->bindParam(':userId', $userId);
            }

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // แปลงค่าให้เป็นตัวเลข
            foreach ($row as $key => $value) {
                $row[$key] = (int)$value;
            }


            return $row;
        }

        public function getOrderStatsByDashboard($userId = null, $startMonth = null, $endMonth = null) {
            $whereClause = " WHERE is_deleted = 0 ";
            if ($userId !== null) {
                $whereClause .= " AND userId = :userId ";
            }
            if ($startMonth !== null && $endMonth !== null) {
                $whereClause .= " AND DATE_FORMAT(createdDate, '%Y-%m') BETWEEN :startMonth AND :endMonth ";
            }

            $query = "
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN parcelStatus = '101' OR parcelStatus = '201' OR parcelStatus = '202' OR parcelStatus = '203' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN parcelStatus = '301' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN parcelStatus = '401' OR parcelStatus = '501' OR parcelStatus = '502' THEN 1 ELSE 0 END) as problem 
            FROM " . $this->table_name . $whereClause;

            $stmt = $this->conn->prepare($query);

            if ($userId !== null) {
                $stmt->bindParam(':userId', $userId);
            }
            if ($startMonth !== null && $endMonth !== null) {
                $stmt->bindParam(':startMonth', $startMonth);
                $stmt->bindParam(':endMonth', $endMonth);
            }

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // แปลงค่าให้เป็นตัวเลข
            foreach ($row as $key => $value) {
                $row[$key] = (int)$value;
            }


            return $row;
        }

        
        
        public function getOrderByTrackingNumber($polarsTrackingcode) {
            // ถ้า $trackingNumber เป็น array
            if (is_array($polarsTrackingcode)) {
                $polarsTrackingcode = $polarsTrackingcode[0]; // ใช้ค่าแรก
            }
            
            $query = "SELECT o.*, s.status_name FROM " . $this->table_name . " o 
                LEFT JOIN 
                    " . $this->table_name_status . " s ON o.parcelStatus = s.status_code 
                WHERE o.polarsTrackingcode = :tracking LIMIT 1 ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tracking', $polarsTrackingcode);
            $stmt->execute();
            return $stmt;
        }

        public function getCountOrder($text) {
            $query = "SELECT COUNT(*) as cnt FROM " . $this->table_name . " 
              WHERE polarsTrackingcode LIKE ? ";
            //AND YEAR(createdDate) = YEAR(CURDATE()) AND MONTH(createdDate) = MONTH(CURDATE())
            $stmt = $this->conn->prepare($query);
            $pattern = $text . '%';
            $stmt->execute([$pattern]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // นับจำนวนที่มีอยู่ + 1
            $number = str_pad(((int)$row['cnt']) + 1, 5, '0', STR_PAD_LEFT);

            return $number;
            /*
            $query = "SELECT polarsTrackingcode FROM " . $this->table_name . " 
                WHERE polarsTrackingcode LIKE ? 
                ORDER BY polarsTrackingcode DESC LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $pattern = $text . '%';
            $stmt->execute([$pattern]);
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Extract the counter from last tracking number and increment
                $lastNumber = substr($row['polarsTrackingcode'], -5);
                $number = str_pad((int)$lastNumber + 1, 5, '0', STR_PAD_LEFT);
            } else {
                // No orders today, start with 00001
                $number = '00001';
            }
            return $number;  */
        }

        public function deleteOrder() {
            // SQL query to soft delete an order
            $query = "UPDATE " . $this->table_name . " SET is_deleted = 1, updatedDate = :updatedDate WHERE polarsTrackingcode = :polarsTrackingcode";
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':polarsTrackingcode', $this->polarsTrackingcode);
            $currentDate = date('Y-m-d H:i:s');
            $stmt->bindParam(':updatedDate', $currentDate);

            // execute the query
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error deleting order: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        }

        // ดึงข้อมูลสถิติรายเดือน (6 เดือนย้อนหลัง)
        public function getMonthlyStats($userId = null) {
            $whereClause = " WHERE  is_deleted = 0 ";
            if ($userId !== null) {
                $whereClause .= " AND userId = :userId ";
            }

            $query = "
            SELECT 
                DATE_FORMAT(createdDate, '%Y-%m') as month,
                DATE_FORMAT(createdDate, '%M %Y') as month_name,
                COUNT(*) as total,
                SUM(CASE WHEN parcelStatus = '301' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN parcelStatus = '101' OR parcelStatus = '201' OR parcelStatus = '202' OR parcelStatus = '203' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN parcelStatus = '401' OR parcelStatus = '501' OR parcelStatus = '502' THEN 1 ELSE 0 END) as problem
            FROM " . $this->table_name . $whereClause . "
            GROUP BY DATE_FORMAT(createdDate, '%Y-%m')
            ORDER BY month ASC";

            $stmt = $this->conn->prepare($query);

            if ($userId !== null) {
                $stmt->bindParam(':userId', $userId);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ดึงข้อมูลสถิติตามประเภทบริการ
        public function getServiceStats($userId = null, $startMonth = null, $endMonth = null) {
            $whereClause = " WHERE is_deleted = 0 ";
            if ($userId !== null) {
                $whereClause .= " AND userId = :userId ";
            }
            if ($startMonth !== null && $endMonth !== null) {
                $whereClause .= " AND DATE_FORMAT(createdDate, '%Y-%m') BETWEEN :startMonth AND :endMonth ";
            }

            $query = "
            SELECT 
                serviceType,
                COUNT(*) as total,
                SUM(shippingCost + serviceCost) as total_revenue
            FROM " . $this->table_name . $whereClause . "
            GROUP BY serviceType
            ORDER BY total DESC";

            $stmt = $this->conn->prepare($query);

            if ($userId !== null) {
                $stmt->bindParam(':userId', $userId);
            }
            if ($startMonth !== null && $endMonth !== null) {
                $stmt->bindParam(':startMonth', $startMonth);
                $stmt->bindParam(':endMonth', $endMonth);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ดึงข้อมูลสถิติตามรหัสไปรษณีย์ (Top 10)
        public function getZipcodeStats($userId = null, $startMonth = null, $endMonth = null) {
            $whereClause = " WHERE is_deleted = 0 AND receiverZipcode IS NOT NULL AND receiverZipcode != '' ";
            if ($userId !== null) {
                $whereClause .= " AND userId = :userId ";
            }
            if ($startMonth !== null && $endMonth !== null) {
                $whereClause .= " AND DATE_FORMAT(createdDate, '%Y-%m') BETWEEN :startMonth AND :endMonth ";
            }

            $query = "
            SELECT 
                receiverZipcode as zipcode,
                COUNT(*) as total
            FROM " . $this->table_name . $whereClause . "
            GROUP BY receiverZipcode
            ORDER BY total DESC
            LIMIT 10";

            $stmt = $this->conn->prepare($query);

            if ($userId !== null) {
                $stmt->bindParam(':userId', $userId);
            }
            if ($startMonth !== null && $endMonth !== null) {
                $stmt->bindParam(':startMonth', $startMonth);
                $stmt->bindParam(':endMonth', $endMonth);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ดึงข้อมูลรายการวันนี้
        public function getTodayOrdersCount($userId = null) {
            try {
                $whereClause = " WHERE DATE(createdDate) = CURDATE()";
                if ($userId !== null) {
                    $whereClause .= " AND userId = :userId";
                }
                
                $query = "
                    SELECT 
                        COUNT(*) as total
                    FROM " . $this->table_name  . $whereClause . " ";
                
                $stmt = $this->conn->prepare($query);
                
                if ($userId !== null) {
                    $stmt->bindParam(':userId', $userId);
                }
                
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return [
                    'total' => (int)$row['total']
                ];
                
            } catch(PDOException $e) {
                error_log("Error in getTodayOrdersCount: " . $e->getMessage());
                return false;
            }
        }

        public function getCurrentMonthOrdersCount($userId = null) {
            try {
                $whereClause = " WHERE YEAR(createdDate) = YEAR(CURDATE()) AND MONTH(createdDate) = MONTH(CURDATE())";
                if ($userId !== null) {
                    $whereClause .= " AND userId = :userId";
                }
                
                $query = "
                    SELECT 
                        COUNT(*) as total
                    FROM " . $this->table_name  . $whereClause . " ";
                
                $stmt = $this->conn->prepare($query);
                
                if ($userId !== null) {
                    $stmt->bindParam(':userId', $userId);
                }
                
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return [
                    'total' => (int)$row['total']
                ];
                
            } catch(PDOException $e) {
                error_log("Error in getCurrentMonthOrdersCount: " . $e->getMessage());
                return false;
            }
        }

        public function findStatus() {
            $query = "SELECT * FROM " . $this->table_name . " WHERE parcelStatus  = :status_code AND polarsTrackingcode = :polarsTrackingcode LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status_code', $this->parcelStatus);            
            $stmt->bindParam(':polarsTrackingcode', $this->polarsTrackingcode);
            $stmt->execute();
            return $stmt;
        }

        public function updateOrderByTrackingNumber($trackingNumber, $data) {
            $query = "UPDATE " . $this->table_name . " SET ";

            $fields = [];
            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key";
            }
            $query .= implode(", ", $fields);
            $query .= " WHERE polarsTrackingcode = :trackingNumber";

            $stmt = $this->conn->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(":trackingNumber", $trackingNumber);

            $success = $stmt->execute();

            if ($success) {
                return true;
            
            }

            return false;
        }

        public function getOrderByDriverToday($driverId) {
            // 1. ค้นหา polarsTrackingcode ที่คนขับยิงสถานะวันนี้
            $query = "SELECT polarsTrackingcode 
                    FROM tb_status_history
                    WHERE DATE(status_date) = CURDATE()
                    AND updated_by = :driverId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':driverId', $driverId);
            $stmt->execute();
            $trackingCodes = $stmt->fetchAll(PDO::FETCH_COLUMN);

            
            
            if (empty($trackingCodes)) {
                return [];
            }

            // 2. โหลดข้อมูลหลักจาก tb_shippingorder
            // สร้าง IN query แบบ parameterized
            $in = [];
            $params = [];
            foreach ($trackingCodes as $idx => $code) {
                $key = ":track$idx";
                $in[] = $key;
                $params[$key] = $code;
            }
            $sql = "SELECT o.*, s.status_name FROM tb_shippingorder o        
                LEFT JOIN 
                        " . $this->table_name_status . " s ON o.parcelStatus = s.status_code
                WHERE polarsTrackingcode IN (" . implode(',', $in) . ") AND is_deleted = 0";
            $stmt2 = $this->conn->prepare($sql);
            foreach ($params as $k => $v) {
                $stmt2->bindValue($k, $v);
            }

            $stmt2->execute();
            return $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
        }
    }
?>