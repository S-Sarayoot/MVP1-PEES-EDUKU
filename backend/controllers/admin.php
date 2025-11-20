<?php
class Admin {
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_admin";
 
	public $admin_code;
	public $username;
	public $password;
	public $admin_name;	
	public $admin_province;	
	public $admin_district;	
	public $admin_address;	
	public $admin_telephone;	
	public $admin_email;				
	public $create_date;	
	public $update_date;

	public $type;
	public $_20g;
	public $_100g;
	public $_250g;
	public $_500g;
	public $_1000g;
	public $_1500g;
	public $_2000g;
	public $_2500g;
	public $_3000g;
	public $_3500g;
	public $_4000g;
	public $_4500g;
	public $_5000g;
	public $_5500g;
	public $_6000g;
	public $_6500g;
	public $_7000g;
	public $_7500g;
	public $_8000g;
	public $_8500g;
	public $_9000g;
	public $_9500g;
	public $_10000g;
	public $_11000g;
	public $_12000g;
	public $_13000g;
	public $_14000g;
	public $_15000g;
	public $_16000g;
	public $_17000g;
	public $_18000g;
	public $_19000g;
	public $_20000g;
	public $_21000g;
	public $_22000g;
	public $_23000g;
	public $_24000g;
	public $_25000g;
	public $_26000g;
	public $_27000g;
	public $_28000g;
	public $_29000g;
	public $_30000g;
	public $_31000g;
	public $_32000g;
	public $_33000g;
	public $_34000g;
	public $_35000g;
	public $_36000g;
	public $_37000g;
	public $_38000g;
	public $_39000g;
	public $_40000g;
	public $_41000g;
	

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// create admin
	function create(){
	 
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
                    admin_code=:admin_code,
                    username=:username,
                    password=:password,
					admin_name=:admin_name,
					admin_province=:admin_province,
					admin_district=:admin_district,
                    admin_address=:admin_address,
                    admin_telephone=:admin_telephone,
                    admin_email=:admin_email,		
					create_date=:create_date";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->admin_code=htmlspecialchars(strip_tags($this->admin_code));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->admin_name=htmlspecialchars(strip_tags($this->admin_name));
		$this->admin_province=htmlspecialchars(strip_tags($this->admin_province));
		$this->admin_district=htmlspecialchars(strip_tags($this->admin_district));
		$this->admin_address=htmlspecialchars(strip_tags($this->admin_address));
		$this->admin_telephone=htmlspecialchars(strip_tags($this->admin_telephone));
		$this->admin_email=htmlspecialchars(strip_tags($this->admin_email));
		$this->create_date=htmlspecialchars(strip_tags($this->create_date));

		// bind values
		$stmt->bindParam(":admin_code", $this->admin_code);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":admin_name", $this->admin_name);
		$stmt->bindParam(":admin_province", $this->admin_province);
		$stmt->bindParam(":admin_district", $this->admin_district);
		$stmt->bindParam(":admin_address", $this->admin_address);
		$stmt->bindParam(":admin_telephone", $this->admin_telephone);
		$stmt->bindParam(":admin_email", $this->admin_email);
		$stmt->bindParam(":create_date", $this->create_date);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	// create admin by admin
	function update($old_admin_code){
	 
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					admin_code=:admin_code,
                    username=:username,
					admin_name=:admin_name,
					admin_province=:admin_province,
					admin_district=:admin_district,
                    admin_address=:admin_address,
                    admin_telephone=:admin_telephone,
                    admin_email=:admin_email,	
                    update_date=:update_date
				WHERE admin_code=:old_admin_code";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->admin_code=htmlspecialchars(strip_tags($this->admin_code));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->admin_name=htmlspecialchars(strip_tags($this->admin_name));
		$this->admin_province=htmlspecialchars(strip_tags($this->admin_province));
		$this->admin_district=htmlspecialchars(strip_tags($this->admin_district));
		$this->admin_address=htmlspecialchars(strip_tags($this->admin_address));
		$this->admin_telephone=htmlspecialchars(strip_tags($this->admin_telephone));
		$this->admin_email=htmlspecialchars(strip_tags($this->admin_email));
		$this->update_date=htmlspecialchars(strip_tags($this->update_date));

		// bind values
		$stmt->bindParam(":old_admin_code", $old_admin_code);
		$stmt->bindParam(":admin_code", $this->admin_code);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":admin_name", $this->admin_name);
		$stmt->bindParam(":admin_province", $this->admin_province);
		$stmt->bindParam(":admin_district", $this->admin_district);
		$stmt->bindParam(":admin_address", $this->admin_address);
		$stmt->bindParam(":admin_telephone", $this->admin_telephone);
		$stmt->bindParam(":admin_email", $this->admin_email);
		$stmt->bindParam(":update_date", $this->update_date);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function delete($admin_code){
	 
		// query to insert record
		$query = "DELETE FROM
					" . $this->table_name . "
                WHERE admin_code=:admin_code";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->admin_code=htmlspecialchars(strip_tags($admin_code));

		// bind values
		$stmt->bindParam(":admin_code", $this->admin_code);
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	
	function userExists(){
	 
		// query to check if email exists
		$query = "SELECT * FROM " . $this->table_name . "
				WHERE username = ?
				LIMIT 0,1";
	 
		// prepare the query
		$stmt = $this->conn->prepare( $query );
	 
		// sanitize
		$this->username=htmlspecialchars(strip_tags($this->username));
	 
		// bind given email value
		$stmt->bindParam(1, $this->username);
	 
		// execute the query
		$stmt->execute();
	 
		// get number of rows
		$num = $stmt->rowCount();
	 
		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){
	 
			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
			// assign values to object properties
			$this->admin_code = $row['admin_code'];
			$this->username = $row['username'];
			$this->password = $row['password'];
			$this->admin_name = $row['admin_name'];
			$this->admin_province = $row['admin_province'];
			$this->admin_district = $row['admin_district'];
			$this->admin_address = $row['admin_address'];
			$this->admin_telephone = $row['admin_telephone'];
			$this->admin_email = $row['admin_email'];
	 
			// return true because email exists in the database
			return true;
		}
	 
		// return false if email does not exist in the database
		return false;
	}

