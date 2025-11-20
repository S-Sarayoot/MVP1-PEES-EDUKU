<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "elk_user";

	public $user_id;
	public $user_code;

	public $username;
	public $password;

	public $user_type;	
	public $user_name;	
	public $user_province;	
	public $user_district;	
	public $user_address;	
	public $user_zipcode;
	public $user_telephone;	
	public $user_email;	
	public $user_contactname;	

	public $company_house_file;	
	public $idcard_file;	
	public $book_bank_file;	

	public $status;
	public $create_date;	
	public $update_date;
	public $services;
	public $bookbank_id;
	public $bookbank_name;
	public $bookbank_cusname;

	public $faculty_id;
	public $major_id;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	public function getByType($type) {
		$sql = "SELECT u.*, 
					m.name AS major_name, 
					f.name AS faculty_name
				FROM {$this->table_name} u
				LEFT JOIN elk_major m ON u.major_id = m.id
				LEFT JOIN elk_faculty f ON u.faculty_id = f.id
				WHERE u.user_type = :type
				ORDER BY u.user_id DESC";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([':type' => $type]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public function userExists(){
	 
		// query to check if email exists
		$query = "SELECT * FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
	 
		// prepare the query
		$stmt = $this->conn->prepare( $query );
	 
	 
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
            $this->user_id = $row['user_id'];
			$this->user_code = $row['user_code'];
			$this->username = $row['username'];
			$this->password = $row['password'];
			$this->user_type = $row['user_type'];
			$this->user_name = $row['user_name'];
			$this->user_province = $row['user_province'];
			$this->user_district = $row['user_district'];
			$this->user_zipcode = $row['user_zipcode'];
			$this->user_address = $row['user_address'];
			$this->user_telephone = $row['user_telephone'];
			$this->user_email = $row['user_email'];
			$this->user_contactname = $row['user_contactname'];
            $this->company_house_file = $row['company_house_file'];
            $this->idcard_file = $row['idcard_file'];
            $this->book_bank_file = $row['book_bank_file'];
            $this->status = $row['status'];
            $this->create_date = $row['create_date'];
            $this->update_date = $row['update_date'];
			
            
			// return true because email exists in the database
			return true;
		}
	 
		// return false if email does not exist in the database
		return false;
	}

	public function getalluser(){
		// select all query
		$query = "SELECT * FROM " . $this->table_name . " WHERE status!='0' ORDER BY user_code DESC";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}

	public function getallcustomer(){
		// select all query
		$query = "SELECT * FROM " . $this->table_name . " WHERE user_type='customer' ORDER BY user_code DESC";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}

	public function getUserById($user_id){
		// select all query
		$query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// bind id of user to be updated
		$stmt->bindParam(1, $user_id);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}

	//record user to tb_user
	public function createUser(){
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "
            SET user_code=:user_code, username=:username, password=:password, user_type=:user_type, 
            user_name=:user_name, user_province=:user_province, user_district=:user_district, 
            user_address=:user_address, user_telephone=:user_telephone, user_email=:user_email, 
            user_contactname=:user_contactname, company_house_file=:company_house_file, 
            idcard_file=:idcard_file, book_bank_file=:book_bank_file, status=:status,
            faculty_id=:faculty_id, major_id=:major_id";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->user_code=htmlspecialchars(strip_tags($this->user_code));
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->user_type=htmlspecialchars(strip_tags($this->user_type));
    $this->user_name=htmlspecialchars(strip_tags($this->user_name));
    $this->user_province=htmlspecialchars(strip_tags($this->user_province));
    $this->user_district=htmlspecialchars(strip_tags($this->user_district));
    $this->user_address=htmlspecialchars(strip_tags($this->user_address));
    $this->user_telephone=htmlspecialchars(strip_tags($this->user_telephone));
    $this->user_email=htmlspecialchars(strip_tags($this->user_email));
    $this->user_contactname=htmlspecialchars(strip_tags($this->user_contactname));
    $this->company_house_file= $this->company_house_file ? htmlspecialchars(strip_tags($this->company_house_file)) : null;
    $this->idcard_file= $this->idcard_file ? htmlspecialchars(strip_tags($this->idcard_file)) : null;
    $this->book_bank_file= $this->book_bank_file ? htmlspecialchars(strip_tags($this->book_bank_file)) : null;
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->faculty_id=htmlspecialchars(strip_tags($this->faculty_id));
    $this->major_id=htmlspecialchars(strip_tags($this->major_id));

    // bind values
    $stmt->bindParam(":user_code", $this->user_code);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":user_type", $this->user_type);
    $stmt->bindParam(":user_name", $this->user_name);
    $stmt->bindParam(":user_province", $this->user_province);
    $stmt->bindParam(":user_district", $this->user_district);
    $stmt->bindParam(":user_address", $this->user_address);
    $stmt->bindParam(":user_telephone", $this->user_telephone);
    $stmt->bindParam(":user_email", $this->user_email);
    $stmt->bindParam(":user_contactname", $this->user_contactname);
    $stmt->bindParam(":company_house_file", $this->company_house_file);
    $stmt->bindParam(":idcard_file", $this->idcard_file);
    $stmt->bindParam(":book_bank_file", $this->book_bank_file);
    $stmt->bindParam(":status", $this->status);
    $stmt->bindParam(":faculty_id", $this->faculty_id);
    $stmt->bindParam(":major_id", $this->major_id);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        error_log("Error creating user: " . print_r($stmt->errorInfo(), true));
        return false;
    }
	}


	public function updateUser () {
    $query = "UPDATE " . $this->table_name . "
            SET user_code=:user_code, user_type=:user_type, 
            user_name=:user_name, user_province=:user_province, user_district=:user_district, 
            user_address=:user_address, user_zipcode=:user_zipcode, user_telephone=:user_telephone, user_email=:user_email, 
            user_contactname=:user_contactname, company_house_file=:company_house_file, 
            idcard_file=:idcard_file, book_bank_file=:book_bank_file, status=:status,
            faculty_id=:faculty_id, major_id=:major_id
            WHERE user_id = :user_id";

    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->user_code=htmlspecialchars(strip_tags($this->user_code));
    $this->user_type=htmlspecialchars(strip_tags($this->user_type));
    $this->user_name=htmlspecialchars(strip_tags($this->user_name));
    $this->user_province=htmlspecialchars(strip_tags($this->user_province));
    $this->user_district=htmlspecialchars(strip_tags($this->user_district));
    $this->user_address=htmlspecialchars(strip_tags($this->user_address));
    $this->user_zipcode=htmlspecialchars(strip_tags($this->user_zipcode));
    $this->user_telephone=htmlspecialchars(strip_tags($this->user_telephone));
    $this->user_email=htmlspecialchars(strip_tags($this->user_email));
    $this->user_contactname=htmlspecialchars(strip_tags($this->user_contactname));
    $this->company_house_file= $this->company_house_file ? htmlspecialchars(strip_tags($this->company_house_file)) : null;
    $this->idcard_file= $this->idcard_file ? htmlspecialchars(strip_tags($this->idcard_file)) : null;
    $this->book_bank_file= $this->book_bank_file ? htmlspecialchars(strip_tags($this->book_bank_file)) : null;
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->faculty_id=htmlspecialchars(strip_tags($this->faculty_id));
    $this->major_id=htmlspecialchars(strip_tags($this->major_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));

    // bind values
    $stmt->bindParam(":user_code", $this->user_code);
    $stmt->bindParam(":user_type", $this->user_type);
    $stmt->bindParam(":user_name", $this->user_name);	
    $stmt->bindParam(":user_province", $this->user_province);
    $stmt->bindParam(":user_address", $this->user_address);
    $stmt->bindParam(":user_zipcode", $this->user_zipcode);
    $stmt->bindParam(":user_district", $this->user_district);
    $stmt->bindParam(":user_telephone", $this->user_telephone);
    $stmt->bindParam(":user_email", $this->user_email);
    $stmt->bindParam(":user_contactname", $this->user_contactname);
    $stmt->bindParam(":company_house_file", $this->company_house_file);
    $stmt->bindParam(":idcard_file", $this->idcard_file);
    $stmt->bindParam(":book_bank_file", $this->book_bank_file);
    $stmt->bindParam(":status", $this->status);
    $stmt->bindParam(":faculty_id", $this->faculty_id);
    $stmt->bindParam(":major_id", $this->major_id);
    $stmt->bindParam(":user_id", $this->user_id);

    if($stmt->execute()){
        return true;
    }else{
        error_log("Error updating user: " . print_r($stmt->errorInfo(), true));
        return false;
    }
}
			
	public function deleteUser () {
		$query = "UPDATE ". $this->table_name ." SET status=:status,user_code=:user_code,username=:username,update_date=:update_date WHERE user_id=:user_id ";
		
		$stmt = $this->conn->prepare($query);

		//bind
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":user_code", $this->user_code);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":update_date", $this->update_date);
		$stmt->bindParam(":user_id", $this->user_id);

		if($stmt->execute()){
			return true;
		}
		return false;
	}

	public function updatePassword() {
		// query to update password
		$query = "UPDATE " . $this->table_name . " SET password = :password WHERE user_id = :user_id";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":user_id", $this->user_id);

		// execute the query
		if($stmt->execute()){
			return true;
		}
		return false;
	}






													    




}