<?php
$searched_address1 = $_REQUEST['street'];	//Request  Address 
$searched_city = $_REQUEST['city'];			//Request  City 
$searched_state = $_REQUEST['state'];		//Request  State 

		$searched_address1_pretty = ucwords(strtolower(preg_replace('/\s+/', ' ', trim($searched_address1))));  // trim ends, remove extra space, lower all, capitalize
		$searched_city_pretty = ucwords(strtolower(preg_replace('/\s+/', ' ', trim($searched_city))));   		// trim ends, remove extra space, lower all, capitalize
		$searched_state_pretty = strtoupper(preg_replace('/\s+/', ' ', trim($searched_state)));   				// trim ends, remove extra space, upper all

if(!$searched_address1_pretty == '' AND !$searched_city_pretty == '' AND !$searched_state_pretty == ''){	//if no data inputted  return msg 'Please complete the address.'
		include 'db_conn.php';
		$tbl_name = "dev_suf"; // Table name 
		mysql_connect("$host", "$username", "$password")or die("cannot connect"); 	// Connect to server and select databse.
		mysql_select_db("$db_name")or die("cannot select DB");
		
		for($i = 1; $i<= 286; $i++){								//will remove all the extension from address e.g. Ave or Frwy
			$sql = "SELECT * FROM $tbl_name WHERE id = '$i' ";
			$result = mysql_query($sql);
			$row = mysql_fetch_array ($result);
			$suf = $row['name'];
			$suf = ucwords(strtolower($suf));
			$suf = ' '.$suf.' ';
			$searched_address1_pretty = str_replace($suf, '', $searched_address1_pretty);  
		}
		
		$searched_address1_pretty = trim($searched_address1_pretty);

		$tbl_name = "dev"; // Table name 
		mysql_connect("$host", "$username", "$password")or die("cannot connect"); 	// Connect to server and select database.
		mysql_select_db("$db_name")or die("cannot select DB");
		$sql = "SELECT * FROM $tbl_name WHERE (address LIKE '$searched_address1_pretty %' OR address = '$searched_address1_pretty') AND city = '$searched_city_pretty' AND state = '$searched_state_pretty' ";
		$result = mysql_query($sql);
	$msg_detail = '';

	$count = mysql_num_rows($result);	// Count table rows 
	//echo $searched_address1_pretty;
	if($count >= 1){

		$row = mysql_fetch_array ($result);

		$validated_address1 = $row['address'];
		$validated_city = $row['city'];
		$validated_state = $row['state'];
		$validated_zip = $row['zip'];
		
		$msg_detail = 'validated locally, no API call.';
	}

	if($count == 0){

		$searched_address_url = str_replace(' ', '+', ucwords(preg_replace('/\s+/', ' ', trim($searched_address1))));  					// URL READY
		$searched_city_url = str_replace(' ', '+', ucwords(preg_replace('/\s+/', ' ', trim($searched_city))));  						// URL READY
		$searched_state_url = str_replace(' ', '+', strtoupper(preg_replace('/\s+/', ' ', trim($searched_state))));  					// URL READY

		$url = "https://api.smartystreets.com/street-address?auth-id=5d540c9a-c92c-4718-bccf-3b37fff74a8f&auth-token=8Jp8IZb5oGp3cVoiCpvn&street=".$searched_address_url."&city=".$searched_city_url."&state=".$searched_state_url ;

		$response = file_get_contents($url);
		$ValidAddress = json_decode($response, true);

		$Components = array_map(create_function('$arr', 'return $arr["components"];'), $ValidAddress); 								//array with all the components 

		$ValidStreetAddress = array_map(create_function('$arr', 'return $arr["delivery_line_1"];'), $ValidAddress); 
		$validated_address1 = $ValidStreetAddress[0]; 																			// Valid Street Address
		$ComponentsValues = array_map(create_function('$arr_detail', 'return $arr_detail["city_name"];'), $Components);
		$validated_city =  $ComponentsValues[0];  																				// Valid City 
		$ComponentsValues = array_map(create_function('$arr_detail', 'return $arr_detail["state_abbreviation"];'), $Components);
		$validated_state =  $ComponentsValues[0];																				// Valid State
		$ComponentsValues = array_map(create_function('$arr_detail', 'return $arr_detail["zipcode"];'), $Components);
		$validated_zip =  $ComponentsValues[0];  																				// Valid Zip
		$ComponentsValues = array_map(create_function('$arr_detail', 'return $arr_detail["plus4_code"];'), $Components);
		$plus4_code =  $ComponentsValues[0];  																					// Valid Plus4 Code
		$validated_zip_plus4 = $zip.'-'.$plus4_code;
	
		$msg_detail = 'validated at https://api.smartystreets.com';
	}

	if($validated_zip){

		$msg = 'Valid address. Zip: <b>'.$validated_zip.'</b>';
		//$msg= '';	

		include 'db_conn.php';
			$tbl_name="dev"; // Table name 
			mysql_connect("$host", "$username", "$password")or die("cannot connect");  // Connect to server and select database.
			mysql_select_db("$db_name")or die("cannot select DB");
			$sql="INSERT INTO $tbl_name VALUES ('','$validated_address1','$validated_city','$validated_state','$validated_zip')"; 
			$result = mysql_query($sql);
	}else{
			$msg = 'Invalid address.';
			$msg_detail = '';
	}

}else{
	$msg = 'Please complete the address.';
}
echo '<div class = "msg">'.$msg.' '.$msg_detail.'</div>';
include('table.php');
?>