<!DOCTYPE html>
<head>
<title>Address Validation 0.5</title>
<meta charset="UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.7/jquery.liveaddress.min.js"></script>
<script>
	 jQuery.LiveAddress({
		key: "1504015338857406354",
		autocomplete:10,
		autoVerify:true,
		addresses:[{
				street: '#street',
				city: '#city',
				state: '#state',
				zipcode: '#zip'
			}]
		});
</script>
</head>

<body>
<?php
if(isset($_POST['Submit'])){			
		$Street = $_POST['street'];
		$City = $_POST['city'];
		$State = $_POST['state'];
		$Zip = $_POST['zip'];
		if($Zip){
		include 'db_conn.php';
			$tbl_name="dev"; // Table name 
			// Connect to server and select databse.
			mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
			mysql_select_db("$db_name")or die("cannot select DB");
		$sql="INSERT INTO $tbl_name VALUES ('','$Street','$City','$State','$Zip')"; 
		$result = mysql_query($sql);
		}
}	
?>
<div class="content-wrap">
	<div class="content">
	<div class="title">Address Validation 0.5</div>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<p> <label>Street Address: </label><br>
					<input id="street" name="street" type="text" tabindex="1" ><br>
				</p>
				<p> <label>City: </label><br>
					<input id="city" name="city" type="text" tabindex="2"><br>
				</p>
				<p> <label>State: </label><br>
					<input id="state" name="state" type="text" tabindex="3"><br>
				</p>
				<p>	<label>Zip: </label><br>
					<input id="zip" name="zip" type="text" readonly class="noshow"><br>
				</p>							
				<br/>
				<input type="submit" class="btn" tabindex="4" value="Submit" name="Submit">
		</form>
		<br><br><br>
		<table class="table-res">
				<tr>
					<th>ID</th>
					<th>Street Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
				</tr>
								
<?php
	include 'db_conn.php';
	$tbl_name="dev"; // Table name 
	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	$mysqli = new mysqli($host, $username, $password,$db_name);
	$results = $mysqli->query("SELECT * FROM $tbl_name ORDER BY id DESC");
	if ($results) { 
		//fetch results set as object and output HTML
	   while($obj = $results->fetch_object())
			{?>
				<tr>
					<td><?php echo $obj->id;?></td>
					<td><?php echo $obj->address;?></td>
					<td><?php echo $obj->city;?></td>	
					<td><?php echo $obj->state;?></td>	
					<td><?php echo $obj->zip;?></td>
				</tr>
<?php
			}
	}
?>
		</table>
	</div>								
</div>								
</body>
</html>