	function changepwd($admin_code,$password){
	 
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password=:password
				WHERE admin_code=:admin_code";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->admin_code=htmlspecialchars(strip_tags($admin_code));
		$this->password=htmlspecialchars(strip_tags($password));
	
		$stmt->bindParam(":admin_code", $this->admin_code);
		$stmt->bindParam(":password", $this->password);
	
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}


	function alladmin()
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  ORDER BY admin_code";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		//$admin_id=htmlspecialchars(strip_tags($admin_id));
		// bind
		//$stmt->bindParam(1, $admin_id);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function getadmin($admin_code)
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE admin_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$admin_code=htmlspecialchars(strip_tags($admin_code));
		// bind
		$stmt->bindParam(1, $admin_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	public function getcost_thaipost($type, $admin_code)
	{
		// select all query
		$query = "SELECT * FROM tb_thaipost_adminprice
				  WHERE type=? AND admin_code=?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$type=htmlspecialchars(strip_tags($type));
		$admin_code=htmlspecialchars(strip_tags($admin_code));
		// bind
		$stmt->bindParam(1, $type);
		$stmt->bindParam(2, $admin_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	public function updatecost_thaipost(){

		// query to insert record
		$query = "UPDATE
			tb_thaipost_adminprice
			SET
				kg_20=:_20g,
				kg_100=:_100g,
				kg_250=:_250g,
				kg_500=:_500g,
				kg_1000=:_1000g,
				kg_1500=:_1500g,
				kg_2000=:_2000g,
				kg_2500=:_2500g,
				kg_3000=:_3000g,
				kg_3500=:_3500g,
				kg_4000=:_4000g,
				kg_4500=:_4500g,
				kg_5000=:_5000g,
				kg_5500=:_5500g,
				kg_6000=:_6000g,
				kg_6500=:_6500g,
				kg_7000=:_7000g,
				kg_7500=:_7500g,
				kg_8000=:_8000g,
				kg_8500=:_8500g,
				kg_9000=:_9000g,
				kg_9500=:_9500g,
				kg_10000=:_10000g,
				kg_11000=:_11000g,
				kg_12000=:_12000g,
				kg_13000=:_13000g,
				kg_14000=:_14000g,
				kg_15000=:_15000g,
				kg_16000=:_16000g,
				kg_17000=:_17000g,
				kg_18000=:_18000g,
				kg_19000=:_19000g,
				kg_20000=:_20000g,
				kg_21000=:_21000g,
				kg_22000=:_22000g,
				kg_23000=:_23000g,
				kg_24000=:_24000g,
				kg_25000=:_25000g,
				kg_26000=:_26000g,
				kg_27000=:_27000g,
				kg_28000=:_28000g,
				kg_29000=:_29000g,
				kg_30000=:_30000g,
				kg_31000=:_31000g,
				kg_32000=:_32000g,
				kg_33000=:_33000g,
				kg_34000=:_34000g,
				kg_35000=:_35000g,
				kg_36000=:_36000g,
				kg_37000=:_37000g,
				kg_38000=:_38000g,
				kg_39000=:_39000g,
				kg_40000=:_40000g,
				kg_41000=:_41000g
			WHERE admin_code=:admin_code AND type=:type";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize

		// bind values
		$stmt->bindParam(":admin_code", $this->admin_code);
		$stmt->bindParam(":type", $this->type);
		$stmt->bindParam(":_20g", $this->_20g);
		$stmt->bindParam(":_100g", $this->_100g);
		$stmt->bindParam(":_250g", $this->_250g);
		$stmt->bindParam(":_500g", $this->_500g);
		$stmt->bindParam(":_1000g", $this->_1000g);
		$stmt->bindParam(":_1500g", $this->_1500g);
		$stmt->bindParam(":_2000g", $this->_2000g);
		$stmt->bindParam(":_2500g", $this->_2500g);
		$stmt->bindParam(":_3000g", $this->_3000g);
		$stmt->bindParam(":_3500g", $this->_3500g);
		$stmt->bindParam(":_4000g", $this->_4000g);
		$stmt->bindParam(":_4500g", $this->_4500g);
		$stmt->bindParam(":_5000g", $this->_5000g);
		$stmt->bindParam(":_5500g", $this->_5500g);
		$stmt->bindParam(":_6000g", $this->_6000g);
		$stmt->bindParam(":_6500g", $this->_6500g);
		$stmt->bindParam(":_7000g", $this->_7000g);
		$stmt->bindParam(":_7500g", $this->_7500g);
		$stmt->bindParam(":_8000g", $this->_8000g);
		$stmt->bindParam(":_8500g", $this->_8500g);
		$stmt->bindParam(":_9000g", $this->_9000g);
		$stmt->bindParam(":_9500g", $this->_9500g);
		$stmt->bindParam(":_10000g", $this->_10000g);
		$stmt->bindParam(":_11000g", $this->_11000g);
		$stmt->bindParam(":_12000g", $this->_12000g);
		$stmt->bindParam(":_13000g", $this->_13000g);
		$stmt->bindParam(":_14000g", $this->_14000g);
		$stmt->bindParam(":_15000g", $this->_15000g);
		$stmt->bindParam(":_16000g", $this->_16000g);
		$stmt->bindParam(":_17000g", $this->_17000g);
		$stmt->bindParam(":_18000g", $this->_18000g);
		$stmt->bindParam(":_19000g", $this->_19000g);
		$stmt->bindParam(":_20000g", $this->_20000g);
		$stmt->bindParam(":_21000g", $this->_21000g);
		$stmt->bindParam(":_22000g", $this->_22000g);
		$stmt->bindParam(":_23000g", $this->_23000g);
		$stmt->bindParam(":_24000g", $this->_24000g);
		$stmt->bindParam(":_25000g", $this->_25000g);
		$stmt->bindParam(":_26000g", $this->_26000g);
		$stmt->bindParam(":_27000g", $this->_27000g);
		$stmt->bindParam(":_28000g", $this->_28000g);
		$stmt->bindParam(":_29000g", $this->_29000g);
		$stmt->bindParam(":_30000g", $this->_30000g);
		$stmt->bindParam(":_31000g", $this->_31000g);
		$stmt->bindParam(":_32000g", $this->_32000g);
		$stmt->bindParam(":_33000g", $this->_33000g);
		$stmt->bindParam(":_34000g", $this->_34000g);
		$stmt->bindParam(":_35000g", $this->_35000g);
		$stmt->bindParam(":_36000g", $this->_36000g);
		$stmt->bindParam(":_37000g", $this->_37000g);
		$stmt->bindParam(":_38000g", $this->_38000g);
		$stmt->bindParam(":_39000g", $this->_39000g);
		$stmt->bindParam(":_40000g", $this->_40000g);
		$stmt->bindParam(":_41000g", $this->_41000g);

		// execute query
		if($stmt->execute()){
			return true;
		}

		return false;

	}	
	
}
?>