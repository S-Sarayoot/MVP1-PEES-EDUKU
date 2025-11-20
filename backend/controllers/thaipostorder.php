<?php
class ThaiPostOrder
{
	// database connection and table name
	private $conn;
	private $table_name = "tb_thaipostorder";

	public $smartpost_trackingcode;
	public $service_type;
	public $orderId;
	public $invNo;
	public $barcode;

	public $shipperName;
	public $shipperAddress;
	public $shipperDistrict;
	public $shipperSubdistrict;
	public $shipperProvince;
	public $shipperZipcode;
	public $shipperEmail;
	public $shipperMobile;

	public $cusName;
	public $cusAdd;
	public $cusAmp;
	public $cusSub;
	public $cusProv;
	public $cusZipcode;
	public $cusTel;
	public $cusEmail;

	public $productPrice;
	public $productInbox;
	public $productWeight;
	public $boxsize;
	public $orderType;
	public $insurance;
	public $insuranceFee;
	public $insuranceRatePrice;

	public $merchantId;
	public $merchantZipcode;
	public $manifestNo;
	public $storeLocationNo;

	public $cost;
	public $finalcost;
	public $order_status;
	public $customer_code;
	public $agent_code;
	public $create_date;
	public $update_date;	
	public $sent_api;
	public $bookbank;
	public $id;

	
	public $co_agent_code;

	
	public $items;
	public $items_array;

	public $prepaid_status;
	public $systemId;


	// constructor with $db as database connection
	public function __construct($db)
	{
		$this->conn = $db;
	}
	// create Order
	function customercreateorder()
	{
		// query to insert record
		$query = "INSERT INTO
							" . $this->table_name . "
				SET
					bookbank=:bookbank,
					smartpost_trackingcode=:smartpost_trackingcode,
					service_type=:service_type,
					barcode=:barcode,
					shipperName=:shipperName,
					shipperAddress=:shipperAddress,
					shipperSubdistrict=:shipperSubdistrict,
					shipperDistrict=:shipperDistrict,
					shipperProvince=:shipperProvince,
					shipperZipcode=:shipperZipcode,
					shipperEmail=:shipperEmail,
					shipperMobile=:shipperMobile,

					cusName=:cusName,
					cusAdd=:cusAdd,
					cusSub=:cusSub,
					cusAmp=:cusAmp,
					cusProv=:cusProv,
					cusZipcode=:cusZipcode,
					cusTel=:cusTel,
					cusEmail=:cusEmail,

					productPrice=:productPrice,
					productInbox=:productInbox,
					productWeight=:productWeight,
					boxsize=:boxsize,

					insurance=:insurance,
					insuranceFee=:insuranceFee,
					insuranceRatePrice=:insuranceRatePrice,

					cost=:cost,
					finalcost=:finalcost,

					order_status=:order_status,	
					
					customer_code=:customer_code,
					agent_code=:agent_code,

					co_agent_code=:co_agent_code,

					create_date=:create_date,
					
					sent_api=:sent_api,
					items=:items,
					systemId=:systemId,
					prepaid_status=:prepaid_status";

		// prepare query
		$stmt = $this->conn->prepare($query);



		// sanitize		
		$this->bookbank = htmlspecialchars(strip_tags($this->bookbank));
		$this->smartpost_trackingcode = htmlspecialchars(strip_tags($this->smartpost_trackingcode));
		$this->service_type = htmlspecialchars(strip_tags($this->service_type));

		$this->barcode = htmlspecialchars(strip_tags($this->barcode));
		$this->shipperName = htmlspecialchars(strip_tags($this->shipperName));
		$this->shipperAddress = htmlspecialchars(strip_tags($this->shipperAddress));
		$this->shipperSubdistrict = htmlspecialchars(strip_tags($this->shipperSubdistrict));
		$this->shipperDistrict = htmlspecialchars(strip_tags($this->shipperDistrict));
		$this->shipperProvince = htmlspecialchars(strip_tags($this->shipperProvince));
		$this->shipperZipcode = htmlspecialchars(strip_tags($this->shipperZipcode));
		$this->shipperEmail = htmlspecialchars(strip_tags($this->shipperEmail));
		$this->shipperMobile = htmlspecialchars(strip_tags($this->shipperMobile));
		$this->cusName = htmlspecialchars(strip_tags($this->cusName));
		$this->cusAdd = htmlspecialchars(strip_tags($this->cusAdd));
		$this->cusSub = htmlspecialchars(strip_tags($this->cusSub));
		$this->cusAmp = htmlspecialchars(strip_tags($this->cusAmp));
		$this->cusProv = htmlspecialchars(strip_tags($this->cusProv));
		$this->cusZipcode = htmlspecialchars(strip_tags($this->cusZipcode));
		$this->cusTel = htmlspecialchars(strip_tags($this->cusTel));
		$this->cusEmail = htmlspecialchars(strip_tags($this->cusEmail));

		$this->productPrice = htmlspecialchars(strip_tags($this->productPrice));
		$this->productInbox = htmlspecialchars(strip_tags($this->productInbox));
		$this->productWeight = htmlspecialchars(strip_tags($this->productWeight));
		$this->boxsize = htmlspecialchars(strip_tags($this->boxsize));
		$this->insurance = htmlspecialchars(strip_tags($this->insurance));
		$this->insuranceFee = htmlspecialchars(strip_tags($this->insuranceFee));
		$this->insuranceRatePrice = htmlspecialchars(strip_tags($this->insuranceRatePrice));

		$this->cost = htmlspecialchars(strip_tags($this->cost));
		$this->finalcost = htmlspecialchars(strip_tags($this->finalcost));
		$this->order_status = htmlspecialchars(strip_tags($this->order_status));
		$this->customer_code = htmlspecialchars(strip_tags($this->customer_code));
		$this->agent_code = htmlspecialchars(strip_tags($this->agent_code));		
		
		$this->co_agent_code = htmlspecialchars(strip_tags($this->co_agent_code));
		
		$this->create_date = htmlspecialchars(strip_tags($this->create_date));
		$this->sent_api = htmlspecialchars(strip_tags($this->sent_api));
		
		$this->items = htmlspecialchars(strip_tags($this->items));
		
		if (!isset($this->systemId)) {
			$this->systemId = null;
		} else {
			$this->systemId = htmlspecialchars(strip_tags($this->systemId));
		}
		if (!isset($this->prepaid_status)) {
			$this->prepaid_status = "N";
		} else {
			$this->prepaid_status = "Y";
		}


		// bind values
		$stmt->bindParam(":bookbank", $this->bookbank);
		$stmt->bindParam(":smartpost_trackingcode", $this->smartpost_trackingcode);
		$stmt->bindParam(":service_type", $this->service_type);

		$stmt->bindParam(":barcode", $this->barcode);
		$stmt->bindParam(":shipperName", $this->shipperName);
		$stmt->bindParam(":shipperAddress", $this->shipperAddress);
		$stmt->bindParam(":shipperSubdistrict", $this->shipperSubdistrict);
		$stmt->bindParam(":shipperDistrict", $this->shipperDistrict);
		$stmt->bindParam(":shipperProvince", $this->shipperProvince);
		$stmt->bindParam(":shipperZipcode", $this->shipperZipcode);
		$stmt->bindParam(":shipperEmail", $this->shipperEmail);
		$stmt->bindParam(":shipperMobile", $this->shipperMobile);
		$stmt->bindParam(":cusName", $this->cusName);
		$stmt->bindParam(":cusAdd", $this->cusAdd);
		$stmt->bindParam(":cusSub", $this->cusSub);
		$stmt->bindParam(":cusAmp", $this->cusAmp);
		$stmt->bindParam(":cusProv", $this->cusProv);
		$stmt->bindParam(":cusZipcode", $this->cusZipcode);
		$stmt->bindParam(":cusTel", $this->cusTel);
		$stmt->bindParam(":cusEmail", $this->cusEmail);

		$stmt->bindParam(":productPrice", $this->productPrice);
		$stmt->bindParam(":productInbox", $this->productInbox);
		$stmt->bindParam(":productWeight", $this->productWeight);
		$stmt->bindParam(":boxsize", $this->boxsize);
		
		$stmt->bindParam(":insurance", $this->insurance);
		$stmt->bindParam(":insuranceFee", $this->insuranceFee);
		$stmt->bindParam(":insuranceRatePrice", $this->insuranceRatePrice);

		$stmt->bindParam(":cost", $this->cost);
		$stmt->bindParam(":finalcost", $this->finalcost);
		$stmt->bindParam(":order_status", $this->order_status);
		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":agent_code", $this->agent_code);
		
		$stmt->bindParam(":co_agent_code", $this->co_agent_code);

		$stmt->bindParam(":create_date", $this->create_date);
		$stmt->bindParam(":sent_api", $this->sent_api);
		
		$stmt->bindParam(":items", $this->items);

		
		$stmt->bindParam(":systemId", $this->systemId);
		$stmt->bindParam(":prepaid_status", $this->prepaid_status);
		// execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}


