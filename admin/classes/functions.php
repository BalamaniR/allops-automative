<?php
require_once('dbclass.php');
class User {
    /* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }
	
    public function validate_user_password($email, $pass) {
        try {
            // Fetch stored password and status from database
            $sql = "SELECT user_pwd FROM admin_credential WHERE user_email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $storedPassword = trim($result['user_pwd']);
                    $encodedInput = base64_encode($pass);
                    if ($encodedInput === $storedPassword) {
                        return true;
                    }
            }
            return false;

        } catch (PDOException $e) {
            echo "Validation error: " . $e->getMessage();
            return false;
        }
    }

	public function get_user_password($email){
		try {
			$sql = "SELECT 	user_password FROM user_data WHERE user_email = :email";
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

	
	public function get_userDetails(){
		try {
			$sql = "SELECT u.*,j.`journey_status` FROM `user_data` as u,`allops_journey_details` as j WHERE u.`customer_id`= j.`customer_id`";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Validation error: " . $e->getMessage();
			return false;
		}
	}


    public function get_user_by_email($email) {
        $sql = "SELECT `id`, `user_name`, `user_email`, `user_pwd`, `user_type` FROM `admin_credential` WHERE  user_email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_user_journey_details($cid){
      try {
        $sql="SELECT  u.`user_name`, u.`user_phone`, u.`user_email`, u.`user_address`, u.`user_driver_license_number`, u.`user_license_issue_date`, u.`user_license_expiry_date`, u.`user_dob`, u.`insurance_policy_number`, u.`insurance_policy_company`, j.`from_location`,j.`to_location`, j.`kickoff_date`, j.`kickoff_time`, j.`journey_type`, j.`car`, j.`car_type` FROM   `user_data` as u ,`allops_journey_details` as j WHERE u.customer_id=j.`customer_id` AND u.customer_id= :cid";
            $stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
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