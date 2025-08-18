<?php
require_once('dbclass.php');
class User {
    /* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }
	
	public function add_user_data($uname, $phone, $email, $address, $license_num, $license_issueDate, $license_exp_date, $dob,$policy,$policyNumber,$policyCompany,$insuranceCopyPath) {
    try {
        $prefix = 'ALLOPS25-';

        // Step 1: Get the latest customer_id
        $sql = "SELECT customer_id FROM user_data WHERE customer_id LIKE :prefix ORDER BY user_id DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $likePrefix = $prefix . '%';
        $stmt->bindParam(':prefix', $likePrefix, PDO::PARAM_STR);
        $stmt->execute();

        $latest = $stmt->fetchColumn();

        // Step 2: Extract numeric part and increment
        if ($latest) {
            $number = (int) substr($latest, strlen($prefix));
            $number++;
        } else {
            $number = 1;
        }

        // Step 3: Format the new customer_id
        $new_custom_id = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);

        // Step 4: Prepare registration date
        $reg_date = date("Y-m-d");

        // Step 5: Insert new record
        $sql = "INSERT INTO user_data (
                    customer_id,
                    user_name,
                    user_phone,
                    user_email,
                    user_address,
                    user_driver_license_number,
                    user_license_issue_date,
                    user_license_expiry_date,
                    user_dob,
                    policy,
                    policy_number,
                    policy_company,
                    insurance_copy_path,
                    user_registered_date
                ) VALUES (
                    :custom_id,
                    :uname,
                    :phone,
                    :email,
                    :address,
                    :license_no,
                    :license_issue_date,
                    :license_exp_date,
                    :dob,
                    :policy,
                    :policyNo,
                    :insCompany,
                    :policyPath,
                    :reg_date
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':custom_id', $new_custom_id, PDO::PARAM_STR);
        $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':license_no', $license_num, PDO::PARAM_STR);
        $stmt->bindParam(':license_issue_date', $license_issueDate, PDO::PARAM_STR);
        $stmt->bindParam(':license_exp_date', $license_exp_date, PDO::PARAM_STR);
        $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindParam(':policy', $policy, PDO::PARAM_STR);
        $stmt->bindParam(':policyNo', $policyNumber, PDO::PARAM_STR);
        $stmt->bindParam(':insCompany', $policyCompany, PDO::PARAM_STR);
        $stmt->bindParam(':policyPath', $insuranceCopyPath, PDO::PARAM_STR);
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
        // Fetch stored password and status from database
        $sql = "SELECT user_password, user_pwd_update FROM user_data WHERE user_email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $storedPassword = trim($result['user_password']);
            $status = isset($result['user_pwd_update']) ? (int)$result['user_pwd_update'] : 0;

            if ($status === 1 || $status === 2) {
                // Encode entered password using base64 and compare
                $encodedInput = base64_encode($pass);
                if ($encodedInput === $storedPassword) {
                    return true;
                }
            } else {
                // Compare plain text directly
                if ($pass === $storedPassword) {
                    return true;
                }
            }
        }

        return false;

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

	public function update_password_flag($email){
		try {
			$sql = "UPDATE user_data SET user_pwd_update = '2' WHERE user_email = :email";
			$stmt = $this->conn->prepare($sql);

			// Bind parameters
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
	public function get_user_details($email){
		try {
			$sql = "SELECT 	* FROM user_data WHERE user_email = :email";
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

	public function update_user_details($userId,$phone,$address,$issuedDate,$expDate,$profilePhotoPath){
		try {
			$sql = "UPDATE user_data  SET user_phone =:phone ,user_address=:addr,user_license_issue_date=:issued,user_license_expiry_date=:expiry,profile_photo=:profile  WHERE user_id = :id";
			$stmt = $this->conn->prepare($sql);

			// Bind parameters
			$stmt->bindParam(':id', $userId, PDO::PARAM_STR);  
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);    // Match column type: varchar(150)
			$stmt->bindParam(':addr', $address, PDO::PARAM_STR); 
			$stmt->bindParam(':issued', $issuedDate, PDO::PARAM_STR); 
			$stmt->bindParam(':expiry', $expDate, PDO::PARAM_STR); 
			$stmt->bindParam(':profile', $profilePhotoPath, PDO::PARAM_STR); 

			if ($stmt->execute()) {
			// echo "Password updated successfully!";
			} else {
			echo "Failed to update password.";
			}
		} catch (PDOException $e) {
			echo "Update error: " . $e->getMessage();
		}
	}

	
	public function get_latest_customerID() {
            try {
                $prefix = 'ALLOPS25-';

                // Step 1: Get the latest custom_id
                $sql = "SELECT customer_id FROM user_data WHERE custom_id LIKE :prefix ORDER BY id DESC LIMIT 1";
                $stmt = $this->conn->prepare($sql);
                $likePrefix = $prefix . '%';
                $stmt->bindParam(':prefix', $likePrefix, PDO::PARAM_STR);
                $stmt->execute();

                $latest = $stmt->fetchColumn();

                // Step 2: Extract the numeric part and increment
                if ($latest) {
                    $number = (int) substr($latest, strlen($prefix));
                    $number++;
                } else {
                    $number = 1;
                }

                // Step 3: Format the new custom_id
                $new_custom_id = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);

                // Step 4: Insert new record
                $insertSql = "INSERT INTO user_data (customer_id) VALUES (:custom_id)";
                $insertStmt = $this->conn->prepare($insertSql);
                $insertStmt->bindParam(':custom_id', $new_custom_id, PDO::PARAM_STR);
                $insertStmt->execute();
                return $new_custom_id;
            } catch (PDOException $e) {
                echo "Insert error: " . $e->getMessage();
                return false;
            }
    }

    public function get_user_by_email($email) {
        $sql = "SELECT user_id, user_email,user_name,user_pwd_update,customer_id FROM user_data WHERE user_email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_car_name($carId){
        $sql = "SELECT `car_id`, `car_company_name` FROM `allops_car_list` WHERE `car_id` = :carid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':carid', $carId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    
    }



    public function get_car_comapnyList(){
        $sql = "SELECT `car_id`, `car_company_name` FROM `allops_car_list` WHERE  `car_availability` = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Create your manual row
        $manualRow = [
            'car_id' => '0',
            'car_company_name' => 'Any',
        
        ];
        // Prepend it to the results
        array_unshift($results, $manualRow);
        return $results;
    }

    public function get_carnames($carId){
        if($carId == 0){
             $sql = "SELECT DISTINCT(`car_type`) as car_type  FROM `allops_car_details`"; 
             $stmt = $this->conn->prepare($sql);
        }else{
            $sql = "SELECT`car_id`,`car_type` FROM `allops_car_details` WHERE `car_id`=:cid ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cid', $carId, PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function get_car_details($carCompany, $carName, $fuel, $seat) {
    $conditions = [];
    $params = [];

    // Normalize carCompany
    if ($carCompany == 0 || $carCompany === '0') {
        $carCompany = '';
    }

    // Normalize carName
    if ($carName == 0 || $carName === '0') {
        $carName = '';
    }

    if ($carCompany !== '') {
        $conditions[] = 'car_id = :car';
        $params[':car'] = $carCompany;
    } else {
        $conditions[] = "car_id != ''";
    }

    if ($carName !== '') {
        $conditions[] = 'car_type = :carname';
        $params[':carname'] = $carName;
    } else {
        $conditions[] = "car_type != ''";
    }

    if ($fuel !== null) {
        $conditions[] = "fuel_type LIKE :fuel";
        $params[':fuel'] = '%' . $fuel . '%';
    } else {
        $conditions[] = "fuel_type != ''";
    }

    if ($seat === 'child') {
        $seat = 'Y';
    } elseif ($seat === 'adult') {
        $seat = 'N';
    } elseif ($seat === 'any' || $seat === '' || $seat === NULL) {
        $seat = null; // Skip filtering
    }

    if ($seat === 'Y' || $seat === 'N') {
        $conditions[] = 'child_seat = :child_seat';
        $params[':child_seat'] = $seat;
    }

    $sql = "SELECT * FROM `allops_car_details` WHERE " . implode(' AND ', $conditions);

    $stmt = $this->conn->prepare($sql);

    // Debug output
    foreach ($params as $key => $value) {
        $quotedValue = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
    
    }

    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function add_user_journeyData($uid,$customer_id,$from,$to,$journeyType,$departDate,$departTime,$status,$booked_date){
  

  if ($status == 'Booked') {
    $status = 1;
}

try {
    $sql = "INSERT INTO allops_journey_details (
                `uid`, `customer_id`, `from_location`, `to_location`, `kickoff_date`, `kickoff_time`,
                `journey_type`, `booking_status`, `booked_date`
            ) VALUES (
                :user_id,
                :customer_id,
                :from_location,
                :to_location,
                :startdate,
                :startTime,
                :journeyType,
                :booking_status,
                :booked_date
            )";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':user_id', $uid, PDO::PARAM_STR);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
    $stmt->bindParam(':from_location', $from, PDO::PARAM_STR);
    $stmt->bindParam(':to_location', $to, PDO::PARAM_STR);
    $stmt->bindParam(':startdate', $departDate, PDO::PARAM_STR);
    $stmt->bindParam(':startTime', $departTime, PDO::PARAM_STR);
    $stmt->bindParam(':journeyType', $journeyType, PDO::PARAM_STR);
    $stmt->bindParam(':booking_status', $status, PDO::PARAM_STR);    
    $stmt->bindParam(':booked_date', $booked_date, PDO::PARAM_STR);  // ✅ Corrected name

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


public function get_journey_details($customer_id){
    try {
			$sql = "SELECT * FROM `allops_journey_details` WHERE customer_id = :cid";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':cid', $customer_id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Validation error: " . $e->getMessage();
			return false;
		}
}

public function get_my_carData($carID, $carType, $fuel, $seat) {
    $conditions = [];
    $params = [];

    if ($carID == 0 || $carID === '0') $carID = '';
    if ($carType == 0 || $carType === '0') $carType = '';

    if ($carID !== '') {
        $conditions[] = 'car_id = :car';
        $params[':car'] = $carID;
    } else {
        $conditions[] = "car_id != ''";
    }

    if ($carType !== '') {
        $conditions[] = 'car_type = :carname';
        $params[':carname'] = $carType;
    } else {
        $conditions[] = "car_type != ''";
    }


    if ($fuel !== null && $fuel !== '' && strtolower($fuel) !== 'null') {
    $conditions[] = "fuel_type LIKE :fuel";
    $params[':fuel'] = '%' . $fuel . '%';
} else {
    $conditions[] = "fuel_type != ''";
}

    if ($seat === 'child') $seat = 'Y';
    elseif ($seat === 'adult') $seat = 'N';
    elseif ($seat === 'any' || $seat === '' || $seat === NULL) $seat = null;

    if ($seat === 'Y' || $seat === 'N') {
        $conditions[] = 'child_seat = :child_seat';
        $params[':child_seat'] = $seat;
    }

    $sql = "SELECT * FROM `allops_car_details` WHERE " . implode(' AND ', $conditions) . " LIMIT 1";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    $sqlDebug = $sql;

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function get_pmt_details($customer_id){
    try {
			$sql = "SELECT * FROM `allops_payment_details` WHERE `customer_id` = :cid";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':cid', $customer_id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Validation error: " . $e->getMessage();
			return false;
		}
}


public function  validateLicense($age, $licenseIssued) {
    $today = new DateTime();
    $interval = $today->diff($licenseIssued);
    $licenseYearsAgo = $interval->y;

    if ($age < $licenseYearsAgo) {
        return "Invalid license: Issued too early for the user's age.";
    }
    return null;
}


public function get_myride_history($customer_id){
        try {
			$sql = "SELECT * FROM `allops_journey_details` WHERE customer_id = :cid";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':cid', $customer_id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Validation error: " . $e->getMessage();
			return false;
		}
}



}
$obj = new User($pdo);
?>