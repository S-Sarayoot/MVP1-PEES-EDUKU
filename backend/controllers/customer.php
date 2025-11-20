<?php
class Customer{
 
    // database connection and table name
    private $conn;
    private $table_name = "tb_customer";
 
	public $customer_code;
	public $username;
	public $password;
	public $customer_type;	
	public $customer_name;	
	public $customer_province;	
	public $customer_district;	
	public $customer_address;	
	public $customer_telephone;	
	public $customer_email;	
	public $customer_contactname;	
	public $agent_code;		
	public $company_house_file;	
	public $idcard_file;	
	public $book_bank_file;	
	public $status;
	public $create_date;	
	public $update_date;
	public $dropoff;
	public $services;
	public $type;
	public $amount;
	public $category;
	public $category_pay;
	public $subcustomer_code;
	public $co_agent_code;
	public $bookbank_id;
	public $bookbank_name;
	public $bookbank_cusname;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// create customer
	function create(){
	 
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
                    customer_code=:customer_code,
                    username=:username,
					password=:password,
					customer_type=:customer_type,
					customer_name=:customer_name,
					customer_province=:customer_province,
					customer_district=:customer_district,
                    customer_address=:customer_address,
                    customer_telephone=:customer_telephone,
                    customer_email=:customer_email,
                    customer_contactname=:customer_contactname,	
					company_house_file=:company_house_file,	
					idcard_file=:idcard_file,
					book_bank_file=:book_bank_file,
                    agent_code=:agent_code,	
                    dropoff=:dropoff,
					services=:services,
					status=:status,
					create_date=:create_date,
					co_agent_code=:co_agent_code,
					type='N' ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($this->customer_code));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->customer_type=htmlspecialchars(strip_tags($this->customer_type));
		$this->customer_name=htmlspecialchars(strip_tags($this->customer_name));
		$this->customer_province=htmlspecialchars(strip_tags($this->customer_province));
		$this->customer_district=htmlspecialchars(strip_tags($this->customer_district));
		$this->customer_address=htmlspecialchars(strip_tags($this->customer_address));
		$this->customer_telephone=htmlspecialchars(strip_tags($this->customer_telephone));
		$this->customer_email=htmlspecialchars(strip_tags($this->customer_email));
		$this->customer_contactname=htmlspecialchars(strip_tags($this->customer_contactname));
		
		if(!(empty($this->company_house_file)))
			$this->company_house_file=htmlspecialchars(strip_tags($this->company_house_file));
		else
			$this->company_house_file = null;

		if(!(empty($this->idcard_file)))
			$this->idcard_file=htmlspecialchars(strip_tags($this->idcard_file));
		else
			$this->idcard_file = null;

		if(!(empty($this->book_bank_file)))
			$this->book_bank_file=htmlspecialchars(strip_tags($this->book_bank_file));
		else
			$this->book_bank_file = null;

		$this->status==htmlspecialchars(strip_tags($this->status));
        $this->agent_code=htmlspecialchars(strip_tags($this->agent_code));
		$this->dropoff=htmlspecialchars(strip_tags($this->dropoff));
		$this->services=htmlspecialchars(strip_tags($this->services));
		$this->create_date=htmlspecialchars(strip_tags($this->create_date));
		$this->co_agent_code=htmlspecialchars(strip_tags($this->co_agent_code));

