<?php
require_once('dbclass.php');
class User {
    /* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }
	
	public function add_user_data($uname,$phone, $email, $address,$license_num,$license_issueDate,$license_exp_date,$dob) {
		try {
			$sql = "INSERT INTO user_data (`user_name`, `user_phone`, `user_email`, `user_address`, `user_driver_license_number`, `user_license_issue_date`, `user_dobuser_license_expiry_date`, `user_dob`, `user_registered_date`) VALUES (:uname, :phone, :email, :address, :license_no, :license_issue_date, :license_exp_date, :dob,:reg_date)";
			$stmt = $this->conn->prepare($sql);
			$reg_date = date("Y-m-d");
			// Bind parameters to protect against SQL injection
			$stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':address', $address, PDO::PARAM_STR);
			$stmt->bindParam(':license_no', $license_num, PDO::PARAM_STR);
			$stmt->bindParam(':license_issue_date', $license_issueDate, PDO::PARAM_STR);
			$stmt->bindParam(':license_exp_date', $license_exp_date, PDO::PARAM_STR);
			$stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
			$stmt->bindParam(':reg_date', $reg_date, PDO::PARAM_STR);
			if ($stmt->execute()) {
				return $this->conn->lastInsertId(); 
			} else {
				return false;
			}
		} catch (PDOException $e) {
					echo "Insertion error: " . $e->getMessage();
					return false;
		}
	}

	public function update_user_password($user,$pwd){
		$sql = "UPDATE user_data SET user_password = :password WHERE user_id  = :id";
		$stmt =  $this->conn->prepare($sql);
		// Bind parameters
		$stmt->bindParam(':password', $pwd, PDO::PARAM_STR);
		$stmt->bindParam(':id', $user, PDO::PARAM_INT);
		// Execute
		if ($stmt->execute()) {
			#echo "Password updated successfully!";
		} else {
			echo "Failed to update password.";
		}
	
	}

	public function validate_user_password($email, $pass) {  
		try {
			// Prepare SQL query to fetch the latest non-empty password entry
			$sql = "SELECT user_password FROM user_data WHERE user_email = :email AND user_password != '' ORDER BY user_id DESC LIMIT 1";
			$stmt = $this->conn->prepare($sql);
			// Bind the email parameter safely
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			// Fetch result and debug print
			$result = $stmt->fetch(PDO::FETCH_ASSOC);    
			// Exit early to inspect result, remove die() when using in production
			// die;
			// Compare plain password since the stored value is not hashed
			if ($result && $pass === trim($result['user_password'])) {
				return true; 
			} else {
				return false; 
			}
		} catch (PDOException $e) {
			echo "Validation error: " . $e->getMessage();
			return false;
		}
	}

	public function update_change_password($email,$pwd){
		try {
			$sql = "UPDATE user_data SET user_password = :password, user_pwd_update = '1' WHERE user_email = :email";
			$stmt = $this->conn->prepare($sql);

			// Bind parameters
			$stmt->bindParam(':password', $pwd, PDO::PARAM_STR);  // Assuming $pwd is a hashed password or plain text
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);    // Match column type: varchar(150)

			if ($stmt->execute()) {
			// echo "Password updated successfully!";
			} else {
			echo "Failed to update password.";
			}
		} catch (PDOException $e) {
			echo "Update error: " . $e->getMessage();
		}
		
	}

	public function get_pwd_change_flag($email){
		try {
			$sql = "SELECT user_pwd_update FROM user_data WHERE user_email = :email";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Validation error: " . $e->getMessage();
			return false;
		}
	}



}
$obj = new User($pdo);
?>