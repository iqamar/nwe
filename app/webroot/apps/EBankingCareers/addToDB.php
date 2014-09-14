<?php

if((isset($_GET['email'])) && (isset($_GET['key']))  && (isset($_GET['response'])) ){
	require_once("config.php");
	$mysqli = new mysqli($CONFIG["host"],$CONFIG["login"],$CONFIG["password"],$CONFIG["database"]);
	if (mysqli_connect_errno()) {
	    echo -3;//printf("Connect failed: %s\n", mysqli_connect_error());
	    exit;
	}
	$email = $_GET['email'];
	$password = $_GET['key'];
	$userData = json_decode($_GET["response"]);
	$fullname = $userData->name;

        $arrName = split(" ",$fullname);

        $count = count($arrName);
        $firstName = $arrName[0] ;
        $lastName="";
        if($count>1){
                        for($i=1;$i<$count;$i++){
                                $lastName .=$arrName[$i]." ";
                        }
        }

	$query = "SELECT id,password, varcode, status FROM users WHERE email='".$email."' limit 0,1";
	$result = $mysqli->query($query);
	$row = $result->fetch_array(MYSQLI_BOTH);
	if(is_array($row)){
		$user_id = $row["id"];
		if($user_id > 0){
			echo -2;
			exit;
		}	
	}
	$created = date("Y-m-d H:i:s");

        $mysqli->query("INSERT INTO users(email,password,varcode, role_id, theme_id, register_mode, status, created) VALUES('".$email."','".$password."','52beb2NWE605d3d', '1','1','direct','1','".$created."')");

        $user_id = $mysqli->insert_id;

        $query = "SELECT id FROM countries WHERE name='".$userData->country."' limit 0,1";
        $result = $mysqli->query($query);

        $row = $result->fetch_array(MYSQLI_BOTH);
        $country_id = 0;
        if (isset($row['id'])) {
        	$country_id = $row['id'];
    	}
	$query = "SELECT id FROM industries WHERE title='".$userData->industry."' limit 0,1";
        $result = $mysqli->query($query);

        $row = $result->fetch_array(MYSQLI_BOTH);
        $industry_id = 0;
        if (isset($row['id'])) {
        	$industry_id = $row['id'];
    	}

        $mysqli->query("INSERT INTO users_profiles (user_id,firstname,lastname, birth_date, gender, phone, mobile, city, tags,country_id,industry_id) VALUES('".$user_id."','".$firstName."','".$lastName."','".date("d-m-Y",$userData->birthday)."','".$userData->gender."','".$userData->phone."','".$userData->mobile."','".$userData->city."','".$userData->title."','".$country_id."','".$industry_id."')");
	
	echo 1;
exit;
	
}
echo -3;
//You already have NetworkWE account"
exit;
?>