		// bind values
		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":customer_type", $this->customer_type);
		$stmt->bindParam(":customer_name", $this->customer_name);
		$stmt->bindParam(":customer_province", $this->customer_province);
		$stmt->bindParam(":customer_district", $this->customer_district);
		$stmt->bindParam(":customer_address", $this->customer_address);
		$stmt->bindParam(":customer_telephone", $this->customer_telephone);
		$stmt->bindParam(":customer_email", $this->customer_email);
		$stmt->bindParam(":customer_contactname", $this->customer_contactname);
		$stmt->bindParam(":company_house_file", $this->company_house_file);
		$stmt->bindParam(":idcard_file", $this->idcard_file);
		$stmt->bindParam(":book_bank_file", $this->book_bank_file);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":agent_code", $this->agent_code);
		$stmt->bindParam(":dropoff", $this->dropoff);
		$stmt->bindParam(":services", $this->services);
		$stmt->bindParam(":create_date", $this->create_date);
		$stmt->bindParam(":co_agent_code", $this->co_agent_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function create_sub(){
	 
		// query to insert record
		$query = "INSERT INTO tb_subcustomer
				SET
				
					subcustomer_code=:subcustomer_code,
                    customer_code=:customer_code,
                    username=:username,
					password=:password,
					customer_type=:customer_type,
					customer_name=:customer_name,
					customer_province=:customer_province,
					customer_district=:customer_district,
                    customer_address=:customer_address,
                    customer_telephone=:customer_telephone,
                    customer_email=:customer_email,
                    customer_contactname=:customer_contactname,	
					
                    agent_code=:agent_code,	
                    dropoff=:dropoff,
					services=:services,
					status=:status,
					create_date=:create_date,
					type='SUB' ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->subcustomer_code=htmlspecialchars(strip_tags($this->subcustomer_code));
		$this->customer_code=htmlspecialchars(strip_tags($this->customer_code));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->customer_type=htmlspecialchars(strip_tags($this->customer_type));
		$this->customer_name=htmlspecialchars(strip_tags($this->customer_name));
		$this->customer_province=htmlspecialchars(strip_tags($this->customer_province));
		$this->customer_district=htmlspecialchars(strip_tags($this->customer_district));
		$this->customer_address=htmlspecialchars(strip_tags($this->customer_address));
		$this->customer_telephone=htmlspecialchars(strip_tags($this->customer_telephone));
		$this->customer_email=htmlspecialchars(strip_tags($this->customer_email));
		$this->customer_contactname=htmlspecialchars(strip_tags($this->customer_contactname));		
		$this->status==htmlspecialchars(strip_tags($this->status));
        $this->agent_code=htmlspecialchars(strip_tags($this->agent_code));
		$this->dropoff=htmlspecialchars(strip_tags($this->dropoff));
		$this->services=htmlspecialchars(strip_tags($this->services));
		$this->create_date=htmlspecialchars(strip_tags($this->create_date));

		// bind values
		$stmt->bindParam(":subcustomer_code", $this->subcustomer_code);
		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":customer_type", $this->customer_type);
		$stmt->bindParam(":customer_name", $this->customer_name);
		$stmt->bindParam(":customer_province", $this->customer_province);
		$stmt->bindParam(":customer_district", $this->customer_district);
		$stmt->bindParam(":customer_address", $this->customer_address);
		$stmt->bindParam(":customer_telephone", $this->customer_telephone);
		$stmt->bindParam(":customer_email", $this->customer_email);
		$stmt->bindParam(":customer_contactname", $this->customer_contactname);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":agent_code", $this->agent_code);
		$stmt->bindParam(":dropoff", $this->dropoff);
		$stmt->bindParam(":services", $this->services);
		$stmt->bindParam(":create_date", $this->create_date);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}


	// create customer by agent
	function update($customer_code){
	 
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					customer_code=:customer_code,
                    username=:username,
					customer_type=:customer_type,
					customer_name=:customer_name,
					customer_province=:customer_province,
					customer_district=:customer_district,
                    customer_address=:customer_address,
                    customer_telephone=:customer_telephone,
                    customer_email=:customer_email,
                    dropoff=:dropoff,
					services=:services,
					type=:type,
					category=:category,
					category_pay=:category_pay,
                    customer_contactname=:customer_contactname,
                    bookbank_id=:bookbank_id,
                    bookbank_name=:bookbank_name,
                    bookbank_cusname=:bookbank_cusname,
					
		";	
                    

		if(!(empty($this->company_house_file)))
			$query .= "company_house_file=:company_house_file,";

		if(!(empty($this->idcard_file)))
			$query .= "idcard_file=:idcard_file,";

		if(!(empty($this->book_bank_file)))
			$query .= "book_bank_file=:book_bank_file,";

		$query .= "update_date=:update_date
					WHERE customer_code=:old_customer_code";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($this->customer_code));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->customer_type=htmlspecialchars(strip_tags($this->customer_type));
		$this->customer_name=htmlspecialchars(strip_tags($this->customer_name));
		$this->customer_province=htmlspecialchars(strip_tags($this->customer_province));
		$this->customer_district=htmlspecialchars(strip_tags($this->customer_district));
		$this->customer_address=htmlspecialchars(strip_tags($this->customer_address));
		$this->customer_telephone=htmlspecialchars(strip_tags($this->customer_telephone));
		$this->customer_email=htmlspecialchars(strip_tags($this->customer_email));
		$this->customer_contactname=htmlspecialchars(strip_tags($this->customer_contactname));
		$this->dropoff=htmlspecialchars(strip_tags($this->dropoff));
		$this->services=htmlspecialchars(strip_tags($this->services));
		$this->type=htmlspecialchars(strip_tags($this->type));
		$this->category=htmlspecialchars(strip_tags($this->category));
		$this->category_pay=htmlspecialchars(strip_tags($this->category_pay));

		$this->bookbank_id=htmlspecialchars(strip_tags($this->bookbank_id));
		$this->bookbank_name=htmlspecialchars(strip_tags($this->bookbank_name));
		$this->bookbank_cusname=htmlspecialchars(strip_tags($this->bookbank_cusname));


		if(!(empty($this->company_house_file)))
			$this->company_house_file=htmlspecialchars(strip_tags($this->company_house_file));

		if(!(empty($this->idcard_file)))
			$this->idcard_file=htmlspecialchars(strip_tags($this->idcard_file));

		if(!(empty($this->book_bank_file)))
			$this->book_bank_file=htmlspecialchars(strip_tags($this->book_bank_file));

		$this->update_date=htmlspecialchars(strip_tags($this->update_date));

		// bind values
		$stmt->bindParam(":old_customer_code", $customer_code);
		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":customer_type", $this->customer_type);
		$stmt->bindParam(":customer_name", $this->customer_name);
		$stmt->bindParam(":customer_province", $this->customer_province);
		$stmt->bindParam(":customer_district", $this->customer_district);
		$stmt->bindParam(":customer_address", $this->customer_address);
		$stmt->bindParam(":customer_telephone", $this->customer_telephone);
		$stmt->bindParam(":customer_email", $this->customer_email);
		$stmt->bindParam(":customer_contactname", $this->customer_contactname);
		$stmt->bindParam(":dropoff", $this->dropoff);
		$stmt->bindParam(":services", $this->services);
		$stmt->bindParam(":type", $this->type);
		$stmt->bindParam(":category", $this->category);
		$stmt->bindParam(":category_pay", $this->category_pay);
		$stmt->bindParam(":bookbank_id", $this->bookbank_id);
		$stmt->bindParam(":bookbank_name", $this->bookbank_name);
		$stmt->bindParam(":bookbank_cusname", $this->bookbank_cusname);

		if(!(empty($this->company_house_file)))
			$stmt->bindParam(":company_house_file", $this->company_house_file);

		if(!(empty($this->idcard_file)))
			$stmt->bindParam(":idcard_file", $this->idcard_file);

		if(!(empty($this->book_bank_file)))
			$stmt->bindParam(":book_bank_file", $this->book_bank_file);

		$stmt->bindParam(":update_date", $this->update_date);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function createprice($customer_code,
							$in_out,
							$_1kg,
							$_2kg,
							$_3kg,
							$_4kg,
							$_5kg,
							$_6kg,
							$_7kg,
							$_8kg,
							$_9kg,
							$_10kg,
							$_11kg,
							$_12kg,
							$_13kg,
							$_14kg,
							$_15kg,
							$_16kg,
							$_17kg,
							$_18kg,
							$_19kg,
							$_20kg,
							$_more20kg,
							$agent_code
							){
	 
		// query to insert record
		$query = "INSERT INTO
					jt_customer_price
				SET
						customer_code=:customer_code,
						in_out=:in_out,
						kg_1=:_1kg,
						kg_2=:_2kg,
						kg_3=:_3kg,
						kg_4=:_4kg,
						kg_5=:_5kg,
						kg_6=:_6kg,
						kg_7=:_7kg,
						kg_8=:_8kg,
						kg_9=:_9kg,
						kg_10=:_10kg,
						kg_11=:_11kg,
						kg_12=:_12kg,
						kg_13=:_13kg,
						kg_14=:_14kg,
						kg_15=:_15kg,
						kg_16=:_16kg,
						kg_17=:_17kg,
						kg_18=:_18kg,
						kg_19=:_19kg,
						kg_20=:_20kg,
						kg_more20=:_more20kg,
						agent_code=:agent_code";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":in_out", $in_out);
		$stmt->bindParam(":_1kg", $_1kg);
		$stmt->bindParam(":_2kg", $_2kg);
		$stmt->bindParam(":_3kg", $_3kg);
		$stmt->bindParam(":_4kg", $_4kg);
		$stmt->bindParam(":_5kg", $_5kg);
		$stmt->bindParam(":_6kg", $_6kg);
		$stmt->bindParam(":_7kg", $_7kg);
		$stmt->bindParam(":_8kg", $_8kg);
		$stmt->bindParam(":_9kg", $_9kg);
		$stmt->bindParam(":_10kg", $_10kg);
		$stmt->bindParam(":_11kg", $_11kg);
		$stmt->bindParam(":_12kg", $_12kg);
		$stmt->bindParam(":_13kg", $_13kg);
		$stmt->bindParam(":_14kg", $_14kg);
		$stmt->bindParam(":_15kg", $_15kg);
		$stmt->bindParam(":_16kg", $_16kg);
		$stmt->bindParam(":_17kg", $_17kg);
		$stmt->bindParam(":_18kg", $_18kg);
		$stmt->bindParam(":_19kg", $_19kg);
		$stmt->bindParam(":_20kg", $_20kg);
		$stmt->bindParam(":_more20kg", $_more20kg);
		$stmt->bindParam(":agent_code", $agent_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
	function createcod($customer_code,
							$cost,
							$price,
							$agent_code
							){
	 
		// query to insert record
		$query = "INSERT INTO
					jt_customer_cod
				SET
						customer_code=:customer_code,
						cost=:cost,
						price=:price,
						agent_code=:agent_code";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":cost", $cost);
		$stmt->bindParam(":price", $price);
		$stmt->bindParam(":agent_code", $agent_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	// create customer by agent
	function updateprice($customer_code,
							$in_out,
							$_1kg,
							$_2kg,
							$_3kg,
							$_4kg,
							$_5kg,
							$_6kg,
							$_7kg,
							$_8kg,
							$_9kg,
							$_10kg,
							$_11kg,
							$_12kg,
							$_13kg,
							$_14kg,
							$_15kg,
							$_16kg,
							$_17kg,
							$_18kg,
							$_19kg,
							$_20kg,
							$_more20kg,
							$agent_code
							
							){
	 
		// query to insert record
		$query = "UPDATE
					jt_customer_price
				SET
						kg_1=:_1kg,
						kg_2=:_2kg,
						kg_3=:_3kg,
						kg_4=:_4kg,
						kg_5=:_5kg,
						kg_6=:_6kg,
						kg_7=:_7kg,
						kg_8=:_8kg,
						kg_9=:_9kg,
						kg_10=:_10kg,
						kg_11=:_11kg,
						kg_12=:_12kg,
						kg_13=:_13kg,
						kg_14=:_14kg,
						kg_15=:_15kg,
						kg_16=:_16kg,
						kg_17=:_17kg,
						kg_18=:_18kg,
						kg_19=:_19kg,
						kg_20=:_20kg,
						kg_more20=:_more20kg,
						agent_code=:agent_code
					WHERE customer_code=:customer_code
					AND in_out=:in_out";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":in_out", $in_out);
		$stmt->bindParam(":_1kg", $_1kg);
		$stmt->bindParam(":_2kg", $_2kg);
		$stmt->bindParam(":_3kg", $_3kg);
		$stmt->bindParam(":_4kg", $_4kg);
		$stmt->bindParam(":_5kg", $_5kg);
		$stmt->bindParam(":_6kg", $_6kg);
		$stmt->bindParam(":_7kg", $_7kg);
		$stmt->bindParam(":_8kg", $_8kg);
		$stmt->bindParam(":_9kg", $_9kg);
		$stmt->bindParam(":_10kg", $_10kg);
		$stmt->bindParam(":_11kg", $_11kg);
		$stmt->bindParam(":_12kg", $_12kg);
		$stmt->bindParam(":_13kg", $_13kg);
		$stmt->bindParam(":_14kg", $_14kg);
		$stmt->bindParam(":_15kg", $_15kg);
		$stmt->bindParam(":_16kg", $_16kg);
		$stmt->bindParam(":_17kg", $_17kg);
		$stmt->bindParam(":_18kg", $_18kg);
		$stmt->bindParam(":_19kg", $_19kg);
		$stmt->bindParam(":_20kg", $_20kg);
		$stmt->bindParam(":_more20kg", $_more20kg);
		$stmt->bindParam(":agent_code", $agent_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	function updatecod($customer_code,
							$price,
							$agent_code
							){
	 
		// query to insert record
		$query = "UPDATE
					jt_customer_cod
				SET
					price=:price,
					agent_code=:agent_code
				WHERE customer_code=:customer_code";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":price", $price);
		$stmt->bindParam(":agent_code", $agent_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	// 
	function changepwd($customer_code,$password){
		
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password=:password
				WHERE customer_code=:customer_code";
	
		// prepare query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($customer_code));
		$this->password=htmlspecialchars(strip_tags($password));

		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":password", $this->password);

		// execute query
		if($stmt->execute()){
			return true;
		}
	
		return false;
		
	}

	function approve($customer_code){
		
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					status='approved'
				WHERE customer_code=:customer_code";
	
		// prepare query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($customer_code));

		$stmt->bindParam(":customer_code", $this->customer_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	
		return false;
		
	}

	function unapprove($customer_code){
		
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					status='register'
				WHERE customer_code=:customer_code";
	
		// prepare query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($customer_code));

		$stmt->bindParam(":customer_code", $this->customer_code);

		// execute query
		if($stmt->execute()){
			return true;
		}
	
		return false;
		
	}

	function delete($customer_code){
	 
		// query to insert record
		$query = "DELETE FROM
					" . $this->table_name . "
                WHERE customer_code=:customer_code";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($customer_code));

		// bind values
		$stmt->bindParam(":customer_code", $this->customer_code);
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function delete_sub($subcustomer_code){
	 
		// query to insert record
		$query = "DELETE FROM
					tb_subcustomer
                WHERE subcustomer_code=:subcustomer_code";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->subcustomer_code=htmlspecialchars(strip_tags($subcustomer_code));

		// bind values
		$stmt->bindParam(":subcustomer_code", $this->subcustomer_code);
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	function userExists(){
	 
		// query to check if email exists
		$query = "SELECT * FROM " . $this->table_name . "
				WHERE username = ? AND status='approved'
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
			$this->customer_code = $row['customer_code'];
			$this->username = $row['username'];
			$this->password = $row['password'];
			$this->customer_type = $row['customer_type'];
			$this->customer_name = $row['customer_name'];
			$this->customer_province = $row['customer_province'];
			$this->customer_district = $row['customer_district'];
			$this->customer_address = $row['customer_address'];
			$this->customer_telephone = $row['customer_telephone'];
			$this->customer_email = $row['customer_email'];
			$this->customer_contactname = $row['customer_contactname'];
			$this->agent_code = $row['agent_code'];
			$this->dropoff = $row['dropoff'];
			$this->services = $row['services'];
			$this->type = $row['type'];
			$this->amount = $row['amount'];
			$this->category = $row['category'];
			$this->category_pay = $row['category_pay'];
			$this->co_agent_code = $row['co_agent_code'];
	 
			// return true because email exists in the database
			return true;
		}
	 
		// return false if email does not exist in the database
		return false;
	}

	function userExistsbycode(){
	 
		// query to check if email exists
		$query = "SELECT * FROM " . $this->table_name . "
				WHERE customer_code = ? AND status='approved'
				LIMIT 0,1";
	 
		// prepare the query
		$stmt = $this->conn->prepare( $query );
	 
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($this->customer_code));
	 
		// bind given email value
		$stmt->bindParam(1, $this->customer_code);
	 
		// execute the query
		$stmt->execute();
	 
		// get number of rows
		$num = $stmt->rowCount();
	 
		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){
	 
			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
			// assign values to object properties
			$this->customer_code = $row['customer_code'];
			$this->username = $row['username'];
			$this->password = $row['password'];
			$this->customer_type = $row['customer_type'];
			$this->customer_name = $row['customer_name'];
			$this->customer_province = $row['customer_province'];
			$this->customer_district = $row['customer_district'];
			$this->customer_address = $row['customer_address'];
			$this->customer_telephone = $row['customer_telephone'];
			$this->customer_email = $row['customer_email'];
			$this->customer_contactname = $row['customer_contactname'];
			$this->agent_code = $row['agent_code'];
			$this->dropoff = $row['dropoff'];
			$this->services = $row['services'];
			$this->type = $row['type'];
			$this->amount = $row['amount'];
			$this->category = $row['category'];
			$this->category_pay = $row['category_pay'];
			$this->co_agent_code = $row['co_agent_code'];
	 
			// return true because email exists in the database
			return true;
		}
	 
		// return false if email does not exist in the database
		return false;
	}

	function subuserExists(){
	 
		// query to check if email exists
		$query = "SELECT * FROM tb_subcustomer
				WHERE username = ? AND status='approved'
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
			$this->customer_code = $row['customer_code'];
			$this->username = $row['username'];
			$this->password = $row['password'];
			$this->customer_name = $row['customer_name'];
			$this->subcustomer_code = $row['subcustomer_code'];
			$this->type = $row['type'];
	 
	 
			// return true because email exists in the database
			return true;
		}
	 
		// return false if email does not exist in the database
		return false;
	}

	function resetpassword(){
	 
		// query to insert record
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password=:password
				WHERE customer_code=:customer_code";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->customer_code=htmlspecialchars(strip_tags($this->customer_code));
		//$this->password=htmlspecialchars(strip_tags($this->password));

		// bind values
		$password = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(":customer_code", $this->customer_code);
		$stmt->bindParam(":password", $password);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function allcustomerforadmin()
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  ORDER BY status desc,agent_code,customer_code";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		//$agent_code=htmlspecialchars(strip_tags($agent_code));
		// bind
		//$stmt->bindParam(1, $agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function allcustomer($agent_code)
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  ";

		if(!empty($agent_code)){
			$query .= "WHERE agent_code = ?" ;
		}
		
		$query .= "ORDER BY customer_code";
		
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($agent_code));
		// bind
		if(!empty($agent_code)){
			$stmt->bindParam(1, $agent_code);
		}
		

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function allcustomer_co_agent($co_agent_code)
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE co_agent_code = ?
				  ORDER BY customer_code";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($co_agent_code));
		// bind
		$stmt->bindParam(1, $co_agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function allsubcustomer($customer_code)
	{

		// select all query
		$query = "SELECT * FROM tb_subcustomer
				  WHERE customer_code = ? 
				  ORDER BY subcustomer_code";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}


	function getcustomer($customer_code)
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE customer_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	function getcustomerprice($customer_code)
	{

		// select all query
		$query = "SELECT * FROM jt_customer_price
				  WHERE customer_code = ? order by in_out";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	function getcustomercod($customer_code)
	{

		// select all query
		$query = "SELECT * FROM jt_customer_cod
				  WHERE customer_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	function getagentprice($agent_code)
	{

		// select all query
		$query = "SELECT * FROM jt_agent_price
				  WHERE agent_code = ? and type='price' order by in_out";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($agent_code));
		// bind
		$stmt->bindParam(1, $agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	function getagentcod($agent_code)
	{

		// select all query
		$query = "SELECT * FROM jt_agent_cod
				  WHERE agent_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($agent_code));
		// bind
		$stmt->bindParam(1, $agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	//show
	function showbadge($agent_code)
	{

		// select all query
		$query = "SELECT * FROM " . $this->table_name . "
				  WHERE agent_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($agent_code));
		// bind
		$stmt->bindParam(1, $agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function getMaxID($agent_code)
	{

		// select all query
		$query = "SELECT customer_code FROM " . $this->table_name . "
				  WHERE agent_code = ?
				  ORDER BY customer_code DESC 
				  LIMIT 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($agent_code));
		// bind
		$stmt->bindParam(1, $agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	//CO-agent
	function getMaxID_co_agent($co_agent_code)
	{

		// select all query
		$query = "SELECT customer_code FROM " . $this->table_name . "
				  WHERE co_agent_code = ?
				  ORDER BY customer_code DESC 
				  LIMIT 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$agent_code=htmlspecialchars(strip_tags($co_agent_code));
		// bind
		$stmt->bindParam(1, $co_agent_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	//---SUB CUSTOMER------
	function getMaxID_subcustomer($customer_code)
	{

		// select all query
		$query = "SELECT subcustomer_code FROM tb_subcustomer
				  WHERE customer_code = ?
				  ORDER BY subcustomer_code DESC 
				  LIMIT 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}


	//GET THAIPOST PRICE FOR AGENTPAGE----------------------------	
	function getcustomerprice_thaipost($customer_code)
	{

		// select all query
		$query = "SELECT * FROM  tb_thaidiscountprofile 
				  WHERE customer_code = ?  ";




		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));		
		// bind
		$stmt->bindParam(1, $customer_code);
		// execute query
		$stmt->execute();

		return $stmt;
	}


	function getcustomercod_thaipost($customer_code)
	{

		// select all query
		$query = "SELECT * FROM tb_thaidiscountprofilecod 
				  WHERE customer_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}
	// thaipost price
	function updateprice_thaipost($customer_code,
							$price_cost,
							$agent_code,
							$weight_l							
							){
			// query to insert record		
			$query = "UPDATE tb_thaidiscountprofile	
							SET
							cost=:price_cost,
							agent_code=:agent_code
						WHERE customer_code=:customer_code AND weightlower=:weight_l
						";
			
			// prepare query
			$stmt = $this->conn->prepare($query);
			// bind values
			$stmt->bindParam(":customer_code", $customer_code);		
			$stmt->bindParam(":price_cost", $price_cost);
			$stmt->bindParam(":weight_l", $weight_l);
			$stmt->bindParam(":agent_code", $agent_code);

			// execute query
			if($stmt->execute()){
				return true;
			}
		
			return false;
	}


	function updatecod_thaipost($customer_code,
							$price_l
							){
	 
		// query to insert record
		$query = "UPDATE
					tb_thaidiscountprofilecod 
				SET
					cod_l=:price_l
				WHERE customer_code=:customer_code";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		
		$stmt->bindParam(":price_l", $price_l);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function createprice_thaipost($customer_code,		
							$price_cost,				
							$agent_code,
							$weight_l
							){
			$query = "INSERT INTO
				tb_thaidiscountprofile
				SET
				agent_code=:agent_code,
				customer_code=:customer_code,
				weightlower=:weight_l
				";
				
				if($weight_l >= 10000){
					$query .=",weightupper=:weight_l+1000 ,cost=:price_cost" ;
				}
				else if($weight_l >= 500){
					$query .=",weightupper=:weight_l+500 ,cost=:price_cost" ;
				}
				else if ($weight_l == 250){
					$query .=",weightupper=500 ,cost=:price_cost" ;
				}
				else if ($weight_l == 100){
					$query .=",weightupper=250 ,cost=:price_cost" ;
				}
				else if ($weight_l == 20){
					$query .=",weightupper=100 ,cost=:price_cost" ;
				}
				else if ($weight_l == 0){
					$query .=",weightupper=20 ,cost=:price_cost" ;
				}
				
						
						
						
			// prepare query
			$stmt = $this->conn->prepare($query);

			// bind values
			$stmt->bindParam(":customer_code", $customer_code);	
			$stmt->bindParam(":price_cost", $price_cost);		
			$stmt->bindParam(":agent_code", $agent_code);		
			$stmt->bindParam(":weight_l", $weight_l);

			// execute query
			if($stmt->execute()){
				return true;
			}
		
			return false;
		
		
	}

	
	function createprice_thaipost_co_agent($customer_code,		
							$price_cost,				
							$agent_code,				
							$co_agent_code,
							$weight_l
							){
			$query = "INSERT INTO
				tb_thaidiscountprofile
				SET
				co_agent_code=:co_agent_code,
				agent_code=:agent_code,
				customer_code=:customer_code,
				weightlower=:weight_l
				";
				
				if($weight_l >= 10000){
					$query .=",weightupper=:weight_l+1000 ,cost=:price_cost" ;
				}
				else if($weight_l >= 500){
					$query .=",weightupper=:weight_l+500 ,cost=:price_cost" ;
				}
				else if ($weight_l == 250){
					$query .=",weightupper=500 ,cost=:price_cost" ;
				}
				else if ($weight_l == 100){
					$query .=",weightupper=250 ,cost=:price_cost" ;
				}
				else if ($weight_l == 20){
					$query .=",weightupper=100 ,cost=:price_cost" ;
				}
				else if ($weight_l == 0){
					$query .=",weightupper=20 ,cost=:price_cost" ;
				}
				
						
						
						
			// prepare query
			$stmt = $this->conn->prepare($query);

			// bind values
			$stmt->bindParam(":customer_code", $customer_code);	
			$stmt->bindParam(":price_cost", $price_cost);		
			$stmt->bindParam(":agent_code", $agent_code);		
			$stmt->bindParam(":co_agent_code", $co_agent_code);		
			$stmt->bindParam(":weight_l", $weight_l);

			// execute query
			if($stmt->execute()){
				return true;
			}
		
			return false;
		
		
	}

	function createcod_thaipost($customer_code,
							$price_l
							){
	 
		// query to insert record
		$query = "INSERT INTO
					tb_thaidiscountprofilecod
				SET
						customer_code=:customer_code,
						cod_l=:price_l,
						cod = 0 ";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":price_l", $price_l);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
	function getzipcode()
	{

		// select all query
		$query = "SELECT * FROM tb_zipcode";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		
		$stmt->execute();

		return $stmt;
	}


	function getshopprice_thaipost($customer_code)
	{

		// select all query
		$query = "SELECT * FROM  tb_thaipost_shopprice 
				  WHERE customer_code = ?  ";




		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));		
		// bind
		$stmt->bindParam(1, $customer_code);
		// execute query
		$stmt->execute();

		return $stmt;
	}

	function createshopprice_thaipost($customer_code,
							$type,
							$_002kg,
							$_01kg,
							$_025kg,
							$_05kg,
							$_1kg,
							$_1500kg,
							$_2kg,
							$_25kg,
							$_3kg,
							$_35kg,
							$_4kg,
							$_45kg,
							$_5kg,
							$_55kg,
							$_6kg,
							$_65kg,
							$_7kg,
							$_75kg,
							$_8kg,
							$_85kg,
							$_9kg,
							$_95kg,
							$_10kg,
							$_11kg,
							$_12kg,
							$_13kg,
							$_14kg,
							$_15kg,
							$_16kg,
							$_17kg,
							$_18kg,
							$_19kg,
							$_20kg,
							$_21kg,
							$_22kg,
							$_23kg,
							$_24kg,
							$_250kg,
							$_26kg,
							$_27kg,
							$_28kg,
							$_29kg,
							$_30kg,
							$_31kg,
							$_32kg,
							$_33kg,
							$_34kg,
							$_350kg,
							$_36kg,
							$_37kg,
							$_38kg,
							$_39kg,
							$_40kg,
							$_41kg
							){
	 
		// query to insert record
		$query = "INSERT INTO
					tb_thaipost_shopprice
				SET
					customer_code=:customer_code,
						type=:type,
						kg_002=:_002kg,
						kg_01=:_01kg,
						kg_025=:_025kg,
						kg_05=:_05kg,
						kg_1=:_1kg,
						kg_1500=:_1500kg,
						kg_2=:_2kg,
						kg_25=:_25kg,
						kg_3=:_3kg,
						kg_35=:_35kg,
						kg_4=:_4kg,
						kg_45=:_45kg,
						kg_5=:_5kg,
						kg_55=:_55kg,
						kg_6=:_6kg,
						kg_65=:_65kg,
						kg_7=:_7kg,
						kg_75=:_75kg,
						kg_8=:_8kg,
						kg_85=:_85kg,
						kg_9=:_9kg,
						kg_95=:_95kg,
						kg_10=:_10kg,
						kg_11=:_11kg,
						kg_12=:_12kg,
						kg_13=:_13kg,
						kg_14=:_14kg,
						kg_15=:_15kg,
						kg_16=:_16kg,
						kg_17=:_17kg,
						kg_18=:_18kg,
						kg_19=:_19kg,
						kg_20=:_20kg,
						kg_21=:_21kg,
						kg_22=:_22kg,
						kg_23=:_23kg,
						kg_24=:_24kg,
						kg_250=:_250kg,
						kg_26=:_26kg,
						kg_27=:_27kg,
						kg_28=:_28kg,
						kg_29=:_29kg,
						kg_30=:_30kg,
						kg_31=:_31kg,
						kg_32=:_32kg,
						kg_33=:_33kg,
						kg_34=:_34kg,
						kg_350=:_350kg,
						kg_36=:_36kg,
						kg_37=:_37kg,
						kg_38=:_38kg,
						kg_39=:_39kg,
						kg_40=:_40kg,
						kg_41=:_41kg
						";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":type", $type);
		$stmt->bindParam(":_002kg", $_002kg);
		$stmt->bindParam(":_01kg", $_01kg);
		$stmt->bindParam(":_025kg", $_025kg);
		$stmt->bindParam(":_05kg", $_05kg);
		$stmt->bindParam(":_1kg", $_1kg);
		$stmt->bindParam(":_1500kg", $_1500kg);
		$stmt->bindParam(":_2kg", $_2kg);
		$stmt->bindParam(":_25kg", $_25kg);
		$stmt->bindParam(":_3kg", $_3kg);
		$stmt->bindParam(":_35kg", $_35kg);
		$stmt->bindParam(":_4kg", $_4kg);
		$stmt->bindParam(":_45kg", $_45kg);
		$stmt->bindParam(":_5kg", $_5kg);
		$stmt->bindParam(":_55kg", $_55kg);
		$stmt->bindParam(":_6kg", $_6kg);
		$stmt->bindParam(":_65kg", $_65kg);
		$stmt->bindParam(":_7kg", $_7kg);
		$stmt->bindParam(":_75kg", $_75kg);
		$stmt->bindParam(":_8kg", $_8kg);
		$stmt->bindParam(":_85kg", $_85kg);
		$stmt->bindParam(":_9kg", $_9kg);
		$stmt->bindParam(":_95kg", $_95kg);
		$stmt->bindParam(":_10kg", $_10kg);
		$stmt->bindParam(":_11kg", $_11kg);
		$stmt->bindParam(":_12kg", $_12kg);
		$stmt->bindParam(":_13kg", $_13kg);
		$stmt->bindParam(":_14kg", $_14kg);
		$stmt->bindParam(":_15kg", $_15kg);
		$stmt->bindParam(":_16kg", $_16kg);
		$stmt->bindParam(":_17kg", $_17kg);
		$stmt->bindParam(":_18kg", $_18kg);
		$stmt->bindParam(":_19kg", $_19kg);
		$stmt->bindParam(":_20kg", $_20kg);
		$stmt->bindParam(":_21kg", $_21kg);
		$stmt->bindParam(":_22kg", $_22kg);
		$stmt->bindParam(":_23kg", $_23kg);
		$stmt->bindParam(":_24kg", $_24kg);
		$stmt->bindParam(":_250kg", $_250kg);
		$stmt->bindParam(":_26kg", $_26kg);
		$stmt->bindParam(":_27kg", $_27kg);
		$stmt->bindParam(":_28kg", $_28kg);
		$stmt->bindParam(":_29kg", $_29kg);
		$stmt->bindParam(":_30kg", $_30kg);
		$stmt->bindParam(":_31kg", $_31kg);
		$stmt->bindParam(":_32kg", $_32kg);
		$stmt->bindParam(":_33kg", $_33kg);
		$stmt->bindParam(":_34kg", $_34kg);
		$stmt->bindParam(":_350kg", $_350kg);
		$stmt->bindParam(":_36kg", $_36kg);
		$stmt->bindParam(":_37kg", $_37kg);
		$stmt->bindParam(":_38kg", $_38kg);
		$stmt->bindParam(":_39kg", $_39kg);
		$stmt->bindParam(":_40kg", $_40kg);
		$stmt->bindParam(":_41kg", $_41kg);

		// execute query
		if($stmt->execute()){
			return true;
		}	 
		return false;		 
	}

	function updateshopprice_thaipost($customer_code,
			$type,
			$_002kg,
			$_01kg,
			$_025kg,
			$_05kg,
			$_1kg,
			$_1500kg,
			$_2kg,
			$_25kg,
			$_3kg,
			$_35kg,
			$_4kg,
			$_45kg,
			$_5kg,
			$_55kg,
			$_6kg,
			$_65kg,
			$_7kg,
			$_75kg,
			$_8kg,
			$_85kg,
			$_9kg,
			$_95kg,
			$_10kg,
			$_11kg,
			$_12kg,
			$_13kg,
			$_14kg,
			$_15kg,
			$_16kg,
			$_17kg,
			$_18kg,
			$_19kg,
			$_20kg,
			$_21kg,
			$_22kg,
			$_23kg,
			$_24kg,
			$_250kg,
			$_26kg,
			$_27kg,
			$_28kg,
			$_29kg,
			$_30kg,
			$_31kg,
			$_32kg,
			$_33kg,
			$_34kg,
			$_350kg,
			$_36kg,
			$_37kg,
			$_38kg,
			$_39kg,
			$_40kg,
			$_41kg
			){

		// query to insert record
		$query = "UPDATE
		tb_thaipost_shopprice
		SET
		customer_code=:customer_code,
		type=:type,
		kg_002=:_002kg,
		kg_01=:_01kg,
		kg_025=:_025kg,
		kg_05=:_05kg,
		kg_1=:_1kg,
		kg_1500=:_1500kg,
		kg_2=:_2kg,
		kg_25=:_25kg,
		kg_3=:_3kg,
		kg_35=:_35kg,
		kg_4=:_4kg,
		kg_45=:_45kg,
		kg_5=:_5kg,
		kg_55=:_55kg,
		kg_6=:_6kg,
		kg_65=:_65kg,
		kg_7=:_7kg,
		kg_75=:_75kg,
		kg_8=:_8kg,
		kg_85=:_85kg,
		kg_9=:_9kg,
		kg_95=:_95kg,
		kg_10=:_10kg,
		kg_11=:_11kg,
		kg_12=:_12kg,
		kg_13=:_13kg,
		kg_14=:_14kg,
		kg_15=:_15kg,
		kg_16=:_16kg,
		kg_17=:_17kg,
		kg_18=:_18kg,
		kg_19=:_19kg,
		kg_20=:_20kg,
		kg_21=:_21kg,
		kg_22=:_22kg,
		kg_23=:_23kg,
		kg_24=:_24kg,
		kg_250=:_250kg,
		kg_26=:_26kg,
		kg_27=:_27kg,
		kg_28=:_28kg,
		kg_29=:_29kg,
		kg_30=:_30kg,
		kg_31=:_31kg,
		kg_32=:_32kg,
		kg_33=:_33kg,
		kg_34=:_34kg,
		kg_350=:_350kg,
		kg_36=:_36kg,
		kg_37=:_37kg,
		kg_38=:_38kg,
		kg_39=:_39kg,
		kg_40=:_40kg,
		kg_41=:_41kg
		WHERE customer_code=:customer_code";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":type", $type);
		$stmt->bindParam(":_002kg", $_002kg);
		$stmt->bindParam(":_01kg", $_01kg);
		$stmt->bindParam(":_025kg", $_025kg);
		$stmt->bindParam(":_05kg", $_05kg);
		$stmt->bindParam(":_1kg", $_1kg);
		$stmt->bindParam(":_1500kg", $_1500kg);
		$stmt->bindParam(":_2kg", $_2kg);
		$stmt->bindParam(":_25kg", $_25kg);
		$stmt->bindParam(":_3kg", $_3kg);
		$stmt->bindParam(":_35kg", $_35kg);
		$stmt->bindParam(":_4kg", $_4kg);
		$stmt->bindParam(":_45kg", $_45kg);
		$stmt->bindParam(":_5kg", $_5kg);
		$stmt->bindParam(":_55kg", $_55kg);
		$stmt->bindParam(":_6kg", $_6kg);
		$stmt->bindParam(":_65kg", $_65kg);
		$stmt->bindParam(":_7kg", $_7kg);
		$stmt->bindParam(":_75kg", $_75kg);
		$stmt->bindParam(":_8kg", $_8kg);
		$stmt->bindParam(":_85kg", $_85kg);
		$stmt->bindParam(":_9kg", $_9kg);
		$stmt->bindParam(":_95kg", $_95kg);
		$stmt->bindParam(":_10kg", $_10kg);
		$stmt->bindParam(":_11kg", $_11kg);
		$stmt->bindParam(":_12kg", $_12kg);
		$stmt->bindParam(":_13kg", $_13kg);
		$stmt->bindParam(":_14kg", $_14kg);
		$stmt->bindParam(":_15kg", $_15kg);
		$stmt->bindParam(":_16kg", $_16kg);
		$stmt->bindParam(":_17kg", $_17kg);
		$stmt->bindParam(":_18kg", $_18kg);
		$stmt->bindParam(":_19kg", $_19kg);
		$stmt->bindParam(":_20kg", $_20kg);
		$stmt->bindParam(":_21kg", $_21kg);
		$stmt->bindParam(":_22kg", $_22kg);
		$stmt->bindParam(":_23kg", $_23kg);
		$stmt->bindParam(":_24kg", $_24kg);
		$stmt->bindParam(":_250kg", $_250kg);
		$stmt->bindParam(":_26kg", $_26kg);
		$stmt->bindParam(":_27kg", $_27kg);
		$stmt->bindParam(":_28kg", $_28kg);
		$stmt->bindParam(":_29kg", $_29kg);
		$stmt->bindParam(":_30kg", $_30kg);
		$stmt->bindParam(":_31kg", $_31kg);
		$stmt->bindParam(":_32kg", $_32kg);
		$stmt->bindParam(":_33kg", $_33kg);
		$stmt->bindParam(":_34kg", $_34kg);
		$stmt->bindParam(":_350kg", $_350kg);
		$stmt->bindParam(":_36kg", $_36kg);
		$stmt->bindParam(":_37kg", $_37kg);
		$stmt->bindParam(":_38kg", $_38kg);
		$stmt->bindParam(":_39kg", $_39kg);
		$stmt->bindParam(":_40kg", $_40kg);
		$stmt->bindParam(":_41kg", $_41kg);

		// execute query
		if($stmt->execute()){
		return true;
		}

		return false;		 
	}		


	
	function updateshopcod_thaipost($customer_code,$price){
	 
		// query to insert record
		$query = "UPDATE
					tb_thaipost_shopcod
				SET
					price=:price
				WHERE customer_code=:customer_code";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":price", $price);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	
	function createshopcod_thaipost($customer_code,$price){
	 
		// query to insert record
		$query = "INSERT INTO
					tb_thaipost_shopcod
				SET
						customer_code=:customer_code,
						price=:price";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize

		// bind values
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":price", $price);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

	function getshopcod_thaipost($customer_code)
	{

		// select all query
		$query = "SELECT * FROM tb_thaipost_shopcod
				  WHERE customer_code = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$customer_code=htmlspecialchars(strip_tags($customer_code));
		// bind
		$stmt->bindParam(1, $customer_code);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	function getshopemsworld_thaipost($customer_code)
	{
		$query = "SELECT price FROM tb_thaipost_shopemsworld
				  WHERE customer_code = ?";

		$stmt = $this->conn->prepare($query);

		$customer_code=htmlspecialchars(strip_tags($customer_code));
		
		$stmt->bindParam(1, $customer_code);

		$stmt->execute();

		return $stmt;
	}
	
	function updateshopemsworld_thaipost($customer_code,$price){
	 
		$query = "UPDATE
					tb_thaipost_shopemsworld
				SET
					price=:price
				WHERE customer_code=:customer_code";

		$stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":price", $price);

		if($stmt->execute()){
			return true;
		}	 
		return false;
		 
	}

	
	function createshopemsworld_thaipost($customer_code,$price){
	
		$query = "INSERT INTO
					tb_thaipost_shopemsworld
				SET
						customer_code=:customer_code,
						price=:price";

		$stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(":customer_code", $customer_code);
		$stmt->bindParam(":price", $price);

		if($stmt->execute()){
			return true;
		}	 
		return false;
		 
	}
}
