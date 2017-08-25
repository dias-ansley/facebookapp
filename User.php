<?php
class User {
	private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "facebookapp";
	private $userTbl    = 'users';
	
	function __construct(){
		if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
	}
	
        /*
         * function to insert or update the data after  login or refresh
         * 
         */
	function checkUser($userData = array()){
		if(!empty($userData)){
			// Check whether user data already exists in database
			$prevQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
			$prevResult = $this->db->query($prevQuery);
			if($prevResult->num_rows > 0){
				// Update user data if already exists
				$query = "UPDATE ".$this->userTbl." SET is_active=1,first_name = '".$userData['first_name']."', picture = '".$userData['picture']."', link = '".$userData['link']."'  WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."' ";
				$update = $this->db->query($query);
			}else{
				// Insert user data
				$query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', first_name = '".$userData['first_name']."',picture = '".$userData['picture']."', link = '".$userData['link']."', created = '".date("Y-m-d H:i:s")."',is_active='".$userData['is_active']."'";
				$insert = $this->db->query($query);
			}
			
			// Get user data from the database
			$result = $this->db->query($prevQuery);
			$userData = $result->fetch_assoc();
		}
		
		// Return user data
		return $userData;
	}
        
        
        /*
         * function  to set is_active to false if app is deauthorized
         * 
         * 
         */
        function updateStatus($userAuthId)
        {
            if(!empty($userAuthId))
            {
                
                $updateQuery="update ".$this->userTbl." set is_active='0' where oauth_uid='".$userAuthId."'";
                
                $this->db->query($updateQuery);
	        
               
            }  
            
            return true;
            
            
        }
        
        
        /*
         * funcion to check is app is still authorized
         * 
         */
        
        function checkAuth($userData)
        {
             if(isset($userData))
             {
                 
                 $authQuery="SELECT is_active from ".$this->userTbl." where oauth_uid=".$userData['oauth_uid']."";
                 $result = $this->db->query($authQuery);
	         $authData = $result->fetch_assoc();
                 
                 $isActive= ($authData['is_active'] == 1) ? true : false;
                 
                 return $isActive;
             }else{
                 return true;
             }
             
            
            
            
        }
}
?>