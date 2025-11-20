<?php
class calcost
{
	// database connection and table name
	private $conn;
	private $table_name = "tb_thaipostorder";
	private $table_name_dpost = "tb_report_dpost";
	private $table_name_cost = "tb_report_cost";

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

	public $dpost_barcode;
	public  $dpost_receipt_dropoff;
	public  $dpost_dropoff_date;
	public  $dpost_zipcode;
	public  $dpost_weight;
	public  $dpost_productprice;
	public  $dpost_cost;
	public  $dpost_cod;
	public  $dpost_insurancefee;
	public  $dpost_total;
	public $startDate;
	public $endDate;
	public $selectDate;
	public $cost_create_date;
    public $cost_otherprice;
    public $cost_description ;
    public $cost_modified_date;
    public $cost_username ;
	public $cost_status;
	public $cost_id;

	//------Weight Array------
	public $arr =           array('0','20','100','250','500','1000','1500','2000','2500','3000',
	'3500','4000','4500','5000','5500','6000','6500','7000','7500','8000',
	'8500','9000','9500','10000','11000','12000','13000','14000','15000','16000',
	'17000','18000','19000','20000','21000','22000','23000','24000','25000','26000',
	'27000','28000','29000','30000','31000','32000','33000','34000','35000','36000',
	'37000','38000','39000','40000') ;
	public $arr_upper = 	array('20','100','250','500','1000','1500','2000','2500','3000','3500',
	'4000',	'4500','5000','5500','6000','6500','7000','7500','8000','8500',
	'9000','9500','10000','11000','12000','13000','14000','15000','16000','17000',
	'18000','19000','20000','21000','22000','23000','24000','25000','26000','27000',
	'28000','29000','30000','31000','32000','33000','34000','35000','36000','37000'
	,'38000','39000','40000','41000') ; //index 0-53
	public $len_arr = 54; //count arr 54

	// constructor with $db as database connection
	/*
	public function __construct($db)
	{
		$this->conn = $db;
	}*/
	
	

