<?php
    date_default_timezone_set("Asia/Bangkok");
    require __DIR__.'/../../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable("../..");
    $dotenv->load();

    


    class Database{
    
        public $conn;
        // specify your own database credentials from environment variables
        private $host;
        private $db_name;
        private $username;
        private $password;

        public function __construct() {
            $this->host = $_ENV["DB_HOST"]; // or use getenv('DB_HOST') if you prefer
            $this->db_name = $_ENV["DB_DATABASE"]; // or use getenv('DB_NAME') if you prefer
            $this->username = $_ENV["DB_USERNAME"]; // or use getenv('DB_USERNAME') if you prefer
            $this->password = $_ENV["DB_PASSWORD"]; // or use getenv('DB_PASSWORD') if you prefer
        }

        
        // get the database connection
        public function getConnection(){
    
            $this->conn = null;
    
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                    $this->username, 
                    $this->password, 
                    array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
                );
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
    
            return $this->conn;
        }
    }

?>