	function customereditorder()
	{
		// query to update record	
		$query = "UPDATE
							" . $this->table_name . "
				SET
					service_type=:service_type,
					
					productInbox=:productInbox,
					productWeight=:productWeight,
					productPrice=:productPrice,
					boxsize=:boxsize,
					insurance=:insurance,
					insuranceFee=:insuranceFee,
					insuranceRatePrice=:insuranceRatePrice,
					barcode=:barcode,
					shipperName=:shipperName,
					shipperAddress=:shipperAddress,
					shipperSubdistrict=:shipperSubdistrict,
					shipperDistrict=:shipperDistrict,
					shipperProvince=:shipperProvince,
					shipperZipcode=:shipperZipcode,
					shipperEmail=:shipperEmail,
					shipperMobile=:shipperMobile,

					cusName=:cusName,
					cusAdd=:cusAdd,
					cusSub=:cusSub,
					cusAmp=:cusAmp,
					cusProv=:cusProv,
					cusZipcode=:cusZipcode,
					cusTel=:cusTel,

					cost=:cost,
					finalcost=:finalcost,
					update_date=:update_date

				WHERE smartpost_trackingcode=:id";
		// prepare query
		$stmt = $this->conn->prepare($query);





		// bind values
		$stmt->bindParam(":id", $this->smartpost_trackingcode);
		$stmt->bindParam(":barcode", $this->barcode);
		$stmt->bindParam(":service_type", $this->service_type);
		$stmt->bindParam(":productInbox", $this->productInbox);
		$stmt->bindParam(":productWeight", $this->productWeight);
		$stmt->bindParam(":productPrice", $this->productPrice);
		$stmt->bindParam(":boxsize", $this->boxsize);
		$stmt->bindParam(":insurance", $this->insurance);
		$stmt->bindParam(":insuranceFee", $this->insuranceFee);
		$stmt->bindParam(":insuranceRatePrice", $this->insuranceRatePrice);


		$stmt->bindParam(":shipperName", $this->shipperName);
		$stmt->bindParam(":shipperAddress", $this->shipperAddress);
		$stmt->bindParam(":shipperSubdistrict", $this->shipperSubdistrict);
		$stmt->bindParam(":shipperDistrict", $this->shipperDistrict);
		$stmt->bindParam(":shipperProvince", $this->shipperProvince);
		$stmt->bindParam(":shipperZipcode", $this->shipperZipcode);
		$stmt->bindParam(":shipperEmail", $this->shipperEmail);
		$stmt->bindParam(":shipperMobile", $this->shipperMobile);

		$stmt->bindParam(":cusName", $this->cusName);
		$stmt->bindParam(":cusAdd", $this->cusAdd);
		$stmt->bindParam(":cusSub", $this->cusSub);
		$stmt->bindParam(":cusAmp", $this->cusAmp);
		$stmt->bindParam(":cusProv", $this->cusProv);
		$stmt->bindParam(":cusZipcode", $this->cusZipcode);
		$stmt->bindParam(":cusTel", $this->cusTel);


		$stmt->bindParam(":cost", $this->cost);
		$stmt->bindParam(":finalcost", $this->finalcost);
		$stmt->bindParam(":update_date", $this->update_date);

		// execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	//แสดง order ใน customer / คำสั่งซื้อจำนวนมาก
	function customergetallorder($customer_code)
	{

		$query = "SELECT * FROM " . $this->table_name . "
		 WHERE order_status='ลงทะเบียน' 
		 AND customer_code=?
		 ORDER BY smartpost_trackingcode";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code = htmlspecialchars(strip_tags($customer_code));

		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function customerdeleteorder_softdelete($id)
	{
		///////////////////////////////////////////////////////
		// query to insert record
		$query = "UPDATE " . $this->table_name . "
				SET order_status='deleted', sent_api='N'
				WHERE smartpost_trackingcode=:id";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$id = htmlspecialchars(strip_tags($id));

		// bind values
		$stmt->bindParam(":id", $id);
		
		if($stmt->execute()){
			return true;
		}
		return false;
		
	}


	function customerdeleteorder($id)
	{
		///////////////////////////////////////////////////////
		// query to insert record
		$query = "DELETE FROM
					" . $this->table_name . "
				WHERE smartpost_trackingcode=:id";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();
		// execute query
		// if ($stmt->execute()) {
		// 	//return true;
		// }





		// update in 4 table 
		$query = " UPDATE
		tb_thaipostbarcodebank_M_EA
		SET
		smartpost_trackingcode= '',
		status = ''
		 WHERE smartpost_trackingcode=:id";

		$stmt = $this->conn->prepare($query);
		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();

		$query = " UPDATE
		tb_thaipostbarcodebank_M_EB
		SET
		smartpost_trackingcode= '',
		status = ''
		WHERE smartpost_trackingcode=:id";

		$stmt = $this->conn->prepare($query);
		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();






		// query to insert record
		$query = " UPDATE
				tb_thaipostbarcodebank_L_EA
			    SET
				smartpost_trackingcode= '',
				status = ''
				 WHERE smartpost_trackingcode=:id";

		$stmt = $this->conn->prepare($query);
		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();

		$query = " UPDATE
		tb_thaipostbarcodebank_L_EB
		SET
		smartpost_trackingcode= '',
		status = ''
		 WHERE smartpost_trackingcode=:id";

		$stmt = $this->conn->prepare($query);
		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();


		$query = " UPDATE
		tb_thaipostbarcodebank_E_OF
		SET
		smartpost_trackingcode= '',
		status = ''
		 WHERE smartpost_trackingcode=:id";

		$stmt = $this->conn->prepare($query);
		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();




		$query = " UPDATE
		tb_thaipostbarcodebank_R_RF
		SET
		smartpost_trackingcode= '',
		status = ''
		 WHERE smartpost_trackingcode=:id";

		$stmt = $this->conn->prepare($query);
		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();




		return true;
	}

	function customersenddpost_by_barcodes($barcode)
	{
		$barcode_arr = array_map('trim', explode(',', trim($barcode)));
		$barcode_in = str_repeat("?,", count($barcode_arr) - 1) . "?";
		// query to insert record
		$query = " UPDATE
				" . $this->table_name . "
			    SET
				sent_api= 'Y'
 				WHERE barcode IN ($barcode_in)";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// bind values
		$j = 0;
		for ($i = 0; $i < count($barcode_arr); $i++) {
			$j = $j + 1;
			$stmt->bindParam($j, $barcode_arr[$i]);
			
		}

		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function customersenddpost($id)
	{
		// query to insert record
		$query = " UPDATE
				" . $this->table_name . "
			    SET
				sent_api= 'Y'
 				WHERE smartpost_trackingcode=:id";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function customersenddpost_prepaid()
	{
		// query to insert record
		$query = " UPDATE
				" . $this->table_name . "
			    SET
				sent_api= 'Y',
				prepaid_status= 'Y'
 				WHERE smartpost_trackingcode=:id";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function customergetorderbyid_sentapi($id)
	{

		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE smartpost_trackingcode = ? AND sent_api='Y' 
				  ";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$id = htmlspecialchars(strip_tags($id));
		// bind
		$stmt->bindParam(1, $id);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function customergetorderbyid($id)
	{

		// select all query
		//$query = "SELECT * FROM " . $this->table_name + " e, users u WHERE e.staff_id=u.id";
		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE smartpost_trackingcode = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$id = htmlspecialchars(strip_tags($id));
		// bind
		$stmt->bindParam(1, $id);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function customerfinalcostbybarcode($barcode)
	{

		// select all query
		//$query = "SELECT * FROM " . $this->table_name + " e, users u WHERE e.staff_id=u.id";
		$query = "SELECT finalcost,insuranceFee,smartpost_trackingcode,agent_code FROM " . $this->table_name . "
				  WHERE barcode = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$barcode = htmlspecialchars(strip_tags($barcode));
		// bind
		$stmt->bindParam(1, $barcode);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function customercanceldpost($id, $barcode)
	{
		// $tablebarcode = "";
		// $prefix = substr($barcode, 0, 2);

		// if ($prefix == "EA") {
		// 	$tablebarcode = "tb_thaipostbarcodebank_L_EA";
		// } else {

		// 	if ($prefix == "EB") {
		// 		$tablebarcode = "tb_thaipostbarcodebank_L_EB";
		// 	}
		// }

		// // query to insert record
		// $queryClearBarcode = " UPDATE
		// 		" . $tablebarcode . "
		// 	    SET
		// 		status= ''
		// 		WHERE barcode=:barcode";
		// // prepare query
		// $stmtClearBarcode = $this->conn->prepare($queryClearBarcode);

		// // sanitize
		// $this->barcode = htmlspecialchars(strip_tags($this->barcode));

		// // bind values
		// $stmtClearBarcode->bindParam(":barcode", $this->barcode);
		// $stmtClearBarcode->execute();

		/////////////////////////////////////////////////////////////////////



		// query to insert record
		$query = " UPDATE
				" . $this->table_name . "
			    SET
				sent_api= 'N'
 				WHERE smartpost_trackingcode=:id";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}
	
	function customercanceldpost_prepaid()	{
		
		// query to insert record
		$query = " UPDATE
				" . $this->table_name . "
			    SET
				sent_api= 'N',
				prepaid_status= 'N'
 				WHERE smartpost_trackingcode=:id";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(":id", $this->id);
		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function customerfindorders($trackingcode, $startDate, $endDate, $orderstatus, $customer_code)
	{
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";

		// select 
		$query = "SELECT * FROM " . $this->table_name . " WHERE  customer_code=? AND";
		if (!empty($trackingcode)) {
			$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in)) ";
		} else {
			if (!empty($orderstatus)) {
				$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) ";
			} else {
				$query .= " (create_date BETWEEN ? AND ?) AND order_status!='deleted' "; // AND (order_status IN ('ลงทะเบียน,'received')) ";
			}
		}

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $customer_code);

		//set bind parameter
		$j = 1;
		if (!empty($trackingcode)) {
			for ($i = 0; $i < count($trackingcode_arr); $i++) {
				$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
				$j = $j + 1;
			}
			for ($i = 0; $i < count($trackingcode_arr); $i++) {
				$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
				$j = $j + 1;
			}
		} else {
			if (!empty($orderstatus)) {
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);
				$stmt->bindParam($j + 3, $orderstatus);
			} else {
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);
			}
		}

		$stmt->execute();

		return $stmt;
	}

	function showbadge($agent_code)
	{
		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE order_status='ลงทะเบียน' and agent_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code = htmlspecialchars(strip_tags($agent_code));
		// bind
		$stmt->bindParam(1, $agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function customerfindordersbyagent($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{



		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";

		
		// select 
		$query = "SELECT 
				tb_thaipostorder.*,
				tb_thaipost_agentcod.price_l,
				tb_thaipost_agentprice.*
		FROM tb_thaipostorder
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code

		WHERE ";

		if (!empty($customer_code))  //เลือกลูกค้า
		{
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in)  OR barcode IN ($trackingcode_in)) AND tb_thaipostorder.customer_code=? AND tb_thaipostorder.order_status!='deleted'";
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status NOT IN ('ลงทะเบียน','กำลังเข้ารับพัสดุ','รับพัสดุแล้ว','เข้าคลังแล้ว','กำลังนำออกจากคลัง')) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status!='deleted'";
					} else {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status!='deleted'";
					}
				} else {
					$query .= " (create_date BETWEEN ? AND ?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}

				$stmt->bindParam($j + 1, $customer_code);
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $customer_code);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
						$stmt->bindParam($j + 4, $customer_code);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
					$stmt->bindParam($j + 3, $customer_code);
				}
			}

		} else //ไม่เลือกลูกค้า
		{
			
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in)) AND tb_thaipostorder.agent_code=?";
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status NOT IN ('ลงทะเบียน','กำลังเข้ารับพัสดุ','รับพัสดุแล้ว','เข้าคลังแล้ว','กำลังนำออกจากคลัง')) AND (tb_thaipostorder.agent_code=?)";
					} else {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (tb_thaipostorder.agent_code=?)";
					}
				} else {
					$query .= " (create_date BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?)"; // AND  (order_status IN ('ordered','received')) ";
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				$stmt->bindParam($j + 1, $agent_code);
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $agent_code);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
						$stmt->bindParam($j + 4, $agent_code);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
					$stmt->bindParam($j + 3, $agent_code);
				}
			}

			
		}

		$stmt->execute();
		return $stmt;
	}


	function customerfindordersbyco_agent($co_agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{

		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";

		if (!empty($customer_code))  //เลือกลูกค้า
		{
			// select 
			$query = "SELECT * FROM " . $this->table_name . " WHERE ";
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in)  OR barcode IN ($trackingcode_in)) AND customer_code=? AND tb_thaipostorder.order_status!='deleted'";
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status NOT IN ('ลงทะเบียน','กำลังเข้ารับพัสดุ','รับพัสดุแล้ว','เข้าคลังแล้ว','กำลังนำออกจากคลัง')) AND (customer_code=?) AND tb_thaipostorder.order_status!='deleted'";
					} else {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (customer_code=?) AND tb_thaipostorder.order_status!='deleted'";
					}
				} else {
					$query .= " (create_date BETWEEN ? AND ?) AND (customer_code=?)"; // AND  (order_status IN ('ordered','received')) ";
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}

				$stmt->bindParam($j + 1, $customer_code);
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $customer_code);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
						$stmt->bindParam($j + 4, $customer_code);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
					$stmt->bindParam($j + 3, $customer_code);
				}
			}

			$stmt->execute();

			return $stmt;
		} else //ไม่เลือกลูกค้า
		{
			// select 
			$query = "SELECT * FROM " . $this->table_name . " WHERE ";
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in)) AND co_agent_code=?";
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status NOT IN ('ลงทะเบียน','กำลังเข้ารับพัสดุ','รับพัสดุแล้ว','เข้าคลังแล้ว','กำลังนำออกจากคลัง')) AND (co_agent_code=?)";
					} else {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (co_agent_code=?)";
					}
				} else {
					$query .= " (create_date BETWEEN ? AND ?) AND (co_agent_code=?)"; // AND  (order_status IN ('ordered','received')) ";
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				$stmt->bindParam($j + 1, $co_agent_code);
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $co_agent_code);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
						$stmt->bindParam($j + 4, $co_agent_code);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
					$stmt->bindParam($j + 3, $co_agent_code);
				}
			}

			$stmt->execute();

			return $stmt;
		}
	}



	function customerfindordersbysmartpost($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{

		
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";

		$query = "SELECT 
				tb_thaipostorder.*,
				tb_thaipost_agentcod.price_l,
				tb_thaipost_admincod.admin_cod,
				tb_thaipost_agentprice.*,					
				tb_thaipost_adminprice.*  
		FROM " . $this->table_name . " 
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
		
			LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
			LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type
		

		WHERE ";
		if (!empty($agent_code))  //เลือกเอเจนต์
		{
			// select 
			
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					if (!empty($orderstatus)) {
						if ($orderstatus == "Drop แล้ว") {
							$query .= " (tb_thaipostorder.create_date BETWEEN ? AND ?) AND (tb_thaipostorder.order_status != 'ลงทะเบียน') AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?)  AND tb_thaipostorder.order_status!='deleted'";
						} else {
							$query .= " (tb_thaipostorder.create_date BETWEEN ? AND ?) AND (tb_thaipostorder.order_status=?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?)  AND tb_thaipostorder.order_status!='deleted'";
						}
					} else {
						$query .= " (tb_thaipostorder.create_date BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?)"; // AND  (order_status IN ('ordered','received')) ";
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					if (!empty($orderstatus)) {
						if ($orderstatus == "Drop แล้ว") {
							$query .= " (tb_thaipostorder.create_date BETWEEN ? AND ?) AND (tb_thaipostorder.order_status !='ลงทะเบียน') AND (tb_thaipostorder.agent_code=?)  AND tb_thaipostorder.order_status!='deleted'";
						} else {
							$query .= " (tb_thaipostorder.create_date BETWEEN ? AND ?) AND (tb_thaipostorder.order_status=?) AND (tb_thaipostorder.agent_code=?)  AND tb_thaipostorder.order_status!='deleted'";
						}
					} else {
						$query .= " (tb_thaipostorder.create_date BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?)"; // AND (order_status IN ('ordered','received')) ";
					}
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					if (!empty($orderstatus)) {
						//$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";

						if ($orderstatus == "Drop แล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
							$stmt->bindParam($j + 5, $customer_code);
						}
					} else {
						//$query .= " (create_date BETWEEN ? AND ?) AND (agent_code=?) AND (customer_code=?)"; // AND  (order_status IN ('ordered','received')) ";
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $agent_code);
						$stmt->bindParam($j + 4, $customer_code);
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					if (!empty($orderstatus)) {
						//$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
						if ($orderstatus == "Drop แล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
						}
					} else {
						//$query .= " (create_date BETWEEN ? AND ?) AND (agent_code=?)"; // AND (order_status IN ('ordered','received')) ";
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $agent_code);
					}
				}
			}



			
		} else { //ไม่เลือกเอเจนต์
			// select 
			
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in)) ";
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status != 'ลงทะเบียน')  AND tb_thaipostorder.order_status!='deleted'";
					} else {
						$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?)  AND tb_thaipostorder.order_status!='deleted'";
					}
				} else {
					$query .= " (create_date BETWEEN ? AND ?) AND tb_thaipostorder.order_status!='deleted'"; // AND (order_status IN ('ordered','received')) ";
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
				}
			}			
		}

		$stmt->execute();
		return $stmt;
	}



	function discountcost($ids, $parcel_values, $discount_cost, $discount_cost_type)
	{

		$ids_arr = array_map('trim', explode(',', $ids));
		$parcel_values_arr = explode(',', $parcel_values);
		// select 
		$query = "UPDATE " . $this->table_name .
			" SET finalcost=?,updatecostflag = 'Y'
				  WHERE smartpost_trackingcode=?";

		$stmt = $this->conn->prepare($query);

		//set bind parameter

		for ($i = 0; $i < count($ids_arr); $i++) {
			$discount = 0;
			if ($discount_cost_type == "บาท")
				$discount = $parcel_values_arr[$i] - $discount_cost;
			if ($discount_cost_type == "%")
				$discount = $parcel_values_arr[$i] - ceil(($parcel_values_arr[$i] * $discount_cost) / 100.00);

			$stmt->bindParam(1, $discount);
			$stmt->bindParam(2, $ids_arr[$i]);

			$stmt->execute();
		}

		return true;
	}

	function list80($ids)
	{
		$ids_arr = array_map('trim', explode(',', $ids));
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		$query = "SELECT * FROM " . $this->table_name . " WHERE   smartpost_trackingcode IN ($ids_in) ORDER BY smartpost_trackingcode";
		//$query = "SELECT * FROM " . $this->table_name . " WHERE  (sent_api = 'Y') and smartpost_trackingcode IN ($ids_in) ORDER BY smartpost_trackingcode";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 1, $ids_arr[$i]);
		}
		$stmt->execute();

		return $stmt;
	}


	function sticker($ids)
	{
		$ids_arr = array_map('trim', explode(',', $ids));
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		//$query = "SELECT * FROM " . $this->table_name . " WHERE   smartpost_trackingcode IN ($ids_in) ORDER BY smartpost_trackingcode";
		$query = "SELECT * FROM " . $this->table_name . " WHERE  (sent_api = 'Y') and smartpost_trackingcode IN ($ids_in) ORDER BY smartpost_trackingcode";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 1, $ids_arr[$i]);
		}
		$stmt->execute();

		return $stmt;
	}

	function sticker_count_shipper($ids)
	{
		$ids_arr = array_map('trim', explode(',', $ids));
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		$query = "SELECT
				COUNT(DISTINCT(shipperName)) 'status1'
				FROM " . $this->table_name . " WHERE  (sent_api = 'Y') and smartpost_trackingcode IN ($ids_in) ORDER BY smartpost_trackingcode";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 1, $ids_arr[$i]);
		}
		$stmt->execute();

		return $stmt;
	}

	function excel($ids)
	{

		$ids_arr = array_map('trim', explode(',', $ids));
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		$query = "SELECT 
				tb_thaipostorder.*,
				tb_thaipost_agentcod.price_l,
				tb_thaipost_admincod.admin_cod,
				tb_thaipost_agentprice.*,					
				tb_thaipost_adminprice.*  ,					
				tb_customer.customer_name
		FROM " . $this->table_name . " 
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
		LEFT JOIN tb_customer ON tb_thaipostorder.customer_code = tb_customer.customer_code
		LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
		LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type
		
		WHERE smartpost_trackingcode IN ($ids_in) ORDER BY smartpost_trackingcode";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 1, $ids_arr[$i]);
		}
		$stmt->execute();

		return $stmt;
	}


	function ebill($ids)
	{



		$ids_arr = array_map('trim', explode(',', $ids));
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		$query = "SELECT 
						tb_thaipostorder.*,
						tb_thaipost_agentcod.price_l,
						tb_thaipost_agentprice.*
		 	FROM tb_thaipostorder
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
		
		WHERE  smartpost_trackingcode IN ($ids_in) ORDER BY (STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) ASC";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 1, $ids_arr[$i]);
		}
		$stmt->execute();

		return $stmt;
	}



	//แสดงจำนวนการสั่งซื้อบนหน้าแรก
	function getorder($d, $usertype, $user_code)
	{
		$query = "";
		if ($usertype == "customer")
			$query = "SELECT * FROM " . $this->table_name . "
					WHERE Date(create_date)=? 
					AND customer_code = ? AND order_status != 'deleted'
					ORDER BY smartpost_trackingcode";
		else if ($usertype == "agent")
			$query = "SELECT * FROM " . $this->table_name . "
					WHERE Date(create_date)=? 
					AND agent_code = ?
					ORDER BY smartpost_trackingcode";
		else
			$query = "SELECT * FROM " . $this->table_name . "
					WHERE Date(create_date)=? 
					ORDER BY smartpost_trackingcode";
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$d = htmlspecialchars(strip_tags($d));

		// bind
		if ($usertype == "customer" || $usertype == "agent") {
			$stmt->bindParam(1, $d);
			$stmt->bindParam(2, $user_code);
		} else
			$stmt->bindParam(1, $d);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	//แสดงค่าขนส่งบนหน้าแรก
	function getparcel($d, $usertype, $user_code)
	{

		$query = "";
		if ($usertype == "customer")
			$query = "SELECT SUM(finalcost+insuranceFee) as parcel_sum FROM " . $this->table_name . "
				WHERE Date(create_date)=? 
				AND customer_code = ?  AND order_status != 'deleted'";
		else if ($usertype == "agent")
			$query = "SELECT SUM(finalcost) as parcel_sum FROM " . $this->table_name . "
				WHERE Date(create_date)=? 
				AND agent_code = ?";
		else
			$query = "SELECT SUM(finalcost) as parcel_sum FROM " . $this->table_name . "
				WHERE Date(create_date)=? ";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$d = htmlspecialchars(strip_tags($d));

		// bind
		if ($usertype == "customer" || $usertype == "agent") {
			$stmt->bindParam(1, $d);
			$stmt->bindParam(2, $user_code);
		} else
			$stmt->bindParam(1, $d);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	//แสดงค่าขนส่งบนหน้าแรก
	function getparcel_shopprice($d, $sent_api, $user_code)
	{
		
		$query = "";
		if($sent_api == "Y"){
			$query = "SELECT productWeight,cusZipcode,productPrice FROM " . $this->table_name . "
			WHERE Date(create_date)=? 
			AND customer_code = ? AND sent_api='Y'  AND order_status != 'deleted'";
		}else{
			$query = "SELECT productWeight,cusZipcode,productPrice FROM " . $this->table_name . "
			WHERE Date(create_date)=? 
			AND customer_code = ?  AND order_status != 'deleted'";
		}
		
		$customer_code = $user_code;
		
		
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		// sanitize
		$d = htmlspecialchars(strip_tags($d));
		// bind
		
		$stmt->bindParam(1, $d);
		$stmt->bindParam(2, $user_code);
		
		// execute query
		$stmt->execute();
		$summary_shop = 0;

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			$shopprice = 0;
			$query_shopprice = "SELECT * FROM  tb_thaipost_shopprice WHERE customer_code = '". $customer_code."'";
			$stmt_shopprice = $this->conn->prepare($query_shopprice);			
			$stmt_shopprice->execute();
			while($row_shop = $stmt_shopprice->fetch(PDO::FETCH_ASSOC)){

				if($row["productWeight"] <= 20){
					$shopprice = $row_shop["kg_002"];
				}           
				elseif($row["productWeight"] <= 100){
					$shopprice = $row_shop["kg_01"];
				}           
				elseif($row["productWeight"] <= 250){
					$shopprice = $row_shop["kg_025"];
				}          
				elseif($row["productWeight"] <= 500){
					$shopprice = $row_shop["kg_05"];
				}          
				elseif($row["productWeight"] <= 1000){
					$shopprice = $row_shop["kg_1"];
				}          
				elseif($row["productWeight"] <= 1500){
					$shopprice = $row_shop["kg_1500"];
				}          
				elseif($row["productWeight"] <= 2000){
					$shopprice = $row_shop["kg_2"];
				}          
				elseif($row["productWeight"] <= 2500){
					$shopprice = $row_shop["kg_25"];
				}          
				elseif($row["productWeight"] <= 3000){
					$shopprice = $row_shop["kg_3"];
				}          
				elseif($row["productWeight"] <= 3500){
					$shopprice = $row_shop["kg_35"];
				}          
				elseif($row["productWeight"] <= 4000){
					$shopprice = $row_shop["kg_4"];
				}          
				elseif($row["productWeight"] <= 4500){
					$shopprice = $row_shop["kg_45"];
				}          
				elseif($row["productWeight"] <= 5000){
					$shopprice = $row_shop["kg_5"];
				}          
				elseif($row["productWeight"] <= 5500){
					$shopprice = $row_shop["kg_55"];
				}          
				elseif($row["productWeight"] <= 6000){
					$shopprice = $row_shop["kg_6"];
				}          
				elseif($row["productWeight"] <= 6500){
					$shopprice = $row_shop["kg_65"];
				}          
				elseif($row["productWeight"] <= 7000){
					$shopprice = $row_shop["kg_7"];
				}          
				elseif($row["productWeight"] <= 7500){
					$shopprice = $row_shop["kg_75"];
				}          
				elseif($row["productWeight"] <= 8000){
					$shopprice = $row_shop["kg_8"];
				}          
				elseif($row["productWeight"] <= 8500){
					$shopprice = $row_shop["kg_85"];
				}          
				elseif($row["productWeight"] <= 9000){
					$shopprice = $row_shop["kg_9"];
				}          
				elseif($row["productWeight"] <= 9500){
					$shopprice = $row_shop["kg_95"];
				}          
				elseif($row["productWeight"] <= 10000){
					$shopprice = $row_shop["kg_10"];
				}          
				elseif($row["productWeight"] <= 11000){
					$shopprice = $row_shop["kg_11"];
				}                    
				elseif($row["productWeight"] <= 12000){
					$shopprice = $row_shop["kg_12"];
				}                    
				elseif($row["productWeight"] <= 13000){
					$shopprice = $row_shop["kg_13"];
				}                    
				elseif($row["productWeight"] <= 14000){
					$shopprice = $row_shop["kg_14"];
				}                    
				elseif($row["productWeight"] <= 15000){
					$shopprice = $row_shop["kg_15"];
				}                    
				elseif($row["productWeight"] <= 16000){
					$shopprice = $row_shop["kg_16"];
				}                    
				elseif($row["productWeight"] <= 17000){
					$shopprice = $row_shop["kg_17"];
				}                    
				elseif($row["productWeight"] <= 18000){
					$shopprice = $row_shop["kg_18"];
				}                    
				elseif($row["productWeight"] <= 19000){
					$shopprice = $row_shop["kg_19"];
				}                    
				elseif($row["productWeight"] <= 20000){
					$shopprice = $row_shop["kg_20"];
				}                    
				elseif($row["productWeight"] <= 21000){
					$shopprice = $row_shop["kg_21"];
				}                    
				elseif($row["productWeight"] <= 22000){
					$shopprice = $row_shop["kg_22"];
				}                    
				elseif($row["productWeight"] <= 23000){
					$shopprice = $row_shop["kg_23"];
				}                    
				elseif($row["productWeight"] <= 24000){
					$shopprice = $row_shop["kg_24"];
				}                    
				elseif($row["productWeight"] <= 25000){
					$shopprice = $row_shop["kg_250"];
				}                    
				elseif($row["productWeight"] <= 26000){
					$shopprice = $row_shop["kg_26"];
				}                    
				elseif($row["productWeight"] <= 27000){
					$shopprice = $row_shop["kg_27"];
				}                    
				elseif($row["productWeight"] <= 28000){
					$shopprice = $row_shop["kg_28"];
				}                    
				elseif($row["productWeight"] <= 29000){
					$shopprice = $row_shop["kg_29"];
				}                    
				elseif($row["productWeight"] <= 30000){
					$shopprice = $row_shop["kg_30"];
				}                    
				elseif($row["productWeight"] <= 31000){
					$shopprice = $row_shop["kg_31"];
				}                        
				elseif($row["productWeight"] <= 32000){
					$shopprice = $row_shop["kg_32"];
				}                     
				elseif($row["productWeight"] <= 33000){
					$shopprice = $row_shop["kg_33"];
				}                     
				elseif($row["productWeight"] <= 34000){
					$shopprice = $row_shop["kg_34"];
				}                     
				elseif($row["productWeight"] <= 35000){
					$shopprice = $row_shop["kg_350"];
				}                     
				elseif($row["productWeight"] <= 36000){
					$shopprice = $row_shop["kg_36"];
				}                     
				elseif($row["productWeight"] <= 37000){
					$shopprice = $row_shop["kg_37"];
				}                           
				elseif($row["productWeight"] <= 38000){
					$shopprice = $row_shop["kg_38"];
				}                      
				elseif($row["productWeight"] <= 39000){
					$shopprice = $row_shop["kg_39"];
				}                      
				elseif($row["productWeight"] <= 40000){
					$shopprice = $row_shop["kg_40"];
				}        
				else{
					$shopprice = $row_shop["kg_41"];
				}

				//----ดึง COD หน้าร้าน-----
				$shopcod = 0;
				$query_cod = "SELECT * FROM tb_thaipost_shopcod	WHERE customer_code = '".$customer_code."'";
				$stmt_cod = $this->conn->prepare($query_cod);			
				$stmt_cod->execute();
				while($row_cod = $stmt_cod->fetch(PDO::FETCH_ASSOC)){
					$shopcod = $row_cod["price"];   
				}
				  

				//parcel cost
				$summary_shop = $summary_shop + $shopprice + ($row["productPrice"]*($shopcod/100));
				//-----พื้นที่ห่างไกล------
				if($row["productPrice"] <= 1000){
					if($row["cusZipcode"] ==  '20120' 
						|| $row["cusZipcode"] == '23170'
						|| $row["cusZipcode"] == '81150'
						|| $row["cusZipcode"] == '81210'
						|| $row["cusZipcode"] == '82160'
						|| $row["cusZipcode"] == '83000'
						|| $row["cusZipcode"] == '83100'
						|| $row["cusZipcode"] == '83110'
						|| $row["cusZipcode"] == '83120'
						|| $row["cusZipcode"] == '83130'
						|| $row["cusZipcode"] == '83150'
						|| $row["cusZipcode"] == '84140'
						|| $row["cusZipcode"] == '84280'
						|| $row["cusZipcode"] == '84310'
						|| $row["cusZipcode"] == '84320'
						|| $row["cusZipcode"] == '84330'
						|| $row["cusZipcode"] == '84360' )
					{
						$summary_shop = $summary_shop + 15;
					}
				}
			}
        }

        
		return $summary_shop;
	}

	//แสดงจำนวน COD บนหน้าแรก
	function getCOD($d, $usertype, $user_code)
	{

		$query = "";
		if ($usertype == "customer")
			$query = "SELECT SUM(productPrice) as cod_sum FROM " . $this->table_name . "
				WHERE Date(create_date)=? 
				AND customer_code = ?  AND order_status != 'deleted'";
		else if ($usertype == "agent")
			$query = "SELECT SUM(productPrice) as cod_sum FROM " . $this->table_name . "
				WHERE Date(create_date)=? 
				AND agent_code = ?";
		else
			$query = "SELECT SUM(productPrice) as cod_sum FROM " . $this->table_name . "
				WHERE Date(create_date)=? ";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$d = htmlspecialchars(strip_tags($d));

		// bind
		if ($usertype == "customer" || $usertype == "agent") {
			$stmt->bindParam(1, $d);
			$stmt->bindParam(2, $user_code);
		} else
			$stmt->bindParam(1, $d);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	//ข้อมูลบน pie chart

	function statuschart($startDate, $endDate,$usertype,$user_code)
	{
		$query = "SELECT 
					COUNT(IF(order_status != 'นำจ่ายถึงผู้รับแล้ว' AND order_status != 'ปณ.ปลายทางส่งคืน' , 1, NULL)) 'status1',
					COUNT(IF(order_status = 'นำจ่ายถึงผู้รับแล้ว', 1, NULL)) 'status2',
					COUNT(IF(order_status = 'ปณ.ปลายทางส่งคืน', 1, NULL)) 'status3'
			 	FROM " . $this->table_name . "
					WHERE ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)";		

		if($usertype == "customer")
			$query .= " AND customer_code = ?  AND order_status != 'deleted'";
		else if($usertype == "agent")
			$query .= " AND agent_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		//$d = htmlspecialchars(strip_tags($d));

		// bind
		if ($usertype == "customer" || $usertype == "agent") {
			$stmt->bindParam(1, $startDate);			
			$stmt->bindParam(2, $endDate);
			$stmt->bindParam(3, $user_code);
		} else
			$stmt->bindParam(1, $startDate);			
			$stmt->bindParam(2, $endDate);


		// execute query
		$stmt->execute();

		return $stmt;
	}

	//---Select order--------
	function getprofit($startDate, $endDate, $usertype, $user_code)
	{
		$query = "";		
		if ($usertype == "agent"){
			$query = "SELECT 
							tb_thaipostorder.*,
							tb_thaipost_agentcod.price_l,
							tb_thaipost_admincod.admin_cod,
							tb_thaipost_agentprice.*,					
							tb_thaipost_adminprice.*  
					FROM " . $this->table_name . " 
					LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
					LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
					LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
					LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type
					WHERE ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) 
					AND tb_thaipostorder.agent_code=?
					AND tb_thaipostorder.sent_api='Y' ";
		}else{
			$query = "SELECT 
							tb_thaipostorder.*,
							tb_thaipost_agentcod.price_l,
							tb_thaipost_admincod.admin_cod,
							tb_thaipost_agentprice.*,					
							tb_thaipost_adminprice.*  
					FROM " . $this->table_name . " 
					LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
					LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
					LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
					LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type
					WHERE ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.sent_api='Y'  AND order_status != 'deleted'";
		}
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind
		if ($usertype == "agent") {
			$stmt->bindParam(1, $startDate);			
			$stmt->bindParam(2, $endDate);
			$stmt->bindParam(3, $user_code);
		} else
			$stmt->bindParam(1, $startDate);			
			$stmt->bindParam(2, $endDate);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	
	//การเติบโตของจำนวน
	function getcount($day, $usertype, $user_code)
	{
		$query = "";
		if ($usertype == "customer")
			$query = "SELECT COUNT(*) FROM " . $this->table_name . "
					WHERE Date(STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) =? 
					AND customer_code = ?
					ORDER BY smartpost_trackingcode";
		else if ($usertype == "agent")
			$query = "SELECT COUNT(*) FROM " . $this->table_name . "
					WHERE Date(STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s'))=? 
					AND agent_code = ?
					ORDER BY smartpost_trackingcode";
		else
			$query = "SELECT COUNT(*) FROM " . $this->table_name . "
					WHERE Date(STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s'))=? 
					ORDER BY smartpost_trackingcode";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		//$d = htmlspecialchars(strip_tags($day));

		// bind
		if ($usertype == "customer" || $usertype == "agent") {
			$stmt->bindParam(1, $day);
			$stmt->bindParam(2, $user_code);
		} else
			$stmt->bindParam(1, $day);

		// execute query
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_NUM);

		return $result;
	}
	//การเติบโตของรายได้
	function getprice($day, $usertype, $user_code)
	{

		$query = "";
		if ($usertype == "customer")
			$query = "SELECT SUM(finalcost) as sumparcel FROM " . $this->table_name . "
				WHERE Date(create_date)=? 
				AND customer_code = ?";
		else if ($usertype == "agent")
			$query = "SELECT SUM(finalcost) as sumparcel FROM " . $this->table_name . "
				WHERE Date(create_date)=?
				AND agent_code = ?";
		else
			$query = "SELECT SUM(finalcost) as sumparcel FROM " . $this->table_name . "
				WHERE Date(create_date)=? ";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$d = htmlspecialchars(strip_tags($day));

		// bind
		if ($usertype == "customer" || $usertype == "agent") {
			$stmt->bindParam(1, $d);
			$stmt->bindParam(2, $user_code);
		} else
			$stmt->bindParam(1, $d);

		// execute query
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);


		return $sumparcel;
	}

	function updatestatus($status, $ids)
	{

		$ids_arr = explode(',', $ids);
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		$query = "UPDATE " . $this->table_name .
			" SET order_status=? 
				  WHERE  smartpost_trackingcode IN ($ids_in)";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $status);
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 2, $ids_arr[$i]);
		}
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function reset_dpost($ids)
	{

		$ids_arr = explode(',', $ids);
		$ids_in = str_repeat("?,", count($ids_arr) - 1) . "?";

		// select 
		$query = "UPDATE " . $this->table_name .
			" SET sent_api = 'Y'
				  WHERE  barcode IN ($ids_in)";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		for ($i = 0; $i < count($ids_arr); $i++) {
			$stmt->bindParam($i + 1, $ids_arr[$i]);
		}
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function updateproductWeight($barcode, $productWeight)
	{
		// select 
		$query = "UPDATE " . $this->table_name .
			" SET productWeight=? 
				  WHERE barcode=?";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $productWeight);
		$stmt->bindParam(2, $barcode);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}



	function updatecost($barcode, $cost)
	{
		// select 
		$query = "UPDATE " . $this->table_name .
			" SET cost=? 
				  WHERE barcode=?";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $cost);
		$stmt->bindParam(2, $barcode);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function updatecost_finalcost($barcode, $cost)
	{
		// select 
		$query = "UPDATE " . $this->table_name .
			" SET finalcost=? , updatecostflag='Y'
				  WHERE barcode=? ";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $cost);
		$stmt->bindParam(2, $barcode);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}




	function getweightfromthaipostregistrationprice()
	{
		$query = "select * from tb_thaipostregistrationprice order by weight asc";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize

		// bind

		// execute query
		$stmt->execute();
		return $stmt;
	}

	function getweightfromthaipostemsprice()
	{
		$query = "select * from tb_thaipostemsprice order by weight asc";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize

		// bind

		// execute query
		$stmt->execute();
		return $stmt;
	}

	function updatestatusfromdpost($barcode, $status, $dropoffdate, $statusdate)
	{
		// query 
		$query = " UPDATE
				" . $this->table_name . "
			    SET
				order_status=:status,
				statusdate=:statusdate,
				dropoffdate=:dropoffdate
 				WHERE barcode=:barcode";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$barcode = htmlspecialchars(strip_tags($barcode));
		$status = htmlspecialchars(strip_tags($status));
		$statusdate = htmlspecialchars(strip_tags($statusdate));
		$dropoffdate = htmlspecialchars(strip_tags($dropoffdate));

		// bind values
		$stmt->bindParam(":barcode", $barcode);
		$stmt->bindParam(":status", $status);
		$stmt->bindParam(":statusdate", $statusdate);
		$stmt->bindParam(":dropoffdate", $dropoffdate);

		// execute query
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}



	function servicepricebysmartpost($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";
		

		if (!empty($agent_code))  //เลือกเอเจนต์
		{
			// select 
			$query = "SELECT * FROM " . $this->table_name . " WHERE ";
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					
						$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status != 'ลงทะเบียน') AND (agent_code=?) AND (customer_code=?)   AND order_status!='deleted'";
					
					
					
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
						//ไม่เลือกประเภท
						$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status !='ลงทะเบียน') AND (agent_code=?)   AND order_status!='deleted'";
					
				}
			}	

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					if (!empty($orderstatus)) {
						//$query .= " (dropoffdate BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";

						if ($orderstatus == "Drop แล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
							$stmt->bindParam($j + 5, $customer_code);
						}
					} else { //ไม่เลือก orderstatus เลือกลูกค้าของเอเจนต์
						if(!empty($category)){
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
							$stmt->bindParam($j + 5, $category);
						}else{
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
						}
						
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					if (!empty($orderstatus)) {
						//$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
						if ($orderstatus == "ปณ.ต้นทางรับฝากแล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
						}
					} else { //ไม่เลือก orderstatus ไม่เลือกลูกค้าของเอเจนต์
						
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
						

						
					}
				}
			}



			$stmt->execute();

			return $stmt;
		} else { //ไม่เลือกเอเจนต์
			// select 
			$query = "SELECT * FROM " . $this->table_name . " WHERE ";
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in)) ";
			} else {				
				$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status != 'ลงทะเบียน')   AND order_status!='deleted'";		
			}
			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {   //Drop แล้ว
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
				}
			}

			$stmt->execute();

			return $stmt;
		}
	}

	function servicepricebysmartpost_new($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";
		
		// select 
		$query = "SELECT 
				tb_thaipostorder.*,
				tb_thaipost_agentcod.price_l,
				tb_thaipost_admincod.admin_cod,
				tb_thaipost_agentprice.*,					
				tb_thaipost_adminprice.*  
			FROM 
				tb_thaipostorder
			LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
			LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
			
			LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
			LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type

			WHERE 		
		";
		//CROSS JOIN tb_thaipost_admincod
		//CROSS JOIN tb_thaipost_adminprice
		//LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
		//LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type

		if (!empty($agent_code))  //เลือกเอเจนต์
		{
			
			if (!empty($trackingcode)) {
				$query .= " (tb_thaipostorder.smartpost_trackingcode IN ($trackingcode_in) OR tb_thaipostorder.barcode IN ($trackingcode_in))";
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					
						$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.order_status != 'ลงทะเบียน') AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?)   AND tb_thaipostorder.order_status!='deleted'";
					
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
						//ไม่เลือกประเภท
						$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.order_status !='ลงทะเบียน') AND (tb_thaipostorder.agent_code=?)   AND tb_thaipostorder.order_status!='deleted'";					
				}
			}	

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					if (!empty($orderstatus)) {
						//$query .= " (dropoffdate BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";

						if ($orderstatus == "Drop แล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
							$stmt->bindParam($j + 5, $customer_code);
						}
					} else { //ไม่เลือก orderstatus เลือกลูกค้าของเอเจนต์
						if(!empty($category)){
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
							$stmt->bindParam($j + 5, $category);
						}else{
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
						}
						
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					if (!empty($orderstatus)) {
						//$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
						if ($orderstatus == "ปณ.ต้นทางรับฝากแล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
						}
					} else { //ไม่เลือก orderstatus ไม่เลือกลูกค้าของเอเจนต์						
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);						
					}
				}
			}



			
		} else { //ไม่เลือกเอเจนต์
			
			if (!empty($trackingcode)) {
				$query .= " (tb_thaipostorder.smartpost_trackingcode IN ($trackingcode_in) OR tb_thaipostorder.barcode IN ($trackingcode_in)) ";
			} else {				
				$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.order_status != 'ลงทะเบียน') ";		
			}
			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($orderstatus)) {
					if ($orderstatus == "Drop แล้ว") {   //Drop แล้ว
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
					}
				} else {
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
				}
			}

		}

		$stmt->execute();
		return $stmt;

	}




	function servicepricebyagent($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";
		
		"SELECT 
		tb_thaipostorder.*,
		tb_thaipost_agentcod.price_l,
		tb_thaipost_admincod.admin_cod,
		tb_thaipost_agentprice.*,					
		tb_thaipost_adminprice.*  
			FROM 
				tb_thaipostorder
			LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
			LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
			LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
			LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type

			WHERE 		
		";

		$query = "SELECT 
		tb_thaipostorder.*,
		tb_thaipost_agentcod.price_l,
		tb_thaipost_agentprice.*
		
		FROM " . $this->table_name . " 
		
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code

		WHERE ";


		if (!empty($trackingcode)) {
			$query .= " (tb_thaipostorder.smartpost_trackingcode IN ($trackingcode_in) OR tb_thaipostorder.barcode IN ($trackingcode_in))";
		} else {
			if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
				$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.order_status != 'ลงทะเบียน') AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?)   AND tb_thaipostorder.order_status!='deleted'";
					
			} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.order_status !='ลงทะเบียน') AND (tb_thaipostorder.agent_code=?)   AND tb_thaipostorder.order_status!='deleted'";
				}
		}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					if (!empty($orderstatus)) {
						//$query .= " (dropoffdate BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";

						if ($orderstatus == "Drop แล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
							$stmt->bindParam($j + 4, $customer_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
							$stmt->bindParam($j + 5, $customer_code);
						}
					} else {
						//$query .= " (create_date BETWEEN ? AND ?) AND (agent_code=?) AND (customer_code=?)"; // AND  (order_status IN ('ordered','received')) ";
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $agent_code);
						$stmt->bindParam($j + 4, $customer_code);
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					if (!empty($orderstatus)) {
						//$query .= " (create_date BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
						if ($orderstatus == "ปณ.ต้นทางรับฝากแล้ว") {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $agent_code);
						} else {
							$stmt->bindParam($j + 1, $startDate);
							$stmt->bindParam($j + 2, $endDate);
							$stmt->bindParam($j + 3, $orderstatus);
							$stmt->bindParam($j + 4, $agent_code);
						}
					} else {
						//$query .= " (create_date BETWEEN ? AND ?) AND (agent_code=?)"; // AND (order_status IN ('ordered','received')) ";
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $agent_code);
					}
				}
			}



			$stmt->execute();

			return $stmt;
		
	}

	function servicepricebyco_agent($co_agent_code,$customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";
		


		$query = "SELECT * FROM " . $this->table_name . " WHERE ";
		if (!empty($trackingcode)) {
			$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
		} else {
			if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
				if(!empty($orderstatus)){
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status != 'ลงทะเบียน') AND (order_status=?) AND (customer_code=?) AND (co_agent_code=?)   AND order_status!='deleted'";
				}else{
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status != 'ลงทะเบียน') AND (customer_code=?) AND (co_agent_code=?)  AND order_status!='deleted'";
				}
								
			} else //ไม่เลือกลูกค้าของเอเจนต์
			{
				if(!empty($orderstatus)){
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status !='ลงทะเบียน') AND (order_status=?) AND (co_agent_code=?)   AND order_status!='deleted'";
				}else{
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (order_status !='ลงทะเบียน') AND (co_agent_code=?)   AND order_status!='deleted'";
				}				
			}				
		}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					if (!empty($orderstatus)) {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
						$stmt->bindParam($j + 4, $customer_code);
						$stmt->bindParam($j + 5, $co_agent_code);
						
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $customer_code);
						$stmt->bindParam($j + 4, $co_agent_code);
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					if (!empty($orderstatus)) {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $orderstatus);
						$stmt->bindParam($j + 4, $co_agent_code);
						
					} else {
						$stmt->bindParam($j + 1, $startDate);
						$stmt->bindParam($j + 2, $endDate);
						$stmt->bindParam($j + 3, $co_agent_code);
					}
				}
			}



			$stmt->execute();

			return $stmt;
		
	}

	function findorderscostbyagent($agent_code, $type )
	{
		
		// select 
		$query = "SELECT * FROM tb_thaipost_agentprice WHERE agent_code='$agent_code' and type='$type'
		";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function findorderscostbyco_agent($co_agent_code, $type )
	{
		
		// select 
		$query = "SELECT * FROM tb_thaipost_co_agentprice WHERE co_agent_code='$co_agent_code' and type='$type'
		";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function findorderscostbyadmin( $type )
	{
		
		// select 
		$query = "SELECT * FROM tb_thaipost_adminprice WHERE type='$type'
		";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function findorderscostbycustomer($customer_code, $weight )
	{
		
		// select 
		$query = "SELECT * FROM tb_thaidiscountprofile WHERE customer_code='$customer_code' and weightlower='$weight'
		";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function findcodcostbyagent($agent_code)
	{
		
		// select 
		$query = "SELECT price_l,price FROM tb_thaipost_agentcod WHERE agent_code='$agent_code' 
		";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}
	function findcodcostbycustomer($customer_code)
	{
		
		// select 
		$query = "SELECT * FROM  tb_thaidiscountprofilecod WHERE customer_code='$customer_code' 
		";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}


	function findcodbysmartpost($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{

		
		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";


		$query = "SELECT 
				tb_thaipostorder.*,
				tb_thaipost_agentcod.price_l,
				tb_thaipost_admincod.admin_cod,
				tb_thaipost_agentprice.*,					
				tb_thaipost_adminprice.*  
		FROM " . $this->table_name . " 
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
		LEFT JOIN tb_thaipost_adminprice ON tb_thaipostorder.service_type = tb_thaipost_adminprice.type
		LEFT JOIN tb_thaipost_admincod ON tb_thaipostorder.service_type = tb_thaipost_admincod.type
		WHERE  ";



		if (!empty($agent_code))  //เลือกเอเจนต์
		{
			// select 
			
			if (!empty($trackingcode)) {
				$query .= " (tb_thaipostorder.smartpost_trackingcode IN ($trackingcode_in) OR tb_thaipostorder.barcode IN ($trackingcode_in)) ORDER BY FIELD(barcode, ($trackingcode_in))";
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์

					//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";
					if($orderstatus == "สถานะนำจ่าย/ชำระเงินเรียบร้อย"){
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.productPrice > 0 AND tb_thaipostorder.order_status IN ('นำจ่าย/ชำระเงินเรียบร้อย')   AND tb_thaipostorder.order_status!='deleted'";
					}
					else if ($orderstatus == "สถานะนำจ่ายถึงผู้รับแล้วหรือนำจ่าย/ชำระเงินเรียบร้อย") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.productPrice > 0 AND tb_thaipostorder.order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย')   AND tb_thaipostorder.order_status!='deleted'";
					}
					else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND (tb_thaipostorder.cod_tb_status is not null) AND (tb_thaipostorder.cod_cs_status is not null)   AND tb_thaipostorder.order_status!='deleted'";
					} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว' AND tb_thaipostorder.cod_tb_status is null   AND tb_thaipostorder.order_status!='deleted'";
					} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.cod_tb_status IN ('ได้รับ COD จาก Thaipost แล้ว','ได้รับ COD จาก Myorder แล้ว') AND tb_thaipostorder.cod_cs_status is null  AND tb_thaipostorder.order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
					} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status IN ('นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0 AND (tb_thaipostorder.cod_tb_status is null) AND (tb_thaipostorder.cod_cs_status is null)   AND tb_thaipostorder.order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
					} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status NOT IN ('นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0   AND tb_thaipostorder.order_status!='deleted'";
					}
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
					if($orderstatus == "สถานะนำจ่าย/ชำระเงินเรียบร้อย"){
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.productPrice > 0  AND tb_thaipostorder.order_status IN ('นำจ่าย/ชำระเงินเรียบร้อย')  AND tb_thaipostorder.order_status!='deleted'";
					}
					else if ($orderstatus == "สถานะนำจ่ายถึงผู้รับแล้วหรือนำจ่าย/ชำระเงินเรียบร้อย") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.productPrice > 0  AND tb_thaipostorder.order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย')  AND tb_thaipostorder.order_status!='deleted'";
					}
					else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND (tb_thaipostorder.cod_tb_status is not null) AND (tb_thaipostorder.cod_cs_status is not null)   AND tb_thaipostorder.order_status!='deleted'";
					} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว' AND tb_thaipostorder.cod_tb_status is null   AND tb_thaipostorder.order_status!='deleted'";
					} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.cod_tb_status IN ('ได้รับ COD จาก Thaipost แล้ว','ได้รับ COD จาก Myorder แล้ว')  AND tb_thaipostorder.cod_cs_status is null  AND tb_thaipostorder.order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
					} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=?  AND tb_thaipostorder.order_status IN ('นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0 AND (tb_thaipostorder.cod_tb_status is null) AND (tb_thaipostorder.cod_cs_status is null)   AND tb_thaipostorder.order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
					} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
						$query .= " ((STR_TO_DATE(tb_thaipostorder.statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.order_status NOT IN ('นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0    AND tb_thaipostorder.order_status!='deleted'";
					}	
				}
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {	
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {
				if (!empty($customer_code)) { //เลือกลูกค้าของเอเจนต์
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
					$stmt->bindParam($j + 3, $agent_code);
					$stmt->bindParam($j + 4, $customer_code);
				} else //ไม่เลือกลูกค้าของเอเจนต์
				{
					//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
					$stmt->bindParam($j + 1, $startDate);
					$stmt->bindParam($j + 2, $endDate);
					$stmt->bindParam($j + 3, $agent_code);
				}
			}


		} else { //ไม่เลือกเอเจนต์
			// select 
			
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
			} else {
				if($orderstatus == "สถานะนำจ่าย/ชำระเงินเรียบร้อย"){
					$query .= " ((STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND productPrice > 0  AND order_status IN ('นำจ่าย/ชำระเงินเรียบร้อย')";
				}
				else if ($orderstatus == "สถานะนำจ่ายถึงผู้รับแล้วหรือนำจ่าย/ชำระเงินเรียบร้อย") {
					$query .= " ((STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND productPrice > 0  AND order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย')";
				}
				else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND (cod_tb_status is not null) AND (cod_cs_status is not null) ";
				} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว'  AND cod_tb_status is null";
				} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
					$query .= " ((STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND cod_tb_status='ได้รับ COD จาก Thaipost แล้ว'  AND cod_cs_status is null"; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
					$query .= " ((STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND order_status IN ('นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0 AND (cod_tb_status is null) AND (cod_cs_status is null) "; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
					$query .= " ( (STR_TO_DATE(statusdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND order_status NOT IN ('นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0  ";
				}				
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}


			} else {
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);
			}

			
		}
		$stmt->execute();

		return $stmt;
	}



	function findcodbyagent($agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{

		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";

		// select 
		$query = "SELECT 

		tb_thaipostorder.*,
		tb_thaipost_agentcod.price_l,
		tb_thaipost_agentprice.*

		FROM " . $this->table_name . " 
		LEFT JOIN tb_thaipost_agentprice ON tb_thaipostorder.agent_code = tb_thaipost_agentprice.agent_code
		LEFT JOIN tb_thaipost_agentcod ON tb_thaipostorder.agent_code = tb_thaipost_agentcod.agent_code
		WHERE  ";


		if (!empty($customer_code))  //เลือกลูกค้า
		{
			
			if (!empty($trackingcode)) {
				$query .= " (tb_thaipostorder.smartpost_trackingcode IN ($trackingcode_in) OR tb_thaipostorder.barcode IN ($trackingcode_in))";
			} else {
				//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";
				if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND (tb_thaipostorder.cod_tb_status is not null) AND (tb_thaipostorder.cod_cs_status is not null)  AND tb_thaipostorder.order_status!='deleted'";
				} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว'   AND tb_thaipostorder.cod_tb_status is null  AND tb_thaipostorder.order_status!='deleted'";
				} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.cod_tb_status='ได้รับ COD จาก Thaipost แล้ว'   AND tb_thaipostorder.cod_cs_status is null  AND tb_thaipostorder.order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (tb_thaipostorder.agent_code=?) AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0 AND (tb_thaipostorder.cod_tb_status is null) AND (tb_thaipostorder.cod_cs_status is null)  AND tb_thaipostorder.order_status!='deleted' "; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND (tb_thaipostorder.customer_code=?) AND tb_thaipostorder.order_status NOT IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0   AND tb_thaipostorder.order_status!='deleted'";
				}							
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {				
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);
				$stmt->bindParam($j + 3, $agent_code);
				$stmt->bindParam($j + 4, $customer_code);				
			}


			$stmt->execute();
			return $stmt;

		} else { //ไม่เลือกลูกค้า
			if (!empty($trackingcode)) {
				$query .= " (tb_thaipostorder.smartpost_trackingcode IN ($trackingcode_in) OR tb_thaipostorder.barcode IN ($trackingcode_in))";
			} else {
				//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
				if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND (tb_thaipostorder.cod_tb_status is not null) AND (tb_thaipostorder.cod_cs_status is not null) ";
				} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว' AND tb_thaipostorder.cod_tb_status is null";
				} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.cod_tb_status='ได้รับ COD จาก Thaipost แล้ว' AND tb_thaipostorder.cod_cs_status is null"; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND tb_thaipostorder.agent_code=?  AND tb_thaipostorder.order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0 AND (tb_thaipostorder.cod_tb_status is null) AND (tb_thaipostorder.cod_cs_status is null) "; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
					$query .= " ((STR_TO_DATE(tb_thaipostorder.dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)AND tb_thaipostorder.agent_code=? AND tb_thaipostorder.order_status NOT IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND tb_thaipostorder.productPrice > 0  ";
				}				
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}


			} else {
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);				
				$stmt->bindParam($j + 3, $agent_code);
			}

			$stmt->execute();

			return $stmt;
		}
	}

	function findcodbyco_agent($co_agent_code, $customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{

		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";
		
		if (!empty($customer_code))  //เลือกลูกค้า
		{
			// select 
			$query = "SELECT * FROM " . $this->table_name . " WHERE  ";
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
			} else {
				if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (co_agent_code=?) AND (customer_code=?) AND (cod_tb_status is not null) AND (cod_cs_status is not null)  AND order_status!='deleted'";
				} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (co_agent_code=?) AND (customer_code=?) AND cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว'   AND cod_tb_status is null  AND order_status!='deleted'";
				} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (co_agent_code=?) AND (customer_code=?) AND cod_tb_status='ได้รับ COD จาก Thaipost แล้ว'   AND cod_cs_status is null  AND order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (co_agent_code=?) AND (customer_code=?) AND order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0 AND (cod_tb_status is null) AND (cod_cs_status is null)  AND order_status!='deleted'"; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND co_agent_code=? AND (customer_code=?) AND order_status NOT IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0  AND order_status!='deleted'";
				}							
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}
			} else {				
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);
				$stmt->bindParam($j + 3, $co_agent_code);
				$stmt->bindParam($j + 4, $customer_code);				
			}


			$stmt->execute();
			return $stmt;

		} else { //ไม่เลือกลูกค้า
			// select 
			$query = "SELECT * FROM " . $this->table_name . " WHERE  ";
			if (!empty($trackingcode)) {
				$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
			} else {
				//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?)";
				if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว และจ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND co_agent_code=? AND (cod_tb_status is not null) AND (cod_cs_status is not null) ";
				} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND co_agent_code=? AND cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว' AND cod_tb_status is null";
				} else if ($orderstatus == "ได้รับ COD จาก Thaipost แล้ว") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND co_agent_code=? AND cod_tb_status='ได้รับ COD จาก Thaipost แล้ว' AND cod_cs_status is null"; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND co_agent_code=?  AND order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0 AND (cod_tb_status is null) AND (cod_cs_status is null) "; // AND  (order_status IN ('ordered','received')) ";
				} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
					$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)AND co_agent_code=? AND order_status NOT IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0  ";
				}				
			}

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$j = 0;
			if (!empty($trackingcode)) {
				for ($i = 0; $i < count($trackingcode_arr); $i++) {
					$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
					$j = $j + 1;
				}


			} else {
				$stmt->bindParam($j + 1, $startDate);
				$stmt->bindParam($j + 2, $endDate);				
				$stmt->bindParam($j + 3, $co_agent_code);
			}

			$stmt->execute();

			return $stmt;
		}
	}

	function findcodbycustomer($customer_code, $trackingcode, $startDate, $endDate, $orderstatus)
	{

		$trackingcode = trim($trackingcode);
		$trackingcode_arr = array_map('trim', explode(',', trim($trackingcode)));
		$trackingcode_in = str_repeat("?,", count($trackingcode_arr) - 1) . "?";
		

		$query = "SELECT * FROM " . $this->table_name . " WHERE  ";
		if (!empty($trackingcode)) {
			$query .= " (smartpost_trackingcode IN ($trackingcode_in) OR barcode IN ($trackingcode_in))";
		} else {
				//$query .= " (createordertime BETWEEN ? AND ?) AND (order_status=?) AND (agent_code=?) AND (customer_code=?)";
			if ($orderstatus == "") {
				$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?) AND (customer_code=?) AND order_status!='deleted' ";
			} else if ($orderstatus == "จ่าย COD ให้ลูกค้าแล้ว") {
				$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND (customer_code=?) AND order_status!='deleted' AND cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว'  AND cod_tb_status is null";
			} else if ($orderstatus == "พัสดุนำส่งสำเร็จแล้ว แต่ยังไม่ได้จ่ายเงิน COD ลูกค้า") {
				$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND (customer_code=?) AND order_status!='deleted' AND order_status IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0 AND (cod_tb_status is null) AND (cod_cs_status is null) "; // AND  (order_status IN ('ordered','received')) ";
			} else if ($orderstatus == "พัสดุอยู่ระหว่างนำส่ง") {
				$query .= " ((STR_TO_DATE(dropoffdate, '%d/%m/%Y %H:%i:%s')) BETWEEN ? AND ?)  AND (customer_code=?) AND order_status!='deleted' AND order_status NOT IN ('นำจ่ายถึงผู้รับแล้ว','นำจ่าย/ชำระเงินเรียบร้อย') AND productPrice > 0 ";
			}							
		}
		$stmt = $this->conn->prepare($query);

			//set bind parameter
		$j = 0;
		if (!empty($trackingcode)) {
			for ($i = 0; $i < count($trackingcode_arr); $i++) {
				$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
				$j = $j + 1;
			}
			for ($i = 0; $i < count($trackingcode_arr); $i++) {
				$stmt->bindParam($j + 1, $trackingcode_arr[$i]);
				$j = $j + 1;
			}
		} else {				
			$stmt->bindParam($j + 1, $startDate);
			$stmt->bindParam($j + 2, $endDate);
			$stmt->bindParam($j + 3, $customer_code);				
		}
		$stmt->execute();
		return $stmt;		
	}
	/* update cod previous version
	function updatestatuscod($barcode, $status, $update_date)
	{
		if ($status == "จ่าย COD ให้ลูกค้าแล้ว") {
			$query = "UPDATE " . $this->table_name .
				" SET cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว',cs_status_update=?
				  WHERE barcode=? AND cod_cs_status is null";

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$stmt->bindParam(1, $update_date);
			$stmt->bindParam(2, $barcode);
			$stmt->execute();
			$count = $stmt->rowCount();
			if ($count > 0) {
				return $count;
			}

			return 0;
		}
		if ($status == "ได้รับ COD จาก Thaipost แล้ว") {
			$query = "UPDATE " . $this->table_name .
				" SET cod_tb_status='ได้รับ COD จาก Thaipost แล้ว',tb_status_update=?
				  WHERE barcode=? AND cod_tb_status is null";

			$stmt = $this->conn->prepare($query);

			//set bind parameter
			$stmt->bindParam(1, $update_date);
			$stmt->bindParam(2, $barcode);
			$stmt->execute();
			$count = $stmt->rowCount();
			if ($count > 0) {
				return $count;
			}

			return 0;
		}
	}
	*/

	function updatestatuscod_paid($barcode,  $update_date)
	{
		$barcode = trim($barcode);
		$barcode_arr = explode(",", $barcode);
		$barcode_in = str_repeat("?,", count($barcode_arr)-1 ) ."?";

		$query = "UPDATE " . $this->table_name .
			" SET cod_cs_status='จ่าย COD ให้ลูกค้าแล้ว',cs_status_update=?
				WHERE barcode IN (".$barcode_in.") AND cod_cs_status is null";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $update_date);
		for($i=0; $i<count($barcode_arr); $i++){
			$stmt->bindParam($i+2, $barcode_arr[$i]);
		}
		$stmt->execute();
		return $stmt;		
	}

	function updatestatuscod_received($barcode,  $update_date)
	{
		$barcode = trim($barcode);
		$barcode_arr = explode(",", $barcode);
		$barcode_in = str_repeat("?,", count($barcode_arr)-1 ) ."?";

		$query = "UPDATE " . $this->table_name .
			" SET cod_tb_status='ได้รับ COD จาก Thaipost แล้ว',tb_status_update=?
				WHERE barcode IN (".$barcode_in.") AND cod_tb_status is null";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $update_date);
		for($i=0; $i<count($barcode_arr); $i++){
			$stmt->bindParam($i+2, $barcode_arr[$i]);
		}
		$stmt->execute();
		return $stmt;		
	}

	function updatestatuscod_received2($barcode,  $update_date)
	{
		$barcode = trim($barcode);
		$barcode_arr = explode(",", $barcode);
		$barcode_in = str_repeat("?,", count($barcode_arr)-1 ) ."?";

		$query = "UPDATE " . $this->table_name .
			" SET cod_tb_status='ได้รับ COD จาก Myorder แล้ว',tb_status_update=?
				WHERE barcode IN (".$barcode_in.") AND cod_tb_status is null";

		$stmt = $this->conn->prepare($query);

		//set bind parameter
		$stmt->bindParam(1, $update_date);
		for($i=0; $i<count($barcode_arr); $i++){
			$stmt->bindParam($i+2, $barcode_arr[$i]);
		}
		$stmt->execute();
		return $stmt;		
	}

	// create Order
	function add_address_sender()
	{
		// query to insert record
		$query = "INSERT INTO tb_address_sender
				SET
					
					shipperName=:shipperName,
					shipperAddress=:shipperAddress,
					shipperSubdistrict=:shipperSubdistrict,
					shipperDistrict=:shipperDistrict,
					shipperProvince=:shipperProvince,
					shipperZipcode=:shipperZipcode,
					shipperEmail=:shipperEmail,
					shipperMobile=:shipperMobile,


					customer_code=:customer_code,
					agent_code=:agent_code,

					create_date=:create_date
				";

		// prepare query
		$stmt = $this->conn->prepare($query);



		// sanitize		
		
		$this->shipperName = htmlspecialchars(strip_tags($this->shipperName));
		$this->shipperAddress = htmlspecialchars(strip_tags($this->shipperAddress));
		$this->shipperSubdistrict = htmlspecialchars(strip_tags($this->shipperSubdistrict));
		$this->shipperDistrict = htmlspecialchars(strip_tags($this->shipperDistrict));
		$this->shipperProvince = htmlspecialchars(strip_tags($this->shipperProvince));
		$this->shipperZipcode = htmlspecialchars(strip_tags($this->shipperZipcode));
		$this->shipperEmail = htmlspecialchars(strip_tags($this->shipperEmail));
		$this->shipperMobile = htmlspecialchars(strip_tags($this->shipperMobile));
		
		$this->customer_code = htmlspecialchars(strip_tags($this->customer_code));
		$this->agent_code = htmlspecialchars(strip_tags($this->agent_code));		
		
		$this->create_date = htmlspecialchars(strip_tags($this->create_date));



		// bind values
		

		$stmt->bindParam(":shipperName", $this->shipperName);
		$stmt->bindParam(":shipperAddress", $this->shipperAddress);
		$stmt->bindParam(":shipperSubdistrict", $this->shipperSubdistrict);
		$stmt->bindParam(":shipperDistrict", $this->shipperDistrict);
		$stmt->bindParam(":shipperProvince", $this->shipperProvince);
		$stmt->bindParam(":shipperZipcode", $this->shipperZipcode);
		$stmt->bindParam(":shipperEmail", $this->shipperEmail);
		$stmt->bindParam(":shipperMobile", $this->shipperMobile);
		
		
		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":agent_code", $this->agent_code);
		
		$stmt->bindParam(":create_date", $this->create_date);

		// execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function add_address_sender_select( $customer_code )
	{
		
		// select 
		$query = "SELECT * FROM tb_address_sender WHERE customer_code='$customer_code' ";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function add_address_sender_delete( $id )
	{
		
		// select 
		$query = "DELETE FROM tb_address_sender WHERE address_sender_id ='$id' ";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function add_address_sender_mainhome( $id , $customer_code)
	{
		
		// update 
		$query = "UPDATE tb_address_sender SET main_status='N'  WHERE customer_code ='$customer_code' ;";
		$query .= "UPDATE tb_address_sender SET main_status='Y'  WHERE address_sender_id ='$id' ;";
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	function add_address_sender_selectmain( $customer_code )
	{
		
		// select 
		$query = "SELECT * FROM tb_address_sender WHERE customer_code='$customer_code' AND main_status='Y' ";


		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	public function get_barcode($type,$smartpost_trackingcode){
		if($type == "COD"){
			$query = "SELECT * FROM tb_thaipostbarcodebank_L_EA where status='' AND smartpost_trackingcode='' order by RAND() LIMIT 1";
		}elseif($type == "NON-COD"){
			$query = "SELECT * FROM tb_thaipostbarcodebank_L_EB where status='' AND smartpost_trackingcode='' order by RAND() LIMIT 1";
		}else{
			return false;
		}
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row['barcode']) {
			$barcode = $row['barcode'];
			if ($type == "COD") {
				$update_query = "UPDATE tb_thaipostbarcodebank_L_EA SET status='used', smartpost_trackingcode=:smartpost_trackingcode WHERE barcode=:barcode";
			} elseif ($type == "NON-COD") {
				$update_query = "UPDATE tb_thaipostbarcodebank_L_EB SET status='used', smartpost_trackingcode=:smartpost_trackingcode WHERE barcode=:barcode";
			}
			$update_stmt = $this->conn->prepare($update_query);
			$update_stmt->bindParam(':smartpost_trackingcode', $smartpost_trackingcode);
			$update_stmt->bindParam(':barcode', $barcode);
			if ($update_stmt->execute()) {
				return $barcode;
			}
		}
		return false;
	}

	public function loadhistory_myorder($barcode){
		// query from tb_partner_myorder_webhook_logs
		$query = "SELECT * FROM tb_partner_myorder_webhook_logs WHERE trackingNumber=? ORDER BY received_at ASC";
		
		$stmt = $this->conn->prepare($query);		
		
		$stmt->bindParam(1, $barcode);
		// execute query
		$stmt->execute();
		
		return $stmt;
	}
	
}