	public function cal_customer_cost($db,$productWeight,$user_code){
		$this->conn = $db;

		$found = false;
		$strSQL = "SELECT * FROM tb_thaidiscountprofile WHERE customer_code = :customer_code ORDER BY weightupper ASC";

		$stmt = $this->conn->prepare($strSQL);
		
		$stmt->bindParam(':customer_code', $user_code);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			if ($found == false) {
				if ((float)$productWeight > (float)$row["weightlower"] && (float)$productWeight <= (float)$row["weightupper"]) {
					$cost = $row["cost"];
					$found = true;
				}
			}
		}
		return $cost;
	}

	public function cal_customer_cod($db, $productPrice, $user_code){
		$this->conn = $db;
		$cost_cod = 0;
		$strSQL = "SELECT * FROM tb_thaidiscountprofilecod WHERE customer_code = :customer_code";

		$stmt = $this->conn->prepare($strSQL);

		$stmt->bindParam(':customer_code', $user_code);

		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (isset($result["cod_l"])) {
			$cod = $result["cod_l"];        
			$cost_cod = number_format(($cod / 100) * $productPrice, 2, '.', '');
		} else {
			$cost_cod = 0;
		}
		return $cost_cod;
	}

	function cal_agent_cost( $productWeight)			//--Agent Price-----
	{	
		$checkweight = '';
		for ($i=0 ; $i < $this->len_arr ; $i++){	
			if( ($productWeight > $this->arr[$i])  && ($productWeight <= $this->arr_upper[$i]) ){
				$w = (string)$this->arr_upper[$i];
				$checkweight = 'agent_kg_' .$w ;
				         //--return params agent_kg_weight                                
			}
		}
		if($productWeight <= 0 || $checkweight == ''){	//--error weight 0--
			$checkweight = 'agent_kg_100' ;
		}
		return $checkweight;
	}
		
	function cal_cod($productPrice,$cod_rate)			//--Agent,Admin COD-----
	{					
		$cal_cod = 0;
		if($productPrice > 0){
			$cal_cod = ($productPrice * ($cod_rate/100));
		}		   
		return $cal_cod;
	}
		

	function cal_admin_cost($productWeight)			//--Admin Cost-----
	{		
		$checkweight  = '';   
		for ($i=0 ; $i < $this->len_arr ; $i++){	
			if( ($productWeight > $this->arr[$i])  && ($productWeight <= $this->arr_upper[$i]) ){         
				$w = (string)$this->arr_upper[$i];
				$checkweight = 'kg_' .$w ;				                   
			}
		}   
		if($productWeight == 0){	//--error weight 0--
			$checkweight = 'kg_20' ;
		}
		return $checkweight;		//--return params kg_weight      
	}

	
	function cal_extra_fee($productWeight,$cusZipcode)			//--Extra Fee-----
	{
		//------------พื้นที่ห่างไกล----------------**ยกเลิกพิกัดน้ำหนัก
		$extra_fee = 0;
		//if($productWeight <= 1000){
			if( $cusZipcode ==  '20120' 
				|| $cusZipcode == '23170'
				|| $cusZipcode == '81150'
				|| $cusZipcode == '81210'
				|| $cusZipcode == '82160'
				|| $cusZipcode == '83000'
				|| $cusZipcode == '83100'
				|| $cusZipcode == '83110'
				|| $cusZipcode == '83120'
				|| $cusZipcode == '83130'
				|| $cusZipcode == '83150'
				|| $cusZipcode == '84140'
				|| $cusZipcode == '84280'
				|| $cusZipcode == '84310'
				|| $cusZipcode == '84320'
				|| $cusZipcode == '84330'
				|| $cusZipcode == '84360' 

										|| $cusZipcode == '57170'
										|| $cusZipcode == '57180'
										|| $cusZipcode == '57260'
										|| $cusZipcode == '58000'
										|| $cusZipcode == '58110'
										|| $cusZipcode == '58120'
										|| $cusZipcode == '58130'
										|| $cusZipcode == '58140'
										|| $cusZipcode == '58150'
										|| $cusZipcode == '63150'
										|| $cusZipcode == '63170'
										|| $cusZipcode == '71180'
										|| $cusZipcode == '71240'
										|| $cusZipcode == '94000'
										|| $cusZipcode == '94110'
										|| $cusZipcode == '94120'
										|| $cusZipcode == '94130'
										|| $cusZipcode == '94140'
										|| $cusZipcode == '94150'
										|| $cusZipcode == '94160'
										|| $cusZipcode == '94170'
										|| $cusZipcode == '94180'
										|| $cusZipcode == '94190'
										|| $cusZipcode == '94220'
										|| $cusZipcode == '94230'
										|| $cusZipcode == '95000'
										|| $cusZipcode == '95110'
										|| $cusZipcode == '95120'
										|| $cusZipcode == '95130'
										|| $cusZipcode == '95140'
										|| $cusZipcode == '95150'
										|| $cusZipcode == '95160'
										|| $cusZipcode == '95170'
										|| $cusZipcode == '96000'
										|| $cusZipcode == '96110'
										|| $cusZipcode == '96120'
										|| $cusZipcode == '96130'
										|| $cusZipcode == '96140'
										|| $cusZipcode == '96150'
										|| $cusZipcode == '96160'
										|| $cusZipcode == '96170'
										|| $cusZipcode == '96180'
										|| $cusZipcode == '96190'
										|| $cusZipcode == '96210'
										|| $cusZipcode == '96220'

										
										|| $cusZipcode == '83001'

										|| $cusZipcode == '94001'
										|| $cusZipcode == '95001'
				
				
				)
			{
				$extra_fee = $extra_fee + 15;                    
			}
		//}
		return $extra_fee;
	}

	function cal_extra_fee_old($productWeight,$cusZipcode)			//--Extra Fee-----
	{
		//------------พื้นที่ห่างไกล----------------**มีพิกัดน้ำหนัก
		$extra_fee = 0;
		//if($productWeight <= 1000){
			if( $cusZipcode ==  '20120' 
				|| $cusZipcode == '23170'
				|| $cusZipcode == '81150'
				|| $cusZipcode == '81210'
				|| $cusZipcode == '82160'
				|| $cusZipcode == '83000'
				|| $cusZipcode == '83100'
				|| $cusZipcode == '83110'
				|| $cusZipcode == '83120'
				|| $cusZipcode == '83130'
				|| $cusZipcode == '83150'
				|| $cusZipcode == '84140'
				|| $cusZipcode == '84280'
				|| $cusZipcode == '84310'
				|| $cusZipcode == '84320'
				|| $cusZipcode == '84330'
				|| $cusZipcode == '84360' 

				
				
				)
			{
				$extra_fee = $extra_fee + 15;                    
			}
		//}
		return $extra_fee;
	}

	function cal_extra_fee_with_weight($productWeight,$cusZipcode)			//--Extra Fee-----
	{
		//------------พื้นที่ห่างไกล----------------**ยกเลิกพิกัดน้ำหนัก
		$extra_fee = 0;
		if($productWeight <= 1000){
			if( $cusZipcode ==  '20120' 
				|| $cusZipcode == '23170'
				|| $cusZipcode == '81150'
				|| $cusZipcode == '81210'
				|| $cusZipcode == '82160'
				|| $cusZipcode == '83000'
				|| $cusZipcode == '83100'
				|| $cusZipcode == '83110'
				|| $cusZipcode == '83120'
				|| $cusZipcode == '83130'
				|| $cusZipcode == '83150'
				|| $cusZipcode == '84140'
				|| $cusZipcode == '84280'
				|| $cusZipcode == '84310'
				|| $cusZipcode == '84320'
				|| $cusZipcode == '84330'
				|| $cusZipcode == '84360' )
			{
				$extra_fee = $extra_fee + 15;                    
			}
		}
		return $extra_fee;
	}
		
	function cal_insurance($insuranceRatePrice)			
	{
		//-------ประกัน-------
		$admin_insurance_cost = 0;
		if($insuranceRatePrice > 0){
			$admin_insurance_cost = (ceil($insuranceRatePrice / 5000)) * 10 + 25;                
		}		
		return $admin_insurance_cost;			
	}

	function cal_insurance_admin($insuranceRatePrice, $service_type)			
	{
		//-------ต้นทุนประกัน-------
		$admin_insurance_cost = 0;
		if($insuranceRatePrice > 0){
			$admin_insurance_cost = (ceil($insuranceRatePrice / 5000)) * 10 + 20;    
				
			if($service_type == "M"){
				$admin_insurance_cost = $admin_insurance_cost + 1; //เพิ่มค่าบริการประกันพัสดุ MyOrder
			}            
		}	
		return $admin_insurance_cost;			
	}


}
