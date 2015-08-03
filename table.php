<div class="table_div">
<br>
<table>
	<tr>
		<th class="state">ID</th>
		<th class="str">Street Address</th>
		<th class="city">City</th>
		<th class="state">State</th>
		<th class="zip">Zip</th>
	</tr>
<?php
	include 'db_conn.php';
	$tbl_name="dev"; // Table name 
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 	// Connect to server and select databse.
	mysql_select_db("$db_name")or die("cannot select DB");
	$mysqli = new mysqli($host, $username, $password,$db_name);
	$results = $mysqli->query("SELECT * FROM $tbl_name ORDER BY id DESC");
	
	if ($results){ 
			//fetch results set as object and output HTML
			while($obj = $results->fetch_object()){?>
	
	<tr>
		<td ><?php echo $obj->id;?></td>
		<td ><?php echo $obj->address;?></td>
		<td ><?php echo $obj->city;?></td>	
		<td><?php echo $obj->state;?></td>	
		<td><?php echo $obj->zip;?></td>
	</tr>
	
<?php		}
	}
?>
</table>
</